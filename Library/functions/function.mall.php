<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/12
 * Time: 上午11:54
 */

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