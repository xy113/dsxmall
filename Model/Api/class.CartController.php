<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/29
 * Time: 下午1:41
 */

namespace Model\Api;

use Data\Cart\CartModel;
use Data\Item\ItemModel;
use Data\Member\AddressModel;
use Data\Member\MemberModel;
use Data\Shop\ShopModel;
use Data\Trade\Builder\OrderContentBuilder;
use Data\Trade\Builder\TradeContentBuilder;
use Data\Trade\Object\OrderActionObject;
use Data\Trade\Object\OrderItemObject;
use Data\Trade\Object\OrderObject;
use Data\Trade\Object\TradeObject;
use Data\Trade\OrderActionModel;
use Data\Trade\OrderItemModel;
use Data\Trade\OrderModel;
use Data\Trade\TradeModel;

class CartController extends BaseController
{
    /**
     * 添加到购物车
     */
    public function add(){
        $itemid = intval($_GET['itemid']);
        $quantity = intval($_GET['quantity']);
        if (!$itemid) $itemid = intval($_GET['goods_id']);
        if (!$quantity) $quantity = intval($_GET['goods_number']);

        $cartModel = new CartModel();
        $itemModel = new ItemModel();
        $item = $itemModel->where(array('itemid'=>$itemid))->getOne();
        if ($item) {
            if ($cartModel->where(array('uid'=>$this->uid, 'itemid'=>$itemid))->count()){
                $cartModel->where(array('uid'=>$this->uid, 'itemid'=>$itemid))->data("`quantity`=`quantity`+".$quantity)->save();
            }else {
                $shop = (new ShopModel())->where(array('shop_id'=>$item['shop_id']))->getOne();
                $cartModel->data(array(
                    'uid'=>$this->uid,
                    'shop_id'=>$shop['shop_id'],
                    'shop_name'=>$shop['shop_name'],
                    'itemid'=>$itemid,
                    'quantity'=>$quantity,
                    'title'=>$item['title'],
                    'price'=>$item['price'],
                    'thumb'=>$item['thumb'],
                    'image'=>$item['image'],
                    'create_time'=>time()
                ))->add();
            }

            $this->showAjaxReturn();
        }else {
            $this->showAjaxError(1, 'item_not_exists');
        }
    }

    /**
     * 从购物测删除宝贝
     */
    public function delete(){
        $itemid = intval($_GET['itemid']);
        CartModel::getInstance()->where(array('itemid'=>$itemid, 'uid'=>$this->uid))->delete();
        $this->showAjaxReturn();
    }

    /**
     * 更新宝贝信息
     */
    public function update(){
        $itemid = intval($_GET['itemid']);
        $item = $_GET['item'];

        if ($itemid && is_array($item)) {
            CartModel::getInstance()->where(array('itemid'=>$itemid,'uid'=>$this->uid))->data($item)->save();
            $this->showAjaxReturn();
        }else {
            $this->showAjaxError(1, 'invalid_parameter');
        }
    }

    /**
     * 获取购物车商品列表
     */
    public function get_item_list(){
        $fileds = 'c.itemid,c.title,c.shop_id,c.shop_name,c.quantity,c.thumb,c.image,i.price,i.title AS ori_title';
        $itemlist = M('cart c')->join('item i', 'i.itemid=c.itemid')->field($fileds)->where("c.uid=".$this->uid)->select();
        $cartItemList = array();
        foreach ($itemlist as $item){
            if (!$item['ori_title']) {
                CartModel::getInstance()->where(array('itemid'=>$item['itemid'], 'uid'=>$this->uid))->delete();
            }else {
                unset($item['ori_title']);
                $item['thumb'] = image($item['thumb']);
                $item['image'] = image($item['image']);

                $cartItemList[$item['shop_id']]['shop_id'] = $item['shop_id'];
                $cartItemList[$item['shop_id']]['shop_name'] = $item['shop_name'];
                $cartItemList[$item['shop_id']]['items'][] = array(
                    'itemid'=>$item['itemid'],
                    'quantity'=>$item['quantity'],
                    'thumb'=>image($item['thumb']),
                    'image'=>image($item['image']),
                    'price'=>$item['price'],
                    'title'=>$item['title']
                );
            }
        }
        $this->showAjaxReturn(array_values($cartItemList));
    }

    /**
     * 获取结算商品
     */
    public function get_settle_items(){
        $itemids = $_GET['itemids'];
        if (!$itemids) $itemids = $_GET['items'];
        $cart_item_list = array();
        if (is_array($itemids)) $itemids = implode(',', $itemids);

        $cartModel = new CartModel();
        if (!$itemids || empty($itemids)){
            $this->showAjaxError(1, 'can_not_buy');
        }else {
            $cart_item_list = $cartModel->where(array('uid'=>$this->uid, 'itemid'=>array('IN', $itemids)))->select();
        }

        $total_num = $total_fee = 0;
        if ($cart_item_list) {
            $price_list = array();
            $itemlist = (new ItemModel())->where(array('itemid'=>array('IN', $itemids)))->field('itemid, price')->select();
            foreach ($itemlist as $item){
                $price_list[$item['itemid']] = $item['price'];
            }
            $datalist = array();
            foreach ($cart_item_list as $cartitem){
                $cartitem['price'] = $price_list[$cartitem['itemid']];
                $cartitem['goods_price'] = $cartitem['price'];
                $cartitem['formated_price'] = formatAmount($cartitem['price']);

                $cartitem['thumb'] = image($cartitem['thumb']);
                $cartitem['goods_thumb'] = $cartitem['thumb'];
                $cartitem['goods_number'] = $cartitem['quantity'];
                $cartitem['total_fee'] = floatval($cartitem['price']) * intval($cartitem['quantity']);
                $datalist[$cartitem['shop_id']]['shop_id'] = $cartitem['shop_id'];
                $datalist[$cartitem['shop_id']]['shop_name'] = $cartitem['shop_name'];
                $datalist[$cartitem['shop_id']]['simple_fee']+= $cartitem['total_fee'];
                $datalist[$cartitem['shop_id']]['simple_num']+= intval($cartitem['quantity']);
                $datalist[$cartitem['shop_id']]['items'][] = $cartitem;
                $total_num+= $cartitem['quantity'];
                $total_fee+= floatval($cartitem['price']) * intval($cartitem['quantity']);
            }
            $cart_item_list = $datalist;
            unset($datalist, $cartitem);
            $this->showAjaxReturn(array(
                'total_num'=>$total_num,
                'total_fee'=>$total_fee,
                'items'=>array_values($cart_item_list)
            ));
        }else {
            $this->showAjaxError(1,'can_not_buy');
        }
    }

    /**
     * 订单结算
     */
    public function settlement(){
        $orders = stripslashes(trim($_GET['orders']));
        $order_list = json_decode($orders, true);
        $itemids = array();
        if (is_array($order_list)) {
            $datalist = array();
            foreach ($order_list as $order){
                $itemids = array_merge($itemids, (array)$order['itemids']);
                unset($order['itemids']);
                $order['shop_id'] = intval($order['shop_id']);
                $datalist[$order['shop_id']] = $order;
            }
            $order_list = $datalist;
            unset($datalist, $order);
        }

        $order_item_list = $new_item_list = array();
        $itemids = $itemids ? implodeids($itemids) : 0;

        $cartModel = new CartModel();
        $cart_item_list = $cartModel->where(array('uid'=>$this->uid, 'itemid'=>array('IN', $itemids)))->select();
        if ($cart_item_list) {
            foreach ($cart_item_list as $item){
                $order_item_list[$item['itemid']]['quantity']  = $item['quantity'];
                $order_item_list[$item['itemid']]['shop_id']   = $item['shop_id'];
                $order_item_list[$item['itemid']]['shop_name'] = $item['shop_name'];
            }
            unset($cart_item_list, $item, $items);
        }else {
            $this->showAjaxError(1, '没有选择结算商品');
        }

        $itemModel = new ItemModel();
        $fields = 'itemid,uid,shop_id,price,shipping_fee,title,image,thumb';
        $itemlist = $itemModel->where(array('itemid'=>array('IN', $itemids)))->field($fields)->select();
        foreach ($itemlist as $item){
            $new_item_list[$item['itemid']]['uid']  = $item['uid'];
            $new_item_list[$item['itemid']]['itemid'] = $item['itemid'];
            $new_item_list[$item['itemid']]['price']  = $item['price'];
            $new_item_list[$item['itemid']]['title']  = $item['title'];
            $new_item_list[$item['itemid']]['image']  = $item['image'];
            $new_item_list[$item['itemid']]['thumb']  = $item['thumb'];
            $new_item_list[$item['itemid']]['shipping_fee'] = $item['shipping_fee'];
            $new_item_list[$item['itemid']]['quantity']  = $order_item_list[$item['itemid']]['quantity'];
            $new_item_list[$item['itemid']]['shop_id']   = $order_item_list[$item['itemid']]['shop_id'];
            $new_item_list[$item['itemid']]['shop_name'] = $order_item_list[$item['itemid']]['shop_name'];
        }
        $order_item_list = $new_item_list;
        unset($itemlist, $item, $new_item_list);

        $datalist = array();
        foreach ($order_item_list as $item){
            $item['order_fee'] = floatval($item['price']) * intval($item['quantity']);
            $datalist[$item['shop_id']]['uid'] = $item['uid'];
            $datalist[$item['shop_id']]['shop_id'] = $item['shop_id'];
            $datalist[$item['shop_id']]['shop_name'] = $item['shop_name'];
            $datalist[$item['shop_id']]['order_fee']+= $item['order_fee'];
            $datalist[$item['shop_id']]['shipping_fee']+= $item['shipping_fee'];
            $datalist[$item['shop_id']]['items'][$item['itemid']] = $item;
        }
        $order_item_list = $datalist;
        unset($datalist, $item);

        if ($order_list) {
            foreach ($order_list as $order){
                if (isset($order_item_list[$order['shop_id']])){
                    $order_item_list[$order['shop_id']]['pay_type'] = $order['pay_type'];
                    $order_item_list[$order['shop_id']]['shipping_type'] = $order['shipping_type'];
                    $order_item_list[$order['shop_id']]['remark'] = $order['remark'];
                }
            }
            unset($order_list, $order);
        }

        //收货地址
        $address = (new AddressModel())->where(array('uid'=>$this->uid,'address_id'=>intval($_GET['address_id'])))->getOne();
        if (!$address) {
            $address = (new AddressModel())->where(array('uid'=>$this->uid,'isdefault'=>1))->getOne();
        }
        $formated_address = $address['province'].$address['city'].$address['county'].$address['street'].' '.$address['postcode'];
        //创建订单
        $orderModel = new OrderModel();
        $tradeModel = new TradeModel();
        foreach ($order_item_list as $shop_id=>$order) {
            $trade_no = createTradeNo();
            $order_no = createOrderNo($this->uid);
            //卖家信息
            $seller = (new MemberModel())->where(array('uid'=>$order['uid']))->field('uid,username')->getOne();
            //订单金额
            $order_fee = floatval($order['order_fee']);
            //运费
            $shipping_fee = $order['shipping_fee'];
            //总金额
            $order_total_fee = $order_fee + $shipping_fee;
            //创建订单
            $is_commited = $order['pay_type'] == 2 ? 1 : 0;
            //创建订单
            $orderObj = new OrderObject();
            $orderObj->setBuyerUid($this->uid);
            $orderObj->setBuyerName($this->username);
            $orderObj->setSellerUid($seller['uid']);
            $orderObj->setSellerName($seller['username']);
            $orderObj->setShopId($order['shop_id']);
            $orderObj->setShopName($order['shop_name']);
            $orderObj->setOrderNo($order_no);
            $orderObj->setOrderFee($order_fee);
            $orderObj->setShippingFee($shipping_fee);
            $orderObj->setTotalFee($order_total_fee);
            $orderObj->setCreateTime(time());
            $orderObj->setPayType($order['pay_type']);
            $orderObj->setShippingType($order['shipping_type']);
            $orderObj->setPayStatus(0);
            $orderObj->setShippingStatus(0);
            $orderObj->setReceiveStatus(0);
            $orderObj->setConsignee($address['consignee']);
            $orderObj->setPhone($address['phone']);
            $orderObj->setAddress($formated_address);
            $orderObj->setTradeNo($trade_no);
            $orderObj->setRemark($order['remark']);
            $orderObj->setIsCommited($is_commited);
            $orderObj->setIsAccepted(0);

            $order_id = 0;
            try{
                $order_id = $orderModel->addObject($orderObj);
            }catch (\Exception $e) {
                $this->showAjaxError(1, $e->getMessage());
            }

            $trade_name = '';
            $shop_total_sold = 0;
            foreach ($order['items'] as $itemid=>$item){
                //记录订单商品信息
                if (!$trade_name) $trade_name = $item['title'];
                $itemObj = new OrderItemObject();
                $itemObj->setUid($this->uid)
                    ->setOrderId($order_id)
                    ->setItemid($itemid)
                    ->setTitle($item['title'])
                    ->setPrice($item['price'])
                    ->setQuantity($item['quantity'])
                    ->setThumb($item['thumb'])
                    ->setImage($item['image'])
                    ->setShippingFee($item['shipping_fee'])
                    ->setTotalFee($item['price']*$item['quantity']+$item['shipping_fee']);

                try {
                    OrderItemModel::getInstance()->addObject($itemObj);
                }catch (\Exception $e){
                    $this->showAjaxError(2, $e->getMessage());
                }

                //更新销量并减库存
                ItemModel::getInstance()->where(array('itemid'=>$itemid))
                    ->data("`sold`=`sold`+".$item['quantity'].",`stock`=`stock`-".$item['quantity'])->save();
                $shop_total_sold+= $item['quantity'];
            }
            //更新店铺销量
            ShopModel::getInstance()->where(array('shop_id'=>$shop_id))->data("`total_sold`=`total_sold`+$shop_total_sold")->save();

            //创建订单操作记录
            $actionObj = new OrderActionObject();
            $actionObj->setUid($this->uid)
                ->setUsername($this->username)
                ->setOrderId($order_id)
                ->setActionName($order['pay_type'] == 1 ? L('checkout_success') : L('order_commited'))
                ->setActionTime(time());
            try {
                OrderActionModel::getInstance()->addObject($actionObj);
            }catch (\Exception $e){
                $this->showAjaxError(3, $e->getMessage());
            }


            if ($order['pay_type'] == 1){
                //创建支付流水
                if ($shop_total_sold > 1){
                    $trade_name = sprintf(L('trade_name_formater'), $trade_name, $shop_total_sold);
                }

                $tradeObj = new TradeObject();
                $tradeObj->setPayerUid($this->uid)
                    ->setPayerName($this->username)
                    ->setPayeeUid($seller['uid'])
                    ->setPayeeName($seller['username'])
                    ->setTradeNo($trade_no)
                    ->setTradeName($trade_name)
                    ->setTradeDesc($trade_name)
                    ->setTradeFee($order_total_fee)
                    ->setTradeType('SHOPPING')
                    ->setTradeTime(time())
                    ->setOutTradeNo($trade_no)
                    ->setPayStatus(0);

                try{
                    $tradeModel->addObject($tradeObj);
                }catch (\Exception $e) {
                    $this->showAjaxError(4, $e->getMessage());
                }
            }
        }

        $cartModel->where(array('itemid'=>array('IN', $itemids)))->delete();
        $this->showAjaxReturn();
    }
}