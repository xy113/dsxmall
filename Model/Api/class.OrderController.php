<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/28
 * Time: 下午4:54
 */

namespace Model\Api;

use Data\Item\ItemModel;
use Data\Member\AddressModel;
use Data\Member\MemberModel;
use Data\Shop\ShopModel;
use Data\Trade\Object\OrderObject;
use Data\Trade\OrderActionModel;
use Data\Trade\OrderItemModel;
use Data\Trade\OrderModel;
use Data\Trade\TradeModel;
use Data\Trade\WalletModel;

class OrderController extends BaseController
{
    /**
     * OrderController constructor.
     */
    function __construct()
    {
        parent::__construct();
        if (!$this->uid || !$this->username){
            $this->showAjaxError(1, 'Not Login');
        }
    }

    /**
     * 创建订单
     */
    public function create(){
        $itemid = intval($_GET['itemid']);
        $quantity = intval($_GET['quantity']);
        if (!$itemid) $itemid = intval($_GET['goods_id']);
        if (!$quantity) $quantity = intval($_GET['goods_number']);
        $shipping_type = intval($_GET['shipping_type']);
        $pay_type = intval($_GET['pay_type']) == 3 ? 2 : 1;

        $item = $shop = array();
        $itemModel = new ItemModel();
        $shopModel = new ShopModel();
        if ($itemid && $quantity) {
            $item = $itemModel->where(array('itemid'=>$itemid))->getOne();
            $shop = $shopModel->where(array('shop_id'=>$item['shop_id']))->getOne();
        } else{
            $this->showAjaxError(1,'can_not_buy');
        }

        $trade_no = createTradeNo();
        $order_no = createOrderNo($this->uid);
        //收货地址
        $address  = (new AddressModel())->where(array('uid'=>$this->uid,'address_id'=>intval($_GET['address_id'])))->getOne();
        //订单金额
        $order_fee = floatval($item['price']) * $quantity;
        //运费
        $shipping_fee = $item['shipping_fee'];
        //总金额
        $total_fee = $order_fee + $shipping_fee;
        //创建订单
        $is_commited = $pay_type == 2 ? 1 : 0;
        $order_id = (new OrderModel())->data(array(
            'buyer_uid'=>$this->uid,
            'buyer_name'=>$this->username,
            'seller_uid'=>$shop['uid'],
            'seller_name'=>$shop['username'],
            'shop_id'=>$shop['shop_id'],
            'shop_name'=>$shop['shop_name'],
            'order_no'=>$order_no,
            'order_fee'=>$order_fee,
            'shipping_fee'=>$shipping_fee,
            'total_fee'=>$total_fee,
            'create_time'=>time(),
            'pay_type'=>$pay_type,
            'shipping_type'=>$shipping_type,
            'pay_status'=>0,
            'shipping_status'=>0,
            'receive_status'=>0,
            'review_status'=>0,
            'consignee'=>$address['consignee'],
            'phone'=>$address['phone'],
            'address'=>$address['province'].$address['city'].$address['county'].$address['street'].' '.$address['postcode'],
            'trade_no'=>$trade_no,
            'remark'=>htmlspecialchars($_GET['remark']),
            'is_commited'=>$is_commited,
            'is_accepted'=>0
        ))->add();
        //记录订单商品信息
        (new OrderItemModel())->data(array(
            'uid'=>$this->uid,
            'order_id'=>$order_id,
            'itemid'=>$item['itemid'],
            'title'=>$item['title'],
            'price'=>$item['price'],
            'quantity'=>$quantity,
            'thumb'=>$item['thumb'],
            'image'=>$item['image'],
            'shipping_fee'=>$shipping_fee,
            'total_fee'=>$total_fee
        ))->add();
        //创建订单操作记录
        (new OrderActionModel())->data(array(
            'uid'=>$this->uid,
            'username'=>$this->username,
            'order_id'=>$order_id,
            'action_name'=>$pay_type == 1 ? L('checkout_success') : L('order_commited'),
            'action_time'=>time()
        ))->add();

        if ($pay_type == 1){
            //创建支付流水
            (new TradeModel())->data(array(
                'payer_uid'=>$this->uid,
                'payer_name'=>$this->username,
                'payee_uid'=>$shop['uid'],
                'payee_name'=>$shop['username'],
                'trade_no'=>$trade_no,
                'trade_name'=>$item['title'],
                'trade_desc'=>$item['title'],
                'trade_fee'=>$total_fee,
                'trade_type'=>'SHOPPING',
                'trade_status'=>'UNPAID',
                'trade_time'=>time(),
                'out_trade_no'=>$trade_no
            ))->add();
        }
        $itemModel->where(array('itemid'=>$itemid))->data("`sold`=`sold`+$quantity,`stock`=`stock`-$quantity")->save();
        $shopModel->where(array('shop_id'=>$shop['shop_id']))->data("`total_sold`=`total_sold`+$quantity")->save();
        $this->showAjaxReturn(array('order_id'=>$order_id));
    }

    /**
     * 获取订单详情
     */
    public function get(){

        $order_id = intval($_GET['order_id']);
        $order = (new OrderModel())->where(array('buyer_uid'=>$this->uid, 'order_id'=>$order_id))->getOne();
        if ($order) {
            $order['create_time'] = date('Y-m-d H:i:s', $order['create_time']);
            $item = (new OrderItemModel())->where(array('order_id'=>$order_id))->getOne();
            $item['name'] = $item['title'];
            $item['goods_name'] = $item['title'];
            $item['goods_number'] = $item['quantity'];
            $this->showAjaxReturn(array(
                'item'=>$item,
                'order'=>$order
            ));
        }else {
            $this->showAjaxError(1, 'order_not_exists');
        }
    }

    /**
     * 获取订单列表
     */
    public function batchget(){
        $offset = $_GET['offset'] ? intval($_GET['offset']) : 0;
        $count = $_GET['count'] ?intval($_GET['count']) : 20;
        $order_status = $_GET['order_status'] ? trim($_GET['order_status']) : 'all';

        $condition = array('buyer_uid'=>$this->uid);

        $orderList = array();
        foreach (OrderModel::getInstance()->where($condition)->order('order_id', 'DESC')->select() AS $order){
            $orderList[$order['order_id']] = $order;
        }

        $orderIds = $orderList ? array_column($orderList, 'order_id') : 0;
        if ($orderIds) {
            $orderIds = implodeids($orderIds);
            foreach (OrderItemModel::getInstance()->where("`order_id` IN($orderIds)")->select() as $item){
                $item['thumb'] = image($item['thumb']);
                $item['image'] = image($item['image']);
                $orderList[$item['order_id']]['items'][] = $item;
            }
        }
        $this->showAjaxReturn(array_values($orderList));
    }

    /**
     * 更新订单信息
     */
    public function update(){
        $order_id = intval($_GET['order_id']);
        $order = $_GET['order'];
        if ($order_id && is_array($order)) {
            $orderObj = new OrderObject($order);
            OrderModel::getInstance()->where(array('uid'=>$this->uid,'order_id'=>$order_id))->data($orderObj->getBizContent())->save();
            $this->showAjaxReturn();
        }else {
            $this->showAjaxError(1, 'invalid parameter');
        }
    }

    /**
     * 删除订单
     */
    public function delete(){
        $order_id = intval($_GET['order_id']);
        $condition = array('order_id'=>$order_id);
        if (OrderModel::getInstance()->where($condition)->count()){
            OrderModel::getInstance()->deleteAllData($order_id);
            $this->showAjaxReturn(array('order_id'=>$order_id));
        }else {
            $this->showAjaxError(1, 'order not exists');
        }
    }

    /**
     * 支付订单
     */
    public function pay(){

        $order_id = intval($_GET['order_id']);
        $pay_type = intval($_GET['pay_type']);
        $orderModel = new OrderModel();
        $order = $orderModel->where(array('order_id'=>$order_id, 'buyer_uid'=>$this->uid))->getOne();
        if (!$order) {
            $this->showAjaxError(1, 'order_not_exists');
        }
        if ($order['pay_status'] != 0){
            $this->showAjaxError(2, 'order_have_been_paid');
        }

        if ($pay_type == 1){
            //余额支付
            $walletModel = new WalletModel();
            $wallet = $walletModel->getWallet($this->uid);
            /*$member = member_get_data(array('uid'=>$this->uid), 'password');
            if ($member['password'] !== getPassword($password)){
                $this->showAjaxError('FAIL','password_incorrect');
            }*/

            if ($wallet['balance'] < $order['total_fee']){
                $this->showAjaxError(3, 'balance_not_enough');
            }

            if ($walletModel->deduction($this->uid, $order['total_fee'])){
                $orderModel->where(array('order_id'=>$order_id))->data(array('pay_type'=>1, 'pay_status'=>1, 'pay_time'=>time()))->save();
                $tradeModel = new TradeModel();
                $tradeModel->where(array('trade_no'=>$order['trade_no']))->data(array('pay_type'=>'balance', 'pay_status'=>'1'))->save();
                $this->showAjaxReturn(array('order_id'=>$order_id));
            }else {
                $this->showAjaxError(4, 'balance_not_enough');
            }
        }

        $this->showAjaxError(-1, 'pay_failed');
    }

    /**
     * 提醒卖家发货
     */
    public function notice(){
        $this->showAjaxReturn();
    }

    /**
     * 确认订单
     */
    public function confirm(){
        $order_id = intval($_GET['order_id']);
        $password = trim($_GET['password']);
        $orderModel = new OrderModel();
        $order = $orderModel->where(array('order_id'=>$order_id, 'buyer_uid'=>$this->uid))->getOne();
        if ($order) {
            //验证密码
            $member = (new MemberModel())->where(array('uid'=>$this->uid))->field('password')->getOne();
            if ($member['password'] !== getPassword($password)){
                $this->showAjaxError(1, 'password_incorrect');
            }
            //验证订单状态
            if ($order['is_closed'] == 0 && $order['pay_type'] == 1 && $order['pay_status'] == 1 && $order['shipping_status'] == 1){
                $orderModel->where(array('order_id'=>$order_id))->data(array('receive_status'=>1, 'deal_time'=>time()))->save();
                (new WalletModel())->increase($order['seller_uid'], $order['total_fee']);
            }
            $this->showAjaxReturn();
        }else {
            $this->showAjaxError(2, 'order_not_exists');
        }
    }
}