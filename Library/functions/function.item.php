<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/2
 * Time: 下午2:09
 */

function item_create_sn(){
    return time().rand(100,999).rand(100,999);
}
/**
 * 添加商品信息
 * @param $data
 * @param int $return
 * @return array|bool|int|mysqli_result|null|string
 */
function item_add_data($data, $return=0){
    $itemid = M('item')->insert($data, true, true);
    return $return ? item_get_data(array('itemid'=>$itemid)) : $itemid;
}

/**
 * 删除商品信息
 * @param $condition
 * @return bool|int
 */
function item_delete_data($condition){
    return $condition ? M('item')->where($condition)->delete() : false;
}

/**
 * 更新商品信息
 * @param $condition
 * @param $data
 * @return bool|int
 */
function item_update_data($condition, $data){
    return M('item')->where($condition)->update($data);
}

/**
 * 获取商品信息
 * @param $condition
 * @param string $field
 * @return array|null
 */
function item_get_data($condition, $field='*'){
    $data = M('item')->where($condition)->field($field)->getOne();
    return $data ? $data : array();
}

/**
 * 获取商品数量
 * @param $condition
 * @param string $field
 * @return mixed
 */
function item_get_count($condition, $field='*'){
    return M('item')->where($condition)->count($field);
}

/**
 * 获取商品列表
 * @param $condition
 * @param int $count
 * @param int $offset
 * @param null $order
 * @param string $field
 * @return array
 */
function item_get_list($condition, $count=20, $offset=0, $order=null, $field='*'){
    $limit = $count ? "$offset, $count" : ($offset ? $offset : '');
    !$order && $order = 'itemid DESC';
    $itemlist = M('item')->field($field)->where($condition)->order($order)->limit($limit)->select();
    return $itemlist ? $itemlist : array();
}

/**
 * 添加商品介绍
 * @param $data
 * @return bool|int|mysqli_result|string
 */
function item_add_desc($data){
    return M('item_desc')->insert($data, false, true);
}

/**
 * 删除商品介绍
 * @param $condition
 * @return bool|int
 */
function item_delete_desc($condition){
    return $condition ? M('item_desc')->where($condition)->delete() : false;
}

/**
 * 更新商品介绍
 * @param $condition
 * @param $data
 * @return bool|int
 */
function item_update_desc($condition, $data){
    return M('item_desc')->where($condition)->update($data);
}

/**
 * 获取商品介绍
 * @param $condition
 * @param string $field
 * @return array|bool|null
 */
function item_get_desc($condition, $field='*'){
    $data = M('item_desc')->where($condition)->field($field)->getOne();
    return $data ? $data : false;
}

/**
 * 添加商品图片
 * @param $data
 * @param int $return
 * @return array|bool|int|mysqli_result|null|string
 */
function item_add_image($data, $return=0){
    $id = M('item_image')->insert($data, true);
    return $return ? item_get_image(array('id'=>$id)) : $id;
}

/**
 * 删除商品图片
 * @param $condition
 * @return bool|int
 */
function item_delete_image($condition){
    return $condition ? M('item_image')->where($condition)->delete() : false;
}

/**
 * 更新商品图片
 * @param $condition
 * @param $data
 * @return bool|int
 */
function item_update_image($condition, $data){
    return M('item_image')->where($condition)->update($data);
}

/**
 * 获取商品图片
 * @param $condition
 * @return array|null
 */
function item_get_image($condition){
    $data = M('item_image')->where($condition)->getOne();
    return $data ? $data : array();
}

/**
 * 获取商品图片列表
 * @param $condition
 * @return array
 */
function item_get_image_list($condition){
    $itemlist = M('item_image')->where($condition)->order('id ASC')->select();
    return $itemlist ? $itemlist : array();
}

/**
 * 添加产品分类
 * @param $data
 * @param int $return
 * @return array|bool|int|mysqli_result|null|string
 */
function item_add_cat($data, $return=0){
    $catid = M('item_cat')->insert($data, true);
    return $return ? item_get_cat(array('catid'=>$catid)) : $catid;
}

/**
 * 删除产品分类
 * @param $condition
 * @return bool|int
 */
function item_delete_cat($condition){
    return $condition ? M('item_cat')->where($condition)->delete() : false;
}

/**
 * 更新产品分类新
 * @param $condition
 * @param $data
 * @return bool|int
 */
function item_update_cat($condition, $data){
    return M('item_cat')->where($condition)->update($data);
}

/**
 * 获取产品分类信息
 * @param $condition
 * @param string $field
 * @return array|null
 */
function item_get_cat($condition, $field='*'){
    $data = M('item_cat')->where($condition)->field($field)->getOne();
    return $data ? $data : array();
}

/**
 * 获取产品分类数量
 * @param $condition
 * @return mixed
 */
function item_get_cat_count($condition){
    return M('item_cat')->where($condition)->count();
}

/**
 * 获取分类列表
 * @param int $usecache
 * @return array
 */
function item_get_cat_list($usecache=1){
    if ($usecache) {
        $itemlist = cache('itemcat');
        if (!is_array($itemlist)) {
            item_update_cat_cache();
            return cache('itemcat');
        }else {
            return $itemlist;
        }
    }else {
        $itemlist = M('item_cat')->order('displayorder ASC,catid ASC')->select();
        if ($itemlist) {
            $datalist = array();
            foreach ($itemlist as $item){
                $datalist[$item['catid']] = $item;
            }
            return $datalist;
        }else {
            return array();
        }
    }
}

/**
 * 更新分类缓存
 * @return bool|mixed
 */
function item_update_cat_cache(){
    return cache('itemcat', item_get_cat_list(0));
}

/**
 * @param $itemid
 * @return bool|int|mysqli_result|string
 */
function item_add_recommend($itemid){
    return M('item_recommend')->insert(array('itemid'=>$itemid), false, true);
}

/**
 * @param $condition
 * @return bool|int
 */
function item_detete_recommend($condition){
    return $condition ? M('item_recommend')->where($condition)->delete() : false;
}

/**
 * @return mixed
 */
function item_get_recommend_count(){
    return M('item_recommend')->count();
}

/**
 * @param $condition
 * @param int $count
 * @param int $offset
 * @param null $order
 * @return array
 */
function item_get_recommend_list($condition, $count=20, $offset=0, $order=null){
    $limit = $count ? "$offset, $count" : ($offset ? $offset : '');
    !$order && $order = 'id DESC';
    $itemlist = M('item_recommend')->where($condition)->order($order)->limit($limit)->select();
    return $itemlist;
}