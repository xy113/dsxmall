<?php

/**
 * 添加广告
 * @param array $data
 * @param bool $return
 * @return array|bool|int|mysqli_result|null|string
 */

function ad_add_data($data, $return=FALSE){
	$id = M('ad')->insert($data, true);
    return $return ? ad_get_data(array('id' => $id)) : $id;
}

/**
 * 删除广告
 * @param mixed $condition
 * @return bool|int
 */
function ad_delete_data($condition){
    return $condition ? M('ad')->where($condition)->delete() : false;
}

/**
 * 更新广告
 * @param mixed $condition
 * @param array $data
 * @return bool|int
 */
function ad_update_data($condition,$data){
	return M('ad')->where($condition)->update($data);
}

/**
 * 获取广告信息
 * @param mixed $condition
 * @return array|null
 */
function ad_get_data($condition){
	return M('ad')->where($condition)->getOne();
}

/**
 * 获取广告数量
 * @param mixed $condition
 * @return mixed
 */
function ad_get_count($condition){
	return M('ad')->where($condition)->count();
}

/**
 * 获取广告列表
 * @param mixed $condition
 * @param number $count
 * @param number $offset
 * @param string $order
 * @return array
 */
function ad_get_list($condition, $count=10, $offset=0, $order=null){
	$limit = $count ? "$offset,$count" : ($offset ? $offset : '');
	!$order && $order = 'displayorder ASC,id ASC';
	$adlist = M('ad')->where($condition)->limit($limit)->order($order)->select();
	return $adlist ? $adlist : array();
}

/**
 * 获取广告代码
 * @param int $id
 * @return string
 */
function ad_get_html_by_id($id){
	$data = ad_get_data(array('id'=>$id));
	return ad_get_html_by_data($data);
}

/**
 * 获取广告代码
 * @param array $data
 * @return string
 */
function ad_get_html_by_data($data){
	$html = '';
	$addata = unserialize($data['data'][$data['type']]);
	if ($addata) {
		if ($data['type'] == 'text') {
			$html = '<div><a href="'.$addata['link'].'" target="_blank"  onclick="DSXCMS.adClick('.$data['id'].')">'.$addata['text'].'</a></div>';
		}elseif ($data['type'] == 'image') {
			$style = '';
			$addata['width']  = is_numeric($addata['width']) ? $addata['width'].'px' : $addata['width'];
			$addata['height'] = is_numeric($addata['height']) ? $addata['height'].'px' : $addata['height'];
			$style = $addata['width'] ? 'width:'.$data['width'].';' : '';
			$style.= $addata['height'] ? 'height:'.$addata['height'].';' : '';
			$style = $style ? ' style="'.$style.'"' : '';
			$html = '<div><a href="'.$addata['link'].'" onclick="DSXCMS.adClick('.$data['id'].')"><img src="'.$addata['image'].'"'.$style.'></a></div>';
		}else {
			$html = '<div onclick="DSXCMS.adClick('.$data['id'].')">'.$addata['code'].'</div>';
		}
	}
	return $html;
}

/**
 * =================
 * 页面管理
 * =================
 */

/**
 * 添加页面
 * @param array $data
 * @param string $return
 * @return array|bool|int|mysqli_result|null|string
 */
function page_add_data($data, $return=false){
	$pageid = M('page')->insert($data, true);
    return $return ? page_get_data(array('pageid' => $pageid)) : $pageid;
}

/**
 * 删除页面
 * @param mixed $condition
 * @return bool|int
 */
function page_delete_data($condition){
    return !$condition ? false : M('page')->where($condition)->delete();
}

/**
 * 更新页面信息
 * @param mixed $condition
 * @param array $data
 * @return bool|int
 */
function page_update_data($condition, $data){
	return M('page')->where($condition)->update($data);
}

/**
 * 获取页面信息
 * @param mixed $condition
 * @return array|null
 */
function page_get_data($condition){
	return M('page')->where($condition)->getOne();
}

/**
 * 获取页面数目
 * @param mixed $condition
 * @return mixed
 */
function page_get_count($condition){
	return M('page')->where($condition)->count();
}

/**
 * 获取页面列表
 * @param mixed $condition
 * @param number $count
 * @param number $offset
 * @param string $order
 * @return array
 */
function page_get_list($condition, $count=10, $offset=0, $order=null){
	$limit = $count ? "$offset,$count" : ($offset ? $offset : '');
	!$order && $order = "displayorder ASC,pageid ASC";
	$pagelist = M('page')->where($condition)->limit($limit)->order($order)->select();
    return $pagelist ? $pagelist : array();
}

/**
 * ======================
 * 区域管理
 * ======================
 */

/**
 * 添加区域信息
 * @param array $data
 * @param string $return
 * @return array|bool|int|mysqli_result|null|string
 */
function district_add_data($data, $return=FALSE){
	$id = M('district')->insert($data, true);
    return $return ? district_get_data(array('id' => $id)) : $id;
}

/**
 * 删除区域信息
 * @param mixed $condition
 * @return bool|int
 */
function district_delete_data($condition){
    return !$condition ? false : M('district')->where($condition)->delete();
}

/**
 * 更新区域信息
 * @param mixed $condition
 * @param array $data
 * @return bool|int
 */
function district_update_data($condition, $data){
	return M('district')->where($condition)->update($data);
}

/**
 * 获取区域信息
 * @param mixed $condition
 * @return array|null
 */
function district_get_data($condition){
	return M('district')->where($condition)->getOne();
}

/**
 * 获取区域数目
 * @param mixed $condition
 * @return mixed
 */
function district_get_count($condition=''){
	return M('district')->where($condition)->count();
}

/**
 * 获取区域列表
 * @param mixed $condition
 * @param int|number $count
 * @param int|number $offset
 * @param string $order
 * @param string $field
 * @return array
 */
function district_get_list($condition, $count=20, $offset=0, $order=null, $field='*'){
	$limit = $count ? "$offset, $count" : ($offset ? $offset : '');
	!$order && $order = 'displayorder ASC,id ASC';
	$itemlist = M('district')->field($field)->where($condition)->limit($limit)->order($order)->select();
    return $itemlist ? $itemlist : array();
}

/**
 * 获取区域列表选项
 * @param $condition
 * @param int $selected
 * @param int $count
 * @param int $offset
 * @param string $order
 * @return string
 */
function district_get_options($condition, $selected=0, $count=20, $offset=0, $order=''){
	$options = '';
	$districtlist = district_get_list($condition, $count, $offset, $order);
	foreach ($districtlist as $id=>$data){
		$a = $selected == $id ? ' selected="selected"' : '';
		$options.= '<option value="'.$id.'"'.$a.'>'.$data['name'].'</option>';
	}
	return $options;
}

/**
 * ===================
 * 链接管理
 * ===================
 */

/**
 * 添加链接
 * @param array $data
 * @param string $return
 * @return array|bool|int|mysqli_result|null|string
 */
function link_add_data($data, $return=FALSE){
	$id = M('link')->insert($data, true);
    return $return ? link_get_data(array('id' => $id)) : $id;
}

/**
 * 删除链接
 * @param mixed $condition
 * @return bool|int
 */
function link_delete_data($condition){
    return $condition ? M('link')->where($condition)->delete() : false;
}

/**
 * 更新链接
 * @param mixed $condition
 * @param array $data
 * @return bool|int
 */
function link_update_data($condition, $data){
	return M('link')->where($condition)->update($data);
}

/**
 * 获取链接信息
 * @param mixed $condition
 * @return array|null
 */
function link_get_data($condition){
	return M('link')->where($condition)->getOne();
}

/**
 * 获取链接数目
 * @param mixed $condition
 * @return mixed
 */
function link_get_count($condition){
	return M('link')->where($condition)->count();
}

/**
 * 获取链接列表
 * @param mixed $condition
 * @param int|number $count
 * @param int|number $offset
 * @param string $order
 * @return unknown[]
 */
function link_get_list($condition, $count=20, $offset=0, $order=null){
	$limit = $count ? "$offset,$count" : ($offset ? $offset : '');
	!$order && $order = 'displayorder ASC, id ASC';
	$itemlist = M('link')->where($condition)->limit($limit)->order($order)->select();
    return $itemlist ? $itemlist : array();
}

/**
 * =============================
 * 添加关注
 * =============================
 */

/**
 * 加关注
 * @param array $data
 * @param string $return
 * @return array|bool|int|mysqli_result|null|string
 */
function follow_add_data($data, $return=false){
	$id = M('follow')->insert($data, true);
	if ($return) {
		return follow_get_data(array('id'=>$id));
	}else {
		return $id;
	}
}

/**
 * 取消关注
 * @param mixed $condition
 * @return bool|int
 */
function follow_delete_data($condition){
	if (!$condition) {
		return false;
	}else {
		return M('follow')->where($condition)->delete();
	}
}

/**
 * 更新关注
 * @param mixed $condition
 * @param array $data
 * @return bool|int
 */
function follow_update_data($condition, $data){
	return M('follow')->where($condition)->update($data);
}

/**
 * 获取关注信息
 * @param mixed $condition
 * @return array|null
 */
function follow_get_data($condition){
	return M('follow')->where($condition)->getOne();
}

/**
 * 获取关注数
 * @param mixed $condition
 * @return mixed
 */
function follow_get_count($condition){
	return M('follow')->where($condition)->count();
}

/**
 * 获取关注列表
 * @param mixed $condition
 * @param number $num
 * @param number $limit
 * @param mixed $order
 * @return array
 */
function follow_get_list($condition, $count=20, $offset=0, $order=null){
	$limit = $count ? "$offset, $count" : ($offset ? $offset : '');
	$itemlist = M('follow')->where($condition)->limit($limit)->order($order)->select();
    return $itemlist ? $itemlist : array();
}

/**
 * ===================
 * 收藏管理
 * ===================
 */

/**
 * 添加收藏
 * @param mixed $data
 * @param bool|string $return
 * @return array|bool|int|mysqli_result|null|string
 */
function favorite_add_data($data, $return=false){
	$id = M('favorite')->insert($data, true, true);
    return $return ? favorite_get_data(array('id' => $id)) : $id;
}

/**
 * 取消收藏
 * @param mixed $condition
 * @return bool|int
 */
function favorite_delete_data($condition){
    return $condition ? M('favorite')->where($condition)->delete() : false;
}

/**
 * 更新收藏
 * @param mixed $condition
 * @param array $data
 * @return bool|int
 */
function favorite_update_data($condition,$data){
	return M('favorite')->where($condition)->update($data);
}

/**
 * 获取收藏信息
 * @param mixed $condition
 * @return array|null
 */
function favorite_get_data($condition){
	return M('favorite')->where($condition)->getOne();
}

/**
 * 获取收藏数目
 * @param mixed $condition
 * @return mixed
 */
function favorite_get_count($condition){
	return M('favorite')->where($condition)->count();
}

/**
 * 获取收藏列表
 * @param mixed $condition
 * @param number $count
 * @param number $offset
 * @param string $order
 * @return array
 */
function favorite_get_list($condition, $count=20, $offset=0, $order=null){
	$limit = $count ? "$offset, $count" : ($offset ? $offset : '');
	!$order && $order = 'favid DESC';
	$itemlist = M('favorite')->where($condition)->limit($limit)->order($order)->select();
    return $itemlist ? $itemlist : array();
}

/**
 * 添加收货地址
 * @param array $data
 * @param number $return
 * @return array|bool|int|mysqli_result|null|string
 */
function address_add_data($data, $return=0){
	$id = M('address')->insert($data, true);
    return $return ? address_get_data(array('id' => $id)) : $id;
}

/**
 * 删除收货地址
 * @param mixed $condition
 * @return bool|int
 */
function address_delete_data($condition){
    return $condition ? M('address')->where($condition)->delete() : false;
}

/**
 * 更新收货地址
 * @param mixed $condition
 * @param array $data
 * @return bool|int
 */
function address_update_data($condition, $data){
	return M('address')->where($condition)->update($data);
}

/**
 * 获取收货地址
 * @param mixed $condition
 * @return array|null
 */
function address_get_data($condition){
	$data = M('address')->where($condition)->getOne();
    return $data ? $data : array();
}

/**
 * 获取收货地址数目
 * @param mixed $condition
 * @return mixed
 */
function address_get_count($condition){
	return M('address')->where($condition)->count();
}

/**
 * 获取收货地址列表
 * @param mixed $condition
 * @return array
 */
function address_get_list($condition){
	$addresslist = M('address')->where($condition)->order('id ASC')->select();
    return $addresslist ? $addresslist : array();
}

/**
 * 菜单操作
 */

/**
 * 添加菜单项
 * @param array $data
 * @param number $return
 * @return mixed
 */
function menu_add_data($data, $return=0){
	$id = M('menu')->insert($data, true);
    return $return ? menu_get_data(array('id' => $id)) : $id;
}

/**
 * 删除菜单项
 * @param mixed $condition
 * @return boolean|number|boolean
 */
function menu_delete_data($condition){
    return $condition ? M('menu')->where($condition)->delete() : false;
}

/**
 * 更新菜单项
 * @param mixed $condition
 * @param array $data
 * @return boolean|number
 */
function menu_update_data($condition, $data){
	return M('menu')->where($condition)->update($data);
}

/**
 * 更新菜单缓存
 * @return boolean
 */
function menu_update_cache(){
	$menulist = menu_get_list(array('type'=>'menu', 'available'=>1), 0);
	$itemlist = menu_get_list(array('type'=>'item', 'available'=>1), 0);
	$datalist = array();
	foreach ($itemlist as $item){
		$datalist[$item['menuid']][$item['id']] = $item;
	}

	$cachelist = array();
	foreach ($menulist as $menu){
		$menu['items'] = $datalist[$menu['id']];
		$cachelist[$menu['id']] = $menu;
	}

	return cache('menus', $cachelist);
}

/**
 * 获取菜单缓存
 * @param number $menuid
 * @return mixed
 */
function menu_get_cache($menuid = 0){
	$menulist = cache('menus');
	if (!$menulist) $menulist = array();

    return $menuid ? $menulist[$menuid] : $menulist;
}

/**
 * 获取菜单项
 * @param mixed $condition
 * @return array|null
 */
function menu_get_data($condition){
	$data = M('menu')->where($condition)->getOne();
    return $data ? $data : array();
}

/**
 * 获取菜单数目
 * @param mixed $condition
 * @return mixed
 */
function menu_get_count($condition){
	return M('menu')->where($condition)->count();
}

/**
 * 获取菜单列表
 * @param mixed $condition
 * @param int|number $count
 * @param int|number $offset
 * @param mixed $order
 * @return array
 */
function menu_get_list($condition, $count=20, $offset=0, $order=null){
	$limit = $count ? "$offset, $count" : ($offset ? $offset : '');
	$order = $order ? $order : 'displayorder ASC,id ASC';
	$itemlist = M('menu')->where($condition)->limit($limit)->order($order)->select();
    return $itemlist ? $itemlist : array();
}

/**
 * 添加内容块
 * @param $data
 * @param int $return
 * @return bool|int|mysqli_result|string|void
 */
function block_add_data($data, $return=0){
    $block_id = M('block')->insert($data, true);
    return $return ? block_get_data(array('block_id'=>$block_id)) : $block_id;
}

/**
 * 删除内容块
 * @param $condition
 * @return bool|int
 */
function block_delete_data($condition){
    return $condition ? M('block')->where($condition)->delete() : false;
}

/**
 * 更新内容块
 * @param $condition
 * @param $data
 * @return bool|int
 */
function block_update_data($condition, $data){
    return M('block')->where($condition)->update($data);
}

/**
 * 获取块内容
 * @param $condition
 * @return array|null
 */
function block_get_data($condition){
    $data = M('block')->where($condition)->getOne();
    return $data ? $data : array();
}

/**
 * 获取块列表
 * @param $condition
 * @return mixed
 */
function block_get_count($condition){
    return M('block')->where($condition)->count();
}

/**
 * 获取块列表
 * @param $condition
 * @param int $count
 * @param int $offset
 * @return array
 */
function block_get_list($condition, $count=20, $offset=0){
    $limit = $count ? "$offset,$count" : ($offset ? $offset : '');
    $itemlist = M('block')->where($condition)->order('block_id', 'ASC')->limit($limit)->select();
    return $itemlist ? $itemlist : array();
}

/**
 * 更新缓存
 * @param $block_id
 * @return bool|mixed
 */
function block_set_cache($block_id){
    $itemlist = block_get_item_list(array('block_id'=>$block_id), 0);
    return cache('block_items_'.$block_id, $itemlist);
}

/**
 * @param $block_id
 * @return bool|mixed
 */
function block_get_cache($block_id){
    $itemlist = cache('block_items_'.$block_id);
    if (!is_array($itemlist)) {
        block_set_cache($block_id);
        return block_get_cache($block_id);
    }else {
        return $itemlist;
    }
}

/**
 * 添加项目
 * @param $data
 * @param int $return
 * @return bool|int|mysqli_result|string|void
 */
function block_add_item($data, $return=0){
    $id = M('block_item')->insert($data, true);
    return $return ? block_get_item(array('id'=>$id)) : $id;
}

/**
 * 删除项
 * @param $condition
 * @return bool|int
 */
function block_delete_item($condition){
    return $condition ? M('block_item')->where($condition)->delete() : false;
}

/**
 * 更新项
 * @param $condition
 * @param $data
 * @return bool|int
 */
function block_update_item($condition, $data){
    return M('block_item')->where($condition)->update($data);
}

/**
 * 获取项
 * @param $condition
 * @return array|null
 */
function block_get_item($condition){
    $data = M('block_item')->where($condition)->getOne();
    return $data ? $data : array();
}

/**
 * @param $condition
 * @return mixed
 */
function block_get_item_count($condition){
    return M('block_item')->where($condition)->count();
}

/**
 * @param $condition
 * @param int $count
 * @param int $offset
 * @return array
 */
function block_get_item_list($condition, $count=20, $offset=0){
    $limit = $count ? "$offset, $count" : ($offset ? $offset : '');
    $itemlist = M('block_item')->where($condition)->order('displayorder ASC,id ASC')->limit($limit)->select();
    return $itemlist ? $itemlist : array();
}

/**
 * 添加评论
 * @param array $data
 * @param bool|string $return
 * @return mixed
 */
function comment_add_data($data, $return=FALSE){
    $id = M('comment')->insert($data, true);
    return $return ? comment_get_data(array('id' => $id)) : $id;
}

/**
 * 更新评论信息
 * @param mixed $condition
 * @param mixed $data
 * @return bool|int
 */
function comment_update_data($condition, $data){
    return M('comment')->where($condition)->update($data);
}

/**
 * 删除评论
 * @param mixed $condition
 * @return bool|int
 */
function comment_delete_data($condition){
    return $condition ? M('comment')->where($condition)->delete() : false;
}

/**
 * 获取单条评论列表
 * @param mixed $condition
 * @return array|null
 */
function comment_get_data($condition){
    $comment = M('comment')->where($condition)->getOne();
    return $comment ? $comment : array();
}

/**
 * 获取评论数量
 * @param mixed $condition
 * @return mixed
 */
function comment_get_count($condition, $field='*'){
    return M('comment')->where($condition)->count($field);
}

/**
 * 获取评论列表
 * @param mixed $condition
 * @param int|number $count
 * @param int|number $offset
 * @param string $order
 * @return array[]
 */
function comment_get_list($condition, $count=20, $offset=0, $order=null){
    $limit = $count ? "$offset, $count" : ($offset ? $offset : '');
    $order = $order ? $order : 'cid ASC';
    $itemlist = M('comment')->where($condition)->limit($limit)->order($order)->select();
    return $itemlist ? $itemlist : array();
}