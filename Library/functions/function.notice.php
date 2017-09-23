<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/16
 * Time: 上午11:19
 */

/**
 * 添加通知
 * @param $data
 * @param bool $return
 * @return array|bool|int|mysqli_result|null|string
 */
function notice_add_message($data, $return=false){
    $msg_id = M('notice_message')->insert($data, true);
    return $return ? notice_get_message(array('msg_id'=>$msg_id)) : $msg_id;
}

/**
 * 删除通知
 * @param $condition
 * @return bool|int
 */
function notice_delete_message($condition){
    return $condition ? M('notice_message')->where($condition)->delete() : false;
}

/**
 * 更新通知
 * @param $condition
 * @param $data
 * @return bool|int
 */
function notice_update_message($condition, $data){
    return M('notice_message')->where($condition)->update($data);
}

/**
 * 获取通知内容
 * @param $condition
 * @param string $field
 * @return array|null
 */
function notice_get_message($condition, $field='*'){
    $data = M('notice_message')->where($condition)->field($field)->getOne();
    return $data ? $data : array();
}

/**
 * 获取通知数量
 * @param $condition
 * @return mixed
 */
function notice_get_message_count($condition){
    return M('notice_message')->where($condition)->count();
}

/**
 * 获取通知列表
 * @param $condition
 * @param int $count
 * @param int $offset
 * @param null $order
 * @param string $field
 * @return array
 */
function notice_get_message_list($condition, $count=20, $offset=0, $order=null, $field='*'){
    $limit = $count ? "$offset, $count" : ($offset ? $offset : '');
    !$order && $order = 'msg_id DESC';
    $itemlist = M('notice_message')->where($condition)->field($field)->order($order)->limit($limit)->select();
    return $itemlist ? $itemlist : array();
}

/**
 * 添加消息接收者
 * @param $data
 * @param bool $return
 * @return array|bool|int|mysqli_result|null|string
 */
function notice_add_receiver($data, $return=false){
    $id = M('notice_receiver')->insert($data, true);
    return $return ? notice_get_receiver(array('id'=>$id)) : $id;
}

/**
 * 删除消息接收者
 * @param $condition
 * @return bool|int
 */
function notice_delete_receiver($condition){
    return $condition ? M("notice_receiver")->where($condition)->delete() : false;
}

/**
 * 更新消息接收者信息
 * @param $condition
 * @param $data
 * @return bool|int
 */
function notice_update_receiver($condition, $data){
    return M('notice_receiver')->where($condition)->update($data);
}

/**
 * 获取消息接收者
 * @param $condition
 * @return array|null
 */
function notice_get_receiver($condition){
    $data = M('notice_receiver')->where($condition)->getOne();
    return $data ? $data : array();
}

/**
 * 获取消息接收者列表
 * @param $condition
 * @return mixed
 */
function notice_get_receiver_count($condition){
    return M('notice_receiver')->where($condition)->count();
}

/**
 * 获取消息接收者列表
 * @param $condition
 * @param int $count
 * @param int $offset
 * @param null $order
 * @return array
 */
function notice_get_receiver_list($condition, $count=20, $offset=0, $order=null){
    $limit = $count ? "$offset, $count" : ($offset ? $offset : '');
    !$order && $order = 'id DESC';
    $itemlist = M('notice_receiver')->where($condition)->order($order)->limit($limit)->select();
    return $itemlist ? $itemlist : array();
}

/**
 * 添加消息模板
 * @param $data
 * @return bool|int|mysqli_result|string
 */
function notice_add_template($data){
    return M('notice_template')->insert($data, true);
}

/**
 * 删除模板
 * @param $condition
 * @return bool|int
 */
function notice_delete_template($condition){
    return $condition ? M('notice_template')->where($condition)->delete() : false;
}

/**
 * 更新模板
 * @param $condition
 * @param $data
 * @return bool|int
 */
function notice_update_template($condition, $data){
    return M('notice_template')->where($condition)->update($data);
}

/**
 * 获取模板信息
 * @param $condition
 * @return array|null
 */
function notice_get_template($condition){
    $data = M('notice_template')->where($condition)->getOne();
    return $data ? $data : array();
}

/**
 * 获取通知列表
 * @param $condition
 * @return array
 */
function notice_get_template_list($condition){
    $itemlist = M('notice_template')->where($condition)->select();
    return $itemlist ? $itemlist : array();
}