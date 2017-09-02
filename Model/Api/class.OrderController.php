<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/28
 * Time: 下午4:54
 */

namespace Model\Api;

class OrderController extends BaseController
{
    /**
     * 创建订单
     */
    public function create(){
        $itemid = intval($_GET['itemid']);
        $quantity = intval($_GET['quantity']);
        if (!$itemid) $itemid = intval($_GET['goods_id']);
        if (!$quantity) $quantity = intval($_GET['goods_number']);
        $shipping_type = intval($_GET['shipping_type']);
        $pay_type = intval($_GET['pay_type']);

        $item = $shop = array();
        if ($itemid && $quantity) {
            $item = item_get_data(array('id'=>$itemid));
            $shop = shop_get_data(array('shop_id'=>$item['shop_id']));
        } else{
            $this->showAjaxError(1,'can_not_buy');
        }

        $trade_no = trade_create_no();
        $order_no = order_create_no($this->uid);
        //卖家信息
        $seller   = member_get_data(array('uid'=>$item['uid']), 'uid,username');
        //收货地址
        $address  = address_get_data(array('id'=>intval($_GET['address_id'])));
        //订单金额
        $order_fee = floatval($item['price']) * $quantity;
        //运费
        $shipping_fee = 0;
        //总金额
        $total_fee = $order_fee + $shipping_fee;
        //创建订单
        $order_id = order_add_data(array(
            'uid'=>$this->uid,
            'seller_uid'=>$seller['uid'],
            'seller_username'=>$seller['username'],
            'shop_id'=>$shop['shop_id'],
            'shop_name'=>$shop['shop_name'],
            'order_no'=>$order_no,
            'order_fee'=>$order_fee,
            'shipping_fee'=>$shipping_fee,
            'total_fee'=>$total_fee,
            'create_time'=>time(),
            'pay_type'=>$pay_type,
            'shipping_type'=>$shipping_type,
            'order_status'=>0,
            'pay_status'=>0,
            'evaluate_status'=>0,
            'shipping_status'=>0,
            'consignee'=>$address['consignee'],
            'phone'=>$address['phone'],
            'address'=>$address['province'].$address['city'].$address['county'].$address['street'].' '.$address['postcode'],
            'trade_no'=>$trade_no,
            'remark'=>trim($_GET['remark'])
        ));
        //记录订单商品信息
        order_add_item(array(
            'uid'=>$this->uid,
            'order_id'=>$order_id,
            'itemid'=>$item['id'],
            'name'=>$item['name'],
            'market_price'=>$item['market_price'],
            'price'=>$item['price'],
            'quantity'=>$quantity,
            'thumb'=>$item['thumb'],
            'image'=>$item['image']
        ));
        //创建订单操作记录
        order_add_action(array(
            'uid'=>$this->uid,
            'username'=>$this->username,
            'order_id'=>$order_id,
            'action_name'=>L('checkout_success'),
            'action_time'=>time()
        ));
        //创建支付流水
        trade_add_data(array(
            'uid'=>$this->uid,
            'payee_uid'=>$seller['uid'],
            'payee_name'=>$seller['username'],
            'trade_no'=>$trade_no,
            'trade_name'=>$goods['goods_name'],
            'trade_desc'=>$goods['goods_name'],
            'trade_fee'=>$total_fee,
            'trade_type'=>'SHOPPING',
            'trade_status'=>'UNPAID',
            'trade_time'=>time(),
            'out_trade_no'=>$trade_no
        ));
        item_update_data(array('id'=>$itemid), "`sold`=`sold`+$quantity,`stock`=`stock`-$quantity");
        shop_update_data(array('shop_id'=>$shop['shop_id']), "`total_sold`=`total_sold`+$quantity");
        $this->showAjaxReturn(array('order_id'=>$order_id));
    }

    /**
     * 获取订单详情
     */
    public function get(){

        $order_id = intval($_GET['order_id']);
        $order = order_get_data(array('uid'=>$this->uid, 'order_id'=>$order_id));
        if ($order) {
            $order['create_time'] = date('Y-m-d H:i:s', $order['create_time']);
            $item = order_get_item(array('order_id'=>$order_id));
            $this->showAjaxReturn(array(
                'item'=>$item,
                'order'=>$order
            ));
        }else {
            $this->showAjaxError(1, 'order_not_exists');
        }
    }

    public function update(){

    }

    public function delete(){

    }

    /**
     * 支付订单
     */
    public function pay(){

        $order_id = intval($_GET['order_id']);
        $pay_type = intval($_GET['pay_type']);
        $order = order_get_data(array('order_id'=>$order_id, 'uid'=>$this->uid));
        if (!$order) {
            $this->showAjaxError(1, 'order_not_exists');
        }
        if ($order['pay_status'] != 0){
            $this->showAjaxError(2, 'order_have_been_paid');
        }

        if ($pay_type == 1){
            //余额支付
            $wallet = wallet_get_data($this->uid);
            /*$member = member_get_data(array('uid'=>$this->uid), 'password');
            if ($member['password'] !== getPassword($password)){
                $this->showAjaxError('FAIL','password_incorrect');
            }*/

            $wallet = wallet_get_data($this->uid);
            if ($wallet['balance'] < $order['total_fee']){
                $this->showAjaxError(3, 'balance_not_enough');
            }

            if (wallet_cost($this->uid, $order['total_fee'])){
                order_update_data(array('order_id'=>$order_id), array('pay_status'=>1, 'pay_type'=>1, 'pay_time'=>time()));
                trade_update_data(array('trade_no'=>$order['trade_no']), array('trade_status'=>'PAID', 'trade_type'=>'balance'));
                $this->showAjaxReturn(array('order_id'=>$order_id));
            }else {
                $this->showAjaxError(4, 'balance_not_enough');
            }
        }

        //货到付款
        if ($pay_type == 3) {
            order_update_data(array('order_id'=>$order_id), array('pay_status'=>1, 'pay_type'=>2, 'pay_time'=>time()));
            trade_update_data(array('trade_no'=>$order['trade_no']), array('trade_type'=>'COD'));
            $this->showAjaxReturn(array('order_id'=>$order_id));
        }

        $this->showAjaxError(-1, 'pay_failed');
    }

    /**
     * 提醒卖家发货
     */
    public function notice(){
        $this->showAjaxReturn();
    }

    public function confirm(){
        $order_id = intval($_GET['order_id']);
        $password = trim($_GET['password']);
        $order = order_get_data(array('order_id'=>$order_id, 'uid'=>$this->uid));
        if ($order) {
            //验证密码
            $member = member_get_data(array('uid'=>$this->uid), 'password');
            if ($member['password'] !== getPassword($password)){
                $this->showAjaxError(1, 'password_incorrect');
            }
            //验证订单状态
            if (order_get_trade_status($order) == 3){
                //更新订单状态
                order_update_data(array('order_id'=>$order_id),
                    array(
                        'order_status'=>1,
                        'deal_time'=>time()
                    ));
                //打款给卖家
                if ($order['pay_type'] == 1 || $order['pay_type'] == 2){
                    wallet_income($order['seller_uid'], $order['total_fee']);
                }
            }
            $this->showAjaxReturn();
        }else {
            $this->showAjaxError(2, 'order_not_exists');
        }
    }
}