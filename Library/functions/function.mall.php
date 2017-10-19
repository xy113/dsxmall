<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/12
 * Time: 上午11:54
 */

/**
 * @return string
 */
function createItemSn(){
    return time().rand(100,999).rand(100,999);
}

/**
 * 生成交易流水号
 * @return string
 */
function createTradeNo(){
    return date('YmdHis').rand(100,999).rand(100,999);
}

/**
 * 生成订单号
 * @param $uid
 * @param string $type
 * @return string
 */
function createOrderNo($uid, $type='6'){
    return $type.time().substr($uid, -5);
}

/**
 * @return string
 */
function createReundNo(){
    return '4'.time().rand(100,999);
}

/**
 * 获取订单交易状态
 * @param $order
 * @return int
 */
function order_get_trade_status($order){
    $trade_status = 0;
    if ($order['pay_type'] == 2){
        if ($order['is_commited']==1 && $order['is_accepted']==0){
            return 8;
        }else {
            return 9;
        }
    }
    if ($order['is_closed']==1 && $order['refund_status'] == 0) {
        //交易关闭
        return 0;
    }elseif ($order['refund_status'] == 1) {
        //退款中
        return 6;
    }elseif ($order['refund_status'] == 2) {
        //退款完成
        return 7;
    }else {
        if ($order['pay_status'] == 0 && $order['shipping_status'] == 0){
            //已下单未支付
            $trade_status = 1;
        }elseif ($order['pay_status'] == 1 && $order['shipping_status'] == 0){
            //已付款,未发货
            $trade_status = 2;
        }elseif ($order['pay_status'] == 1 && $order['shipping_status'] == 1){
            //已发货,待收货
            $trade_status = 3;
        }elseif ($order['pay_status'] == 1 && $order['shipping_status'] == 1
            && $order['receive_status'] == 1 && $order['review_status'] == 0){
            //已收货,未评价
            $trade_status = 4;
        }elseif ($order['pay_status'] == 1 && $order['shipping_status'] == 1
            && $order['receive_status'] == 1 && $order['review_status'] == 1){
            //已收货,已评价
            $trade_status = 5;
        }
    }
    return $trade_status;
}