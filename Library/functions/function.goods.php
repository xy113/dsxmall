<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/2
 * Time: 下午2:09
 */

function goods_create_sn(){
    return time().rand(100,999).rand(100,999);
}
/**
 * 添加商品信息
 * @param $data
 * @param int $return
 * @return array|bool|int|mysqli_result|null|string
 */
function goods_add_item($data, $return=0){
    $id = M('goods_item')->insert($data, true);
    return $return ? goods_get_item(array('id'=>$id)) : $id;
}

/**
 * 删除商品信息
 * @param $condition
 * @return bool|int
 */
function goods_delete_item($condition){
    return $condition ? M('goods_item')->where($condition)->delete() : false;
}

/**
 * 更新商品信息
 * @param $condition
 * @param $data
 * @return bool|int
 */
function goods_update_item($condition, $data){
    return M('goods_item')->where($condition)->update($data);
}

/**
 * 获取商品信息
 * @param $condition
 * @param string $field
 * @return array|null
 */
function goods_get_item($condition, $field='*'){
    $data = M('goods_item')->where($condition)->field($field)->getOne();
    return $data ? $data : array();
}

/**
 * 获取商品数量
 * @param $condition
 * @param string $field
 * @return mixed
 */
function goods_get_item_count($condition, $field='*'){
    return M('goods_item')->where($condition)->count($field);
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
function goods_get_item_list($condition, $count=20, $offset=0, $order=null, $field='*'){
    $limit = $count ? "$offset, $count" : ($offset ? $offset : '');
    !$order && $order = 'id DESC';
    $itemlist = M('goods_item')->field($field)->where($condition)->order($order)->limit($limit)->select();
    return $itemlist ? $itemlist : array();
}

/**
 * 添加商品介绍
 * @param $data
 * @return bool|int|mysqli_result|string
 */
function goods_add_desc($data){
    return M('goods_desc')->insert($data, false, true);
}

/**
 * 删除商品介绍
 * @param $condition
 * @return bool|int
 */
function goods_delete_desc($condition){
    return $condition ? M('goods_desc')->where($condition)->delete() : false;
}

/**
 * 更新商品介绍
 * @param $condition
 * @param $data
 * @return bool|int
 */
function goods_update_desc($condition, $data){
    return M('goods_desc')->where($condition)->update($data);
}

/**
 * 获取商品介绍
 * @param $condition
 * @param string $field
 * @return array|bool|null
 */
function goods_get_desc($condition, $field='*'){
    $data = M('goods_desc')->where($condition)->field($field)->getOne();
    return $data ? $data : false;
}

/**
 * 添加商品图片
 * @param $data
 * @param int $return
 * @return array|bool|int|mysqli_result|null|string
 */
function goods_add_image($data, $return=0){
    $id = M('goods_image')->insert($data, true);
    return $return ? goods_get_image(array('id'=>$id)) : $id;
}

/**
 * 删除商品图片
 * @param $condition
 * @return bool|int
 */
function goods_delete_image($condition){
    return $condition ? M('goods_image')->where($condition)->delete() : false;
}

/**
 * 更新商品图片
 * @param $condition
 * @param $data
 * @return bool|int
 */
function goods_update_image($condition, $data){
    return M('goods_image')->where($condition)->update($data);
}

/**
 * 获取商品图片
 * @param $condition
 * @return array|null
 */
function goods_get_image($condition){
    $data = M('goods_image')->where($condition)->getOne();
    return $data ? $data : array();
}

/**
 * 获取商品图片列表
 * @param $condition
 * @return array
 */
function goods_get_image_list($condition){
    $itemlist = M('goods_image')->where($condition)->order('id ASC')->select();
    return $itemlist ? $itemlist : array();
}

/**
 * 添加产品分类
 * @param $data
 * @param int $return
 * @return array|bool|int|mysqli_result|null|string
 */
function goods_add_cat($data, $return=0){
    $catid = M('goods_cat')->insert($data, true);
    return $return ? goods_get_cat(array('catid'=>$catid)) : $catid;
}

/**
 * 删除产品分类
 * @param $condition
 * @return bool|int
 */
function goods_delete_cat($condition){
    return $condition ? M('goods_cat')->where($condition)->delete() : false;
}

/**
 * 更新产品分类新
 * @param $condition
 * @param $data
 * @return bool|int
 */
function goods_update_cat($condition, $data){
    return M('goods_cat')->where($condition)->update($data);
}

/**
 * 获取产品分类信息
 * @param $condition
 * @param string $field
 * @return array|null
 */
function goods_get_cat($condition, $field='*'){
    $data = M('goods_cat')->where($condition)->field($field)->getOne();
    return $data ? $data : array();
}

/**
 * 获取产品分类数量
 * @param $condition
 * @return mixed
 */
function goods_get_cat_count($condition){
    return M('goods_cat')->where($condition)->count();
}

/**
 * 获取分类列表
 * @param int $usecache
 * @return array
 */
function goods_get_cat_list($usecache=1){
    if ($usecache) {
        $itemlist = cache('goodscat');
        if (!is_array($itemlist)) {
            goods_update_cat_cache();
            return cache('goodscat');
        }else {
            return $itemlist;
        }
    }else {
        $itemlist = M('goods_cat')->order('displayorder ASC,catid ASC')->select();
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
function goods_update_cat_cache(){
    return cache('goodscat', goods_get_cat_list(0));
}