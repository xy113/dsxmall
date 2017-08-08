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
 * 添加店主信息
 * @param $data
 * @param int $return
 * @return bool|int|mysqli_result|string|void
 */
function shop_add_owner($data, $return=0){
    $id = M('shop_owner')->insert($data, true);
    return $return ? shop_get_owner(array('id'=>$id)) : $id;
}

/**
 * 删除店主信息
 * @param $condition
 * @return bool|int
 */
function shop_delete_owner($condition){
    return $condition ? M('shop_owner')->where($condition)->delete() : false;
}

/**
 * 更新店主信息
 * @param $condition
 * @param $data
 * @return bool|int
 */
function shop_update_owner($condition, $data){
    return M('shop_owner')->where($condition)->update($data);
}

/**
 * 获取店主信息
 * @param $condition
 * @param string $field
 * @return array|null
 */
function shop_get_owner($condition, $field='*'){
    $data = M('shop_owner')->where($condition)->field($field)->getOne();
    return $data ? $data : array();
}

/**
 * 获取店主数量
 * @param $condition
 * @param string $field
 * @return mixed
 */
function shop_get_owner_count($condition, $field='*'){
    return M('shop_owner')->where($condition)->count($field);
}

/**
 * 获取店主列表
 * @param $condition
 * @param int $count
 * @param int $offset
 * @param null $order
 * @param string $field
 * @return array
 */
function shop_get_owner_list($condition, $count=20, $offset=0, $order=null, $field='*'){
    $limit = $count ? "$offset, $count" : ($offset ? $offset : '');
    !$order && $order = 'id DESC';
    $itemlist = M('shop_owner')->field($field)->where($condition)->order($order)->limit($limit)->select();
    return $itemlist ? $itemlist : array();
}

/**
 * 添加店铺资料
 * @param $data
 * @param int $return
 * @return bool|int|mysqli_result|string|void
 */
function shop_add_info($data, $return=0){
    $id = M('shop_info')->insert($data, true);
    return $return ? shop_get_info(array('id'=>$id)) : $id;
}

/**
 * 删除店铺资料
 * @param $condition
 * @return bool|int
 */
function shop_delete_info($condition){
    return $condition ? M('shop_info')->where($condition)->delete() : false;
}

/**
 * 更新店铺资料
 * @param $condition
 * @param $data
 * @return bool|int
 */
function shop_update_info($condition, $data){
    return M('shop_info')->where($condition)->update($data);
}

/**
 * @param $condition
 * @param string $field
 * @return array|null
 */
function shop_get_info($condition, $field='*'){
    $data = M('shop_info')->where($condition)->field($field)->getOne();
    return $data ? $data : array();
}

/**
 * 获取店铺资料数量
 * @param $condition
 * @param string $field
 * @return mixed
 */
function shop_get_info_count($condition, $field='*'){
    return M('shop_info')->where($condition)->count($field);
}

/**
 * 获取店铺资料列表
 * @param $condition
 * @param int $count
 * @param int $offset
 * @param null $order
 * @param string $field
 * @return array
 */
function shop_get_info_list($condition, $count=20, $offset=0, $order=null, $field='*'){
    $limit = $count ? "$offset, $count" : ($offset ? $offset : '');
    !$order && $order = 'id DESC';
    $itemlist = M('shop_info')->field($field)->where($condition)->order($order)->limit($limit)->select();
    return $itemlist ? $itemlist : array();
}