<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/29
 * Time: 下午1:41
 */

namespace Model\Api;


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
        $item = item_get_data(array('id'=>$itemid));
        if ($item) {
            if (cart_get_count(array('uid'=>$this->uid, 'itemid'=>$itemid))){
                cart_update_data(array('uid'=>$this->uid, 'itemid'=>$itemid), "`quantity`=`quantity`+".$quantity);
            }else {
                $shop = shop_get_data(array('shop_id'=>$item['shop_id']));
                cart_add_data(array(
                    'uid'=>$this->uid,
                    'shop_id'=>$shop['shop_id'],
                    'shop_name'=>$shop['shop_name'],
                    'itemid'=>$itemid,
                    'name'=>$item['name'],
                    'quantity'=>$quantity,
                    'price'=>$item['price'],
                    'thumb'=>$item['thumb'],
                    'image'=>$item['image'],
                    'create_time'=>time()
                ));
            }

            $this->showAjaxReturn();
        }else {
            $this->showAjaxError(1, 'item_not_exists');
        }
    }

    /**
     *
     */
    public function get_settle_items(){
        $itemids = $_GET['itemids'];
        $cart_item_list = array();
        if (is_array($itemids)) $itemids = implode(',', $itemids);
        if (!$itemids || empty($itemids)){
            $this->showAjaxError(1, 'can_not_buy');
        }else {
            $cart_item_list = cart_get_list(array('uid'=>$this->uid, 'itemid'=>array('IN', $itemids)), 0);
        }

        $total_num = $total_fee = 0;
        if ($cart_item_list) {
            $price_list = array();
            $itemlist = item_get_list(array('id'=>array('IN', $itemids)), 0, 0, null, 'id, price');
            foreach ($itemlist as $item){
                $price_list[$item['id']] = $item['price'];
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

        $shop_list = array();
        $itemids = $itemids ? implodeids($itemids) : 0;
        $price_list = array();
        $itemlist = item_get_list(array('id'=>array('IN', $itemids)), 0, 0, null, 'id AS itemid, price');
        foreach ($itemlist as $item){
            $price_list[$item['itemid']] = $item['price'];
        }
        unset($itemlist, $item);

        $total_num = $total_fee = 0;
        $cart_list = cart_get_list(array('uid'=>$this->uid, 'itemid'=>array('IN', $itemids)), 0, 0, null);
        foreach ($cart_list as $cartitem){
            if (isset($price_list[$cartitem['itemid']])){
                $cartitem['goods_price'] = $price_list[$cartitem['itemid']];
                $cartitem['total_fee'] = floatval($cartitem['price']) * intval($cartitem['quantity']);
                $shop_list[$cartitem['shop_id']]['shop_id'] = $cartitem['shop_id'];
                $shop_list[$cartitem['shop_id']]['shop_name'] = $cartitem['shop_name'];
                $shop_list[$cartitem['shop_id']]['simple_fee']+= $cartitem['total_fee'];
                $shop_list[$cartitem['shop_id']]['items'][$cartitem['itemid']] = $cartitem;
                $total_num+= $cartitem['quantity'];
                $total_fee+= floatval($cartitem['price']) * intval($cartitem['quantity']);
            }
        }
        unset($cart_list, $cartitem, $price_list);

        if ($order_list) {
            foreach ($order_list as $order){
                if (isset($shop_list[$order['shop_id']])){
                    $shop_list[$order['shop_id']]['pay_type'] = $order['pay_type'];
                    $shop_list[$order['shop_id']]['shipping_type'] = $order['shipping_type'];
                    $shop_list[$order['shop_id']]['remark'] = $order['remark'];
                }
            }
            unset($order_list, $order);
        }

        //创建订单
        foreach ($shop_list as $shop_id=>$shop) {
            $trade_no = trade_create_no();
            $order_no = order_create_no($this->uid);
            //卖家信息
            $seller = shop_get_data(array('shop_id'=>$shop['shop_id']), 'owner_uid,owner_username');
            //收货地址
            if ($_GET['address_id']) {
                $address = address_get_data(array('id'=>intval($_GET['address_id'])));
            }else {
                $address = address_get_data(array('uid'=>$this->uid, 'isdefault'=>1));
            }

            //订单金额
            $order_fee = floatval($shop['simple_fee']);
            //运费
            $shipping_fee = 0;
            //总金额
            $total_fee = $order_fee + $shipping_fee;
            //创建订单
            $order_id = order_add_data(array(
                'uid'=>$this->uid,
                'seller_uid'=>$seller['owner_uid'],
                'seller_username'=>$seller['owner_username'],
                'shop_id'=>$shop['shop_id'],
                'shop_name'=>$shop['shop_name'],
                'order_no'=>$order_no,
                'order_fee'=>$order_fee,
                'shipping_fee'=>$shipping_fee,
                'total_fee'=>$total_fee,
                'create_time'=>time(),
                'pay_type'=>$shop['pay_type'],
                'shipping_type'=>$shop['shipping_type'],
                'order_status'=>0,
                'pay_status'=>0,
                'evaluate_status'=>0,
                'shipping_status'=>0,
                'consignee'=>$address['consignee'],
                'phone'=>$address['phone'],
                'address'=>$address['province'].$address['city'].$address['county'].$address['street'].' '.$address['postcode'],
                'trade_no'=>$trade_no,
                'order_remark'=>$shop['remark']
            ));

            $shop_total_num = 0;
            $trade_name = '';
            if ($shop['items']){
                foreach ($shop['items'] as $itemid=>$item){
                    //记录订单商品信息
                    if (!$trade_name) $trade_name = $item['name'];
                    order_add_item(array(
                        'uid'=>$this->uid,
                        'order_id'=>$order_id,
                        'itemid'=>$itemid,
                        'name'=>$item['name'],
                        'market_price'=>$item['market_price'],
                        'price'=>$item['price'],
                        'quantity'=>$item['quantity'],
                        'thumb'=>$item['thumb'],
                        'image'=>$item['image']
                    ));
                    item_update_data(array('id'=>$itemid), "`sold`=`sold`+".$item['quantity'].",`stock`=`stock`-".$item['quantity']);
                    $shop_total_num+= $item['quantity'];

                }
            }

            shop_update_data(array('shop_id'=>$shop['shop_id']), "`total_sold`=`total_sold`+$shop_total_num");

            //创建订单操作记录
            order_add_action(array(
                'uid'=>$this->uid,
                'username'=>$this->username,
                'order_id'=>$order_id,
                'action_name'=>L('checkout_success'),
                'action_time'=>time()
            ));
            //创建支付流水
            if ($shop_total_num > 1){
                $trade_name = sprintf(L('trade_name_formater'), $trade_name, $shop_total_num);
            }
            trade_add_data(array(
                'uid'=>$this->uid,
                'payee_uid'=>$seller['owner_uid'],
                'payee_name'=>$seller['owner_username'],
                'trade_no'=>$trade_no,
                'trade_name'=>$trade_name,
                'trade_desc'=>$trade_name,
                'trade_fee'=>$total_fee,
                'trade_type'=>'SHOPPING',
                'trade_status'=>'UNPAID',
                'trade_time'=>time(),
                'out_trade_no'=>$trade_no
            ));
        }
        cart_delete_data(array('uid'=>$this->uid, 'itemid'=>array('IN', $itemids)));
        $this->showAjaxReturn();
    }
}