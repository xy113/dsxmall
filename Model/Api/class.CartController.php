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
        $goods_id = intval($_GET['goods_id']);
        $goods_number = intval($_GET['goods_number']);
        $item = goods_get_item(array('id'=>$goods_id));
        if ($item) {
            if (cart_get_count(array('uid'=>$this->uid, 'goods_id'=>$goods_id))){
                cart_update_data(array('uid'=>$this->uid, 'goods_id'=>$goods_id), "`goods_number`=`goods_number`+".$goods_number);
            }else {
                $shop = shop_get_data(array('shop_id'=>$item['shop_id']));
                cart_add_data(array(
                    'uid'=>$this->uid,
                    'shop_id'=>$shop['shop_id'],
                    'shop_name'=>$shop['shop_name'],
                    'goods_id'=>$goods_id,
                    'goods_name'=>$item['goods_name'],
                    'goods_number'=>$goods_number,
                    'goods_price'=>$item['goods_price'],
                    'goods_thumb'=>$item['goods_thumb'],
                    'goods_image'=>$item['goods_image'],
                    'create_time'=>time()
                ));
            }

            $this->showAjaxReturn();
        }else {
            $this->showAjaxError(1, 'goods_not_exists');
        }
    }

    /**
     *
     */
    public function get_settle_items(){
        $itemids = $_GET['itemids'];
        $itemlist = array();
        if (is_array($itemids)) $itemids = implode(',', $itemids);
        if (!$itemids || empty($itemids)){
            $this->showAjaxError(1, 'can_not_buy');
        }else {
            $itemlist = cart_get_list(array('uid'=>$this->uid, 'goods_id'=>array('IN', $itemids)), 0);
        }

        $total_num = $total_fee = 0;
        if ($itemlist) {
            $price_list = array();
            $goods_list = goods_get_item_list(array('id'=>array('IN', $itemids)), 0, 0, null, 'id, goods_price');
            foreach ($goods_list as $goods){
                $price_list[$goods['id']] = $goods['goods_price'];
            }
            $datalist = array();
            foreach ($itemlist as $item){
                $item['goods_price'] = $price_list[$item['goods_id']];
                $item['formated_price'] = formatAmount($item['goods_price']);
                $item['goods_thumb'] = image($item['goods_thumb']);
                $item['total_fee'] = floatval($item['goods_price']) * intval($item['goods_number']);
                $datalist[$item['shop_id']]['shop_id'] = $item['shop_id'];
                $datalist[$item['shop_id']]['shop_name'] = $item['shop_name'];
                $datalist[$item['shop_id']]['simple_fee']+= $item['total_fee'];
                $datalist[$item['shop_id']]['simple_num']+= intval($item['goods_number']);
                $datalist[$item['shop_id']]['items'][] = $item;
                $total_num+= $item['goods_number'];
                $total_fee+= floatval($item['goods_price']) * intval($item['goods_number']);
            }
            $itemlist = $datalist;
            unset($datalist, $item);
            $this->showAjaxReturn(array(
                'total_num'=>$total_num,
                'total_fee'=>$total_fee,
                'items'=>array_values($itemlist)
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

        $itemlist = array();
        $itemids = $itemids ? implodeids($itemids) : 0;
        $price_list = array();
        $goods_list = goods_get_item_list(array('id'=>array('IN', $itemids)), 0, 0, null, 'id AS goods_id, goods_price');
        foreach ($goods_list as $goods){
            $price_list[$goods['goods_id']] = $goods['goods_price'];
        }

        $total_num = $total_fee = 0;
        $cart_list = cart_get_list(array('uid'=>$this->uid, 'goods_id'=>array('IN', $itemids)), 0, 0, null);
        foreach ($cart_list as $cartitem){
            if (isset($price_list[$cartitem['goods_id']])){
                $cartitem['goods_price'] = $price_list[$cartitem['goods_id']];
                $cartitem['total_fee'] = floatval($cartitem['goods_price']) * intval($cartitem['goods_number']);
                $itemlist[$cartitem['shop_id']]['shop_id'] = $cartitem['shop_id'];
                $itemlist[$cartitem['shop_id']]['shop_name'] = $cartitem['shop_name'];
                $itemlist[$cartitem['shop_id']]['simple_fee']+= $cartitem['total_fee'];
                $itemlist[$cartitem['shop_id']]['goods'][$cartitem['goods_id']] = $cartitem;
                $total_num+= $cartitem['goods_number'];
                $total_fee+= floatval($cartitem['goods_price']) * intval($cartitem['goods_number']);
            }
        }
        unset($goods_list, $goods, $cart_list, $cartitem, $price_list);

        if ($order_list) {
            foreach ($order_list as $order){
                if (isset($itemlist[$order['shop_id']])){
                    $itemlist[$order['shop_id']]['pay_type'] = $order['pay_type'];
                    $itemlist[$order['shop_id']]['shipping_type'] = $order['shipping_type'];
                    $itemlist[$order['shop_id']]['remark'] = $order['remark'];
                }
            }
            unset($order_list, $order);
        }

        //$this->showAjaxReturn($itemlist);
        foreach ($itemlist as $shop) {
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
            $order_id = order_add_item(array(
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
            if ($shop['goods']){
                foreach ($shop['goods'] as $goods_id=>$goods){
                    //记录订单商品信息
                    if (!$trade_name) $trade_name = $goods['goods_name'];
                    order_add_goods(array(
                        'uid'=>$this->uid,
                        'order_id'=>$order_id,
                        'goods_id'=>$goods['id'],
                        'goods_name'=>$goods['goods_name'],
                        'market_price'=>$goods['market_price'],
                        'goods_price'=>$goods['goods_price'],
                        'goods_number'=>$goods['goods_number'],
                        'goods_thumb'=>$goods['goods_thumb'],
                        'goods_image'=>$goods['goods_image']
                    ));
                    goods_update_item(array('id'=>$goods_id), "`sold`=`sold`+".$goods['goods_number']);
                    $shop_total_num+= $goods['goods_number'];

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
        cart_delete_data(array('uid'=>$this->uid, 'goods_id'=>array('IN', $itemids)));
        $this->showAjaxReturn();
    }
}