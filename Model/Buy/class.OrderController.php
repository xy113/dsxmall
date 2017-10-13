<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/7
 * Time: 下午12:09
 */
namespace Model\Buy;
use Alisms\AlismsApi;
use Core\Validate;
use Data\Cart\CartModel;
use Data\Item\ItemModel;
use Data\Member\AddressModel;
use Data\Shop\ShopModel;
use Data\Trade\OrderActionModel;
use Data\Trade\OrderItemModel;
use Data\Trade\OrderModel;
use Data\Trade\TradeModel;

class OrderController extends BaseController{
    /**
     * 购买确认
     */
    public function index(){

    }

    /**
     * 立即购买
     */
    public function buy_now(){
        global $_G,$_lang;

        $itemid = intval($_GET['itemid']);
        $quantity = intval($_GET['quantity']);
        $pay_type = intval($_GET['pay_type']);
        $shipping_type = intval($_GET['shipping_type']);

        $item = $shop = array();
        $itemModel = new ItemModel();
        $shopModel = new ShopModel();
        if ($itemid && $quantity) {
            $item = $itemModel->where(array('itemid'=>$itemid))->getOne();
            if ($quantity > $item['stock']){
                $this->showError('stock_no_enough');
            }
            $shop = $shopModel->where(array('shop_id'=>$item['shop_id']))->getOne();
        } else{
            $this->showError('can_not_buy');
        }

        if ($this->checkFormSubmit()) {
            //防止重复提交
            if ($_GET['_token_'] !== cookie('_token_')){
                $this->showError('can_not_buy');
            }else {
                cookie('_token_', null);
            }

            $trade_no = createTradeNo();
            $order_no = createOrderNo($this->uid);
            //收货地址
            $address  = (new AddressModel())->where(array('address_id'=>intval($_GET['address_id']), 'uid'=>$this->uid))->getOne();
            $formated_address = $address['province'].$address['city'].$address['county'].$address['street'].' '.$address['postcode'];
            //订单金额
            $order_fee = floatval($item['price']) * $quantity;
            //运费
            $shipping_fee = $item['shipping_fee'];
            //总金额
            $total_fee = $order_fee + $shipping_fee;
            //支付方式
            $pay_type = $pay_type == 2 ? 2 : 1;
            if ($pay_type == 1){//在线支付
                //创建订单
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
                    'receive_status'=>0,
                    'review_status'=>0,
                    'shipping_status'=>0,
                    'consignee'=>$address['consignee'],
                    'phone'=>$address['phone'],
                    'address'=>$formated_address,
                    'trade_no'=>$trade_no,
                    'remark'=>trim($_GET['remark'])
                ))->add();
                //创建订单操作记录
                (new OrderActionModel())->data(array(
                    'uid'=>$this->uid,
                    'username'=>$this->username,
                    'order_id'=>$order_id,
                    'action_name'=>L('checkout_success'),
                    'action_time'=>time()
                ))->add();
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
            }else {//货到付款
                //创建订单
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
                    'receive_status'=>0,
                    'review_status'=>0,
                    'shipping_status'=>0,
                    'consignee'=>$address['consignee'],
                    'phone'=>$address['phone'],
                    'address'=>$formated_address,
                    'trade_no'=>$trade_no,
                    'remark'=>htmlspecialchars($_GET['remark']),
                    'is_commited'=>1,
                    'is_accepted'=>0
                ))->add();
                //创建订单操作记录
                (new OrderActionModel())->data(array(
                    'uid'=>$this->uid,
                    'username'=>$this->username,
                    'order_id'=>$order_id,
                    'action_name'=>L('order_commited'),
                    'action_time'=>time()
                ))->add();
            }

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

            $itemModel->where(array('itemid'=>$itemid))->data("`sold`=`sold`+$quantity,`stock`=`stock`-$quantity")->save();
            $shopModel->where(array('shop_id'=>$shop['shop_id']))->data("`total_sold`=`total_sold`+$quantity")->save();
            //发送短息提醒
            if (Validate::ismobile($shop['phone'])){
                $smsapi = new AlismsApi();
                $smsapi->sendSms('粗耕', setting('sms_tpl_create_order'), $shop['phone'], array('order_no'=>$order_no));
            }
            if ($pay_type == 1){
                $this->redirect(U('c=pay&order_id='.$order_id));
            }else {
                $this->redirect(U('c=commit&order_id='.$order_id));
            }
        }else {
            cookie('_token_', md5_16(random(10)));
            $total_fee = floatval($item['price']) * $quantity;

            $_G['step'] = 'confirm_order';
            $_G['title'] = $_lang['confirm_order'];
            include template('buy_now');
        }
    }

    /**
     * 购物车结算
     */
    public function confirm_order(){
        global $_G,$_lang;

        $itemids = 0;
        $items = $_GET['items'];
        $order_item_list = array();
        $cartModel = new CartModel();
        if ($items && is_array($items)) {
            $itemids = implodeids($items);
            $cart_item_list = $cartModel->where(array('uid'=>$this->uid, 'itemid'=>array('IN', $itemids)))->select();
            $order_item_list = array();
            foreach ($cart_item_list as $item){
                $order_item_list[$item['itemid']]['quantity']  = $item['quantity'];
                $order_item_list[$item['itemid']]['shop_id']   = $item['shop_id'];
                $order_item_list[$item['itemid']]['shop_name'] = $item['shop_name'];
            }
            unset($cart_item_list, $item, $items);
        }else{
            $this->showError('can_not_buy');
        }

        $total_count = $total_fee = 0;
        if ($order_item_list) {
            $new_item_list = array();
            $fields = 'itemid,uid,shop_id,price,shipping_fee,title,image,thumb';
            $itemlist = (new ItemModel())->where(array('itemid'=>array('IN', $itemids)))->field($fields)->select();
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
                $total_count+= $item['quantity'];
                $total_fee+= $item['order_fee']+$item['shipping_fee'];
            }
            $order_item_list = $datalist;
            unset($datalist, $item);
        }else {
            $this->showError('can_not_buy');
        }

        if ($this->checkFormSubmit()) {
            //防止重复提交
            if ($_GET['_token_'] !== cookie('_token_')){
                $this->showError('can_not_buy');
            }else {
                cookie('_token_', null);
            }
            $shipping_type = intval($_GET['shipping_type']);
            $pay_type = intval($_GET['pay_type']) == 2 ? 2 : 1;
            $remark_list = $_GET['remark_list'];

            //收货地址
            $address = (new AddressModel())->where(array('address_id'=>intval($_GET['address_id']), 'uid'=>$this->uid))->getOne();
            $formated_address = $address['province'].$address['city'].$address['county'].$address['street'].' '.$address['postcode'];
            //创建订单
            foreach ($order_item_list as $shop_id=>$order) {
                $trade_no = createTradeNo();
                $order_no = createOrderNo($this->uid);
                //
                $shop = (new ShopModel())->where(array('shop_id'=>$shop_id))->getOne();
                //订单金额
                $order_fee = floatval($order['order_fee']);
                //运费
                $shipping_fee = $order['shipping_fee'];
                //总金额
                $order_total_fee = $order_fee + $shipping_fee;
                //创建订单
                $is_commited = $pay_type == 2 ? 1 : 0;
                $order_id = (new OrderModel())->data(array(
                    'buyer_uid'=>$this->uid,
                    'buyer_name'=>$this->username,
                    'seller_uid'=>$shop['uid'],
                    'seller_name'=>$shop['username'],
                    'shop_id'=>$order['shop_id'],
                    'shop_name'=>$order['shop_name'],
                    'order_no'=>$order_no,
                    'order_fee'=>$order_fee,
                    'shipping_fee'=>$shipping_fee,
                    'total_fee'=>$order_total_fee,
                    'create_time'=>time(),
                    'pay_type'=>$pay_type,
                    'shipping_type'=>$shipping_type,
                    'pay_status'=>0,
                    'shipping_status'=>0,
                    'receive_status'=>0,
                    'review_status'=>0,
                    'consignee'=>$address['consignee'],
                    'phone'=>$address['phone'],
                    'address'=>$formated_address,
                    'trade_no'=>$trade_no,
                    'remark'=>$remark_list[$shop_id],
                    'is_commited'=>$is_commited,
                    'is_accepted'=>0
                ))->add();

                $shop_total_sold = 0;
                $trade_name = '';
                foreach ($order['items'] as $itemid=>$item){
                    //记录订单商品信息
                    if (!$trade_name) $trade_name = $item['title'];
                    (new OrderItemModel())->data(array(
                        'uid'=>$this->uid,
                        'order_id'=>$order_id,
                        'itemid'=>$itemid,
                        'title'=>$item['title'],
                        'price'=>$item['price'],
                        'quantity'=>$item['quantity'],
                        'thumb'=>$item['thumb'],
                        'image'=>$item['image'],
                        'shipping_fee'=>$item['shipping_fee'],
                        'total_fee'=>$item['price']*$item['quantity']+$item['shipping_fee']
                    ))->add();
                    (new ItemModel())->where(array('itemid'=>$itemid))
                        ->data("`sold`=`sold`+".$item['quantity'].",`stock`=`stock`-".$item['quantity'])->save();
                    $shop_total_sold+= $item['quantity'];

                }
                (new ShopModel())->where(array('shop_id'=>$shop_id))->where("`total_sold`=`total_sold`+$shop_total_sold")->save();

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
                    if ($shop_total_sold > 1){
                        $trade_name = sprintf(L('trade_name_formater'), $trade_name, $shop_total_sold);
                    }
                    (new TradeModel())->data(array(
                        'payer_uid'=>$this->uid,
                        'payer_name'=>$this->username,
                        'payee_uid'=>$seller['uid'],
                        'payee_name'=>$seller['username'],
                        'trade_no'=>$trade_no,
                        'trade_name'=>$trade_name,
                        'trade_desc'=>$trade_name,
                        'trade_fee'=>$order_total_fee,
                        'trade_type'=>'SHOPPING',
                        'trade_status'=>'UNPAID',
                        'trade_time'=>time(),
                        'out_trade_no'=>$trade_no
                    ))->add();
                }
            }

            $cartModel->where(array('uid'=>$this->uid, 'itemid'=>array('IN', $itemids)))->delete();
            $this->redirect(U('m=member&c=order&a=itemlist'));
        }else {
            cookie('_token_', md5_16(random(10)));

            $_G['step'] = 'confirm_order';
            $_G['title'] = $_lang['confirm_order'];
            include template('confirm_order');
        }
    }
}