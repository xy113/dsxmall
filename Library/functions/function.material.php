<?php
/**
 * 添加素材
 * @param array $data
 * @param string $return
 * @return mixed
 */
function material_add_data($data, $return=FALSE){
	$id = M('material')->insert($data, true);
	if ($return) {
		return material_get_data(array('id'=>$id));
	}else {
		return $id;
	}
}

/**
 * 删除素材
 * @param mixed $condition
 * @return boolean|number|boolean
 */
function material_delete_data($condition){
	if ($condition) {
		return M('material')->where($condition)->delete();
	}else {
		return false;
	}
}

/**
 * 更新素材
 * @param mixed $condition
 * @param array $data
 * @return boolean|number
 */
function material_update_data($condition, $data){
	return M('material')->where($condition)->update($data);
}

/**
 * 获取素材信息
 * @param mixed $condition
 */
function material_get_data($condition){
	$data = M('material')->where($condition)->getOne();
	if ($data) {
		return $data;
	}else {
		return array();
	}
}

/**
 * 获取素材数目
 * @param mixed $condition
 * @param string $field
 * @return mixed
 */
function material_get_count($condition, $field='*'){
	return M('material')->where($condition)->count($field);
}

/**
 * 获取素材列表
 * @param mixed $condition
 * @param number $count
 * @param number $offset
 * @param mixed $order
 */
function material_get_list($condition, $count=20, $offset=0, $order=null){
	$limit = $count ? "$offset, $count" : ($offset ? $offset : '');
	$order = $order ? $order : 'id DESC';
	$itemlist = M('material')->where($condition)->limit($limit)->order($order)->select();
	if ($itemlist) {
		return $itemlist;
	}else {
		return array();
	}
}

/**
 * 新建专辑
 * @param array $data
 * @param string $return
 * @return mixed
 */
function album_add_data($data, $return=false){
	$albumid = M('album')->insert($data, true);
	if ($return) {
		return album_get_data(array('albumid'=>$albumid));
	}else {
		return $albumid;
	}
}

/**
 * 删除专辑
 * @param mixed $condition
 * @return boolean|number|boolean
 */
function album_delete_data($condition){
	if ($condition) {
		return M('album')->where($condition)->delete();
	}else {
		return false;
	}
}

/**
 * 更新专辑
 * @param mixed $condition
 * @param array $data
 * @return boolean|number
 */
function album_update_data($condition, $data){
	return M('album')->where($condition)->update($data);
}

/**
 * 获取专辑信息
 * @param mixed $condition
 */
function album_get_data($condition){
	$data = M('album')->where($condition)->getOne();
	if ($data) {
		return $data;
	}else {
		return array();
	}
}

/**
 * 获取专辑数目
 * @param mixed $condition
 * @return mixed
 */
function album_get_count($condition){
	return M('album')->where($condition)->count();
}

/**
 * 获取专辑列表
 * @param mixed $condition
 * @param number $count
 * @param number $offset
 * @param mixed $order
 */
function album_get_list($condition, $count=20, $offset=0, $order=null){
	$limit = $count ? "$offset, $count" : ($offset ? $offset : '');
	$order = $order ? $order : 'albumid ASC';
	$itemlist = M('album')->where($condition)->limit($limit)->order($order)->select();
	if ($itemlist) {
		return $itemlist;
	}else {
		return array();
	}
}