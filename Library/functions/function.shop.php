<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/1
 * Time: 上午10:22
 */

/**
 * 添加店铺
 * @param $data
 * @param int $return
 * @return bool|int|mysqli_result|string|void
 */
function shop_add_data($data, $return=0){
    $shop_id = M('shop')->insert($data, true);
    return $return ? shop_get_data(array('shop_id'=>$shop_id)): $shop_id;
}

/**
 * 删除店铺信息
 * @param $condition
 * @return bool|int
 */
function shop_delete_data($condition){
    return $condition ? M('shop')->where($condition)->delete() : false;
}

/**
 * 更新店铺信息
 * @param $condition
 * @param $data
 * @return bool|int
 */
function shop_update_data($condition, $data){
    return M('shop')->where($condition)->update($data);
}

/**
 * 获取店铺信息
 * @param $condition
 * @param string $field
 * @return array|null
 */
function shop_get_data($condition, $field='*'){
    $data = M('shop')->where($condition)->field($field)->getOne();
    return $data ? $data : array();
}

/**
 * 获取店铺数量
 * @param $condition
 * @param string $field
 * @return mixed
 */
function shop_get_count($condition, $field='*'){
    return M('shop')->where($condition)->count($field);
}

/**
 * 获取店铺列表
 * @param $condition
 * @param int $count
 * @param int $offset
 * @param null $order
 * @param string $field
 * @return array
 */
function shop_get_list($condition, $count=20, $offset=0, $order=null, $field='*'){
    $limit = $count ? "$offset,$count" : ($offset ? $offset : '');
    !$order && $order = 'shop_id ASC';
    $itemlist = M('shop')->field($field)->where($condition)->order($order)->limit($limit)->select();
    return $itemlist ? $itemlist : array();
}

/**
 * 添加店铺记录
 * @param $data
 * @return bool|int|mysqli_result|string
 */
function shop_add_record($data){
    return M('shop_record')->insert($data, true);
}

/**
 * 删除店铺记录
 * @param $condition
 * @return bool|int
 */
function shop_delete_record($condition){
    return $condition ? M('shop_record')->where($condition)->delete() : false;
}

/**
 * 更新店铺记录
 * @param $condition
 * @param $data
 * @return bool|int
 */
function shop_update_record($condition, $data){
    return M('shop_record')->where($condition)->update($data);
}

/**
 * @param $condition
 * @return array|null
 */
function shop_get_record($condition){
    $data = M('shop_record')->where($condition)->getOne();
    return $data ? $data : array();
}

/**
 * 获取店铺记录列表
 * @param $condition
 * @param int $count
 * @param int $offset
 * @param null $order
 * @return array
 */
function shop_get_record_list($condition, $count=20, $offset=0, $order=null){
    $limit = $count ? "$offset, $count" : ($offset ? $offset : '');
    !$order && $order = 'id DESC';
    $itemlist = M('shop_record')->where($condition)->order($order)->limit($limit)->select();
    return $itemlist ? $itemlist : array();
}

/**
 * @param $data
 * @return bool|int|mysqli_result|string
 */
function shop_add_desc($data){
    return M('shop_desc')->insert($data, false, true);
}

/**
 * @param $condition
 * @param $data
 * @return bool|int
 */
function shop_update_desc($condition, $data){
    return M('shop_desc')->where($condition)->update($data);
}

/**
 * @param $condition
 * @return bool|int
 */
function shop_delete_desc($condition){
    return $condition ? M('shop_desc')->where($condition)->delete() : false;
}

/**
 * @param $condition
 * @return array|null
 */
function shop_get_desc($condition){
    return M('shop_desc')->where($condition)->getOne();
}

/**
 * @param $data
 * @param bool $return
 * @return bool|int|mysqli_result|string|void
 */
function shop_add_auth($data, $return=false){
    $id = M('shop_auth')->insert($data, true);
    return $return ? shop_get_auth(array('id'=>$id)) : $id;
}

/**
 * @param $condition
 * @return bool|int
 */
function shop_delete_auth($condition){
    return $condition ? M('shop_auth')->where($condition)->delete() : false;
}

/**
 * @param $condition
 * @param $data
 * @return bool|int
 */
function shop_update_auth($condition, $data){
    return M('shop_auth')->where($condition)->update($data);
}

/**
 * @param $condition
 * @return array|null
 */
function shop_get_auth($condition){
    $data = M('shop_auth')->where($condition)->getOne();
    return $data ? $data : array();
}

/**
 * @param $condition
 * @return mixed
 */
function shop_get_auth_count($condition){
    return M('shop_auth')->where($condition)->count();
}

/**
 * @param $condition
 * @param int $count
 * @param int $offset
 * @param null $order
 * @return array
 */
function shop_get_auth_list($condition, $count=20, $offset=0, $order=null){
    $limit = $count ? "$offset, $count" : ($offset ? $offset : '');
    !$order && $order = 'id DESC';
    $itemlist = M('shop_auth')->where($condition)->order($order)->limit($limit)->select();
    return $itemlist ? $itemlist : array();
}