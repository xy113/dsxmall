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
use Data\Shop\ShopModel;
use Data\Trade\Builder\OrderContentBuilder;
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
     * 获取结算商品
     */
    public function get_settle_items(){
        $itemids = $_GET['itemids'];
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
                if (isset($shop_list[$order['shop_id']])){
                    $order_item_list[$order['shop_id']]['pay_type'] = $order['pay_type'];
                    $order_item_list[$order['shop_id']]['shipping_type'] = $order['shipping_type'];
                    $order_item_list[$order['shop_id']]['remark'] = $order['remark'];
                }
            }
            unset($order_list, $order);
        }

        //收货地址
        $address = (new AddressModel())->where(array('address_id'=>intval($_GET['address_id'])))->getOne();
        $formated_address = $address['province'].$address['city'].$address['county'].$address['street'].' '.$address['postcode'];
        //创建订单
        $orderModel = new OrderModel();
        $tradeModel = new TradeModel();
        foreach ($order_item_list as $shop_id=>$order) {
            $trade_no = createTradeNo();
            $order_no = createOrderNo($this->uid);
            //卖家信息
            $seller = member_get_data(array('uid'=>$order['uid']), 'uid,username');
            //订单金额
            $order_fee = floatval($order['order_fee']);
            //运费
            $shipping_fee = $order['shipping_fee'];
            //总金额
            $order_total_fee = $order_fee + $shipping_fee;
            //创建订单
            $is_commited = $order['pay_type'] == 2 ? 1 : 0;

            $orderObject = new OrderContentBuilder();
            $orderObject->setBuyer_uid($this->uid);
            $orderObject->setBuyer_name($this->username);
            $orderObject->setSeller_uid($seller['uid']);

            $order_id = order_add_data(array(
                'buyer_uid'=>$this->uid,
                'buyer_name'=>$this->username,
                'seller_uid'=>$seller['uid'],
                'seller_name'=>$seller['username'],
                'shop_id'=>$order['shop_id'],
                'shop_name'=>$order['shop_name'],
                'order_no'=>$order_no,
                'order_fee'=>$order_fee,
                'shipping_fee'=>$shipping_fee,
                'total_fee'=>$order_total_fee,
                'create_time'=>time(),
                'pay_type'=>$order['pay_type'],
                'shipping_type'=>$order['shipping_type'],
                'pay_status'=>0,
                'shipping_status'=>0,
                'receive_status'=>0,
                'review_status'=>0,
                'consignee'=>$address['consignee'],
                'phone'=>$address['phone'],
                'address'=>$formated_address,
                'trade_no'=>$trade_no,
                'remark'=>$order['remark'],
                'is_commited'=>$is_commited,
                'is_accepted'=>0
            ));

            $shop_total_sold = 0;
            $trade_name = '';
            foreach ($order['items'] as $itemid=>$item){
                //记录订单商品信息
                if (!$trade_name) $trade_name = $item['name'];
                order_add_item(array(
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
                ));
                item_update_data(array('itemid'=>$itemid), "`sold`=`sold`+".$item['quantity'].",`stock`=`stock`-".$item['quantity']);
                $shop_total_sold+= $item['quantity'];

            }
            shop_update_data(array('shop_id'=>$shop_id), "`total_sold`=`total_sold`+$shop_total_sold");

            //创建订单操作记录
            order_add_action(array(
                'uid'=>$this->uid,
                'username'=>$this->username,
                'order_id'=>$order_id,
                'action_name'=>$order['pay_type'] == 1 ? L('checkout_success') : L('order_commited'),
                'action_time'=>time()
            ));
            if ($pay_type == 1){
                //创建支付流水
                if ($shop_total_sold > 1){
                    $trade_name = sprintf(L('trade_name_formater'), $trade_name, $shop_total_sold);
                }
                trade_add_data(array(
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
                ));
            }
        }
        cart_delete_data(array('uid'=>$this->uid, 'itemid'=>array('IN', $itemids)));
        $this->showAjaxReturn();
    }
}