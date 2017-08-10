<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/4
 * Time: 上午11:19
 */

/**
 * 获取钱包数据
 * @param $uid
 * @return array|null
 */
function wallet_get_data($uid){
    $data = M('wallet')->where(array('uid'=>$uid))->getOne();
    if ($data) {
        return $data;
    }else {
        M('wallet')->insert(array('uid'=>$uid));
        return wallet_get_data($uid);
    }
}

/**
 * 更新钱包数据
 * @param $condition
 * @param $data
 * @return bool|int
 */
function wallet_update_data($condition, $data){
    return M('wallet')->where($condition)->update($data);
}

/**
 * 删除钱包数据
 * @param $condition
 * @return bool|int
 */
function wallet_delete_data($condition){
    return $condition ? M('wallet')->where($condition)->delete() : false;
}

/**
 * 获取钱包数目
 * @param $condition
 * @return mixed
 */
function wallet_get_count($condition){
    return M('wallet')->where($condition)->count();
}

/**
 * 获取钱包数据列表
 * @param $condition
 * @param int $count
 * @param int $offset
 * @param null $order
 * @return array
 */
function wallet_get_list($condition, $count=20, $offset=0, $order=null){
    $limit = $count ? "$offset,$count" : ($offset ? $offset : '');
    !$order && $order = 'balance DESC,id ASC';
    $itemlist = M('wallet')->where($condition)->order($order)->limit($limit)->select();
    return $itemlist ? $itemlist : array();
}

/**
 * 生成交易流水号
 * @return string
 */
function trade_create_no(){
    return date('YmdHis').rand(100,999).rand(100,999);
}

/**
 * 新增交易记录
 * @param $data
 * @param int $return
 * @return array|bool|int|mysqli_result|null|string
 */
function trade_add_data($data, $return=0){
    $trade_id = M('trade')->insert($data, true);
    return $return ? trade_get_data(array('trade_id'=>$trade_id)) : $trade_id;
}

/**
 * 删除交易记录
 * @param $condition
 * @return bool|int
 */
function trade_delete_data($condition){
    return $condition ? M('trade')->where($condition)->delete() : false;
}

/**
 * 更新交易记录
 * @param $condition
 * @param $data
 * @return bool|int
 */
function trade_update_data($condition, $data){
    return M('trade')->where($condition)->update($data);
}

/**
 * 获取交易数据
 * @param $condition
 * @param string $field
 * @return array|null
 */
function trade_get_data($condition, $field='*'){
    $data = M('trade')->where($condition)->field($field)->getOne();
    return $data ? $data : array();
}

/**
 * 获取交易数目
 * @param $condition
 * @param string $field
 * @return mixed
 */
function trade_get_count($condition, $field='*'){
    return M('trade')->where($condition)->count($field);
}

/**
 * 获取交易列表
 * @param $condition
 * @param int $count
 * @param int $offset
 * @param null $order
 * @param string $field
 * @return array
 */
function trade_get_list($condition, $count=20, $offset=0, $order=null, $field='*'){
    $limit = $count ? "$offset, $count" : ($offset ? $offset : '');
    !$order && $order = 'trade_id DESC';
    $itemlist = M('trade')->field($field)->where($condition)->order($order)->limit($limit)->select();
    return $itemlist ? $itemlist : array();
}


/**
 * 生成订单号
 * @param $uid
 * @param string $type 订单类型
 * @return string
 */
function order_create_no($uid, $type='6'){
    return $type.time().substr($uid, -5);
}

/**
 * 添加订单
 * @param $data
 * @param int $return
 * @return array|bool|null
 */
function order_add_item($data, $return=0){
    $order_id = M('order_item')->insert($data, true);
    return $return ? order_get_item(array('order_id'=>$order_id)) : $order_id;
}

/**
 * 删除订单
 * @param $condition
 * @return bool|int
 */
function order_delete_item($condition){
    return $condition ? M('order_item')->where($condition)->delete() : false;
}

/**
 * 更新订单
 * @param $condition
 * @param $data
 * @return bool|int
 */
function order_update_item($condition, $data){
    return M('order_item')->where($condition)->update($data);
}

/**
 * 获取订单数据
 * @param $condition
 * @param string $field
 * @return array|null
 */
function order_get_item($condition, $field='*'){
    $data = M('order_item')->where($condition)->field($field)->getOne();
    return $data ? $data : array();
}

/**
 * 获取订单数目
 * @param $condition
 * @param string $field
 * @return mixed
 */
function order_get_item_count($condition, $field='*'){
    return M('order_item')->where($condition)->count($field);
}

/**
 * 获取订单列表
 * @param $condition
 * @param int $count
 * @param int $offset
 * @param null $order
 * @param string $field
 * @return array
 */
function order_get_item_list($condition, $count=20, $offset=0, $order=null, $field='*'){
    $limit = $count ? "$offset,$count" : ($offset ? $offset : '');
    !$order && $order = 'order_id DESC';
    $itemlist = M('order_item')->where($condition)->field($field)->order($order)->limit($limit)->select();
    return $itemlist ? $itemlist : array();
}

/**
 * 获取订单交易状态
 * @param $order
 * @return int
 */
function order_get_trade_status($order){
    $trade_status = 0;
    if ($order['order_status'] == 0 && $order['pay_status'] == 0){
        //未支付
        $trade_status = 1;
    }elseif ($order['order_status'] == 0 && $order['pay_status'] == 1 && $order['shipping_status'] == 0){
        //已付款,未发货
        $trade_status = 2;
    }elseif ($order['order_status'] == 0 && $order['pay_status'] == 1 && $order['shipping_status'] == 1){
        //已发货,待收货
        $trade_status = 3;
    }elseif ($order['order_status'] == 1 && $order['pay_status'] == 1 &&
        $order['shipping_status'] == 1 && $order['evaluate_status'] == 0){
        //已收货,未评价
        $trade_status = 4;
    }elseif ($order['order_status'] == 1 && $order['pay_status'] == 1 &&
        $order['shipping_status'] == 1 && $order['evaluate_status'] == 1){
        //已收货,已评价
        $trade_status = 5;
    }elseif ($order['order_status'] == 2 && $order['pay_status'] == 1 && $order['shipping_status'] == 1){
        //退款中
        $trade_status = 6;
    }elseif ($order['order_status'] == 3 && $order['pay_status'] == 1 && $order['shipping_status'] == 1){
        //退款完成
        $trade_status = 7;
    }
    return $trade_status;
}

/**
 * 添加订单商品
 * @param $data
 * @return bool|int|mysqli_result|string
 */
function order_add_goods($data){
    return M('order_goods')->insert($data, true);
}

/**
 * 删除订单商品
 * @param $condition
 * @return bool|int
 */
function order_delete_goods($condition){
    return $condition ? M('order_goods')->where($condition)->delete() : false;
}

/**
 * 更新订单商品
 * @param $condition
 * @param $data
 * @return bool|int
 */
function order_update_goods($condition, $data){
    return M('order_goods')->where($condition)->update($data);
}

/**
 * 获取订单商品
 * @param $condition
 * @return array|null
 */
function order_get_goods($condition){
    $data = M('order_goods')->where($condition)->getOne();
    return $data ? $data : array();
}

/**
 * 获取订单商品列表
 * @param $condition
 * @return array
 */
function order_get_goods_list($condition){
    $itemlist = M('order_goods')->where($condition)->order('id ASC')->select();
    return $itemlist ? $itemlist : array();
}

/**
 * 添加订单动态
 * @param $data
 * @return bool|int|mysqli_result|string
 */
function order_add_action($data){
    return M('order_action')->insert($data, true);
}

/**
 * 删除订单动态
 * @param $condition
 * @return bool|int
 */
function order_delete_action($condition){
    return $condition ? M('order_action')->where($condition)->delete() : false;
}

/**
 * 更新订单动态
 * @param $condition
 * @param $data
 * @return bool|int
 */
function order_update_action($condition, $data){
    return M('order_action')->where($condition)->update($data);
}

/**
 * 获取订单动态
 * @param $condition
 * @return array|null
 */
function order_get_action($condition){
    $data = M('order_action')->where($condition)->getOne();
    return $data ? $data : array();
}

/**
 * 获取订单动态列表
 * @param $condition
 * @return array
 */
function order_get_action_list($condition){
    return M('order_action')->where($condition)->select();
}

/**
 * 添加物流信息
 * @param $data
 * @param int $return
 * @return bool|int|mysqli_result|string|void
 */
function order_add_shipping($data, $return=0){
    $id = M('order_shipping')->insert($data, true);
    return $return ? order_get_shipping(array('id'=>$id)) : $id;
}

/**
 * 删除物流信息
 * @param $condition
 * @return bool|int
 */
function order_delete_shipping($condition){
    return $condition ? M('order_shipping')->where($condition)->delete() : false;
}

/**
 * 更新物流信息
 * @param $condition
 * @param $data
 * @return bool|int
 */
function order_update_shipping($condition, $data){
    return M('order_shipping')->where($condition)->update($data);
}

/**
 * 获取物流信息
 * @param $condition
 * @return array|null
 */
function order_get_shipping($condition){
    $data = M('order_shipping')->where($condition)->getOne();
    return $data ? $data : array();
}