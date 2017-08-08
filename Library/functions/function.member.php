<?php
/**
 * 显示登录界面
 */
function member_show_login(){
	global $G,$lang;
	$G['m'] = 'member';
	$G['title'] = $lang['login'];
	include template('login','account');
	exit();
}

/**
 * 显示AJAX登录界面
 */
function member_show_ajax_login(){
	global $G,$lang;
	$G['m'] = 'member';
	$G['title'] = $lang['login'];
	include template('ajaxlogin','account');
	exit();
}

/**
 * 显示注册页面
 */
function member_show_register(){
	global $G,$lang;
	$G['m'] = 'member';
	$G['title'] = $lang['register'];
	include template('register','account');
	exit();
}

/**
 * 显示AJAX注册页面
 */
function member_show_ajax_register(){
	global $G,$lang;
	$G['m'] = 'member';
	$G['title'] = $lang['register'];
	include template('ajaxregister','account');
	exit();
}

/**
 * 更新cookie
 * @param int $uid
 * @return boolean
 */
function member_update_cookie($uid){
	$condition = array('uid'=>$uid);
	$member    = member_get_data($condition);
    if ($member) {
        unset($member['password']);
        $group = member_get_group(array('gid'=>$member['gid']));
        $member = array_merge($member, $group);
        cookie('uid', $member['uid']);
        cookie('username', $member['username']);
        cookie('udata', authcode(serialize($member)));
    }
	return true;
}

/**
 * 用户登录
 * @param string $username
 * @param string $password
 * @param string $field
 * @return array
 */
function member_login($username, $password, $field='username'){
	if (!$username) {
		return array(
				'errno'=>1,
				'error'=>'account_incorrect'
		);
	}
	if (!$password) {
		return array(
				'errno'=>2,
				'error'=>'password_incorrect'
		);
	}
	
	$field = in_array($field, array('uid','email','mobile')) ? $field : 'username';
	$member = member_get_data(array($field=>$username));
	if (!$member){
		return array(
				'errno'=>3,
				'error'=>'account_invalid'
		);
	}else  {
		if ($member['password'] !== getPassword($password)){
			return array(
					'errno'=>4,
					'error'=>'password_incorrect'
			);
		}elseif ($member['status'] == '-1'){
			return array(
					'errno'=>5,
					'error'=>'login_be_forbidden'
			);
		}elseif ($member['status'] == '-2'){
			return array(
					'errno'=>6,
					'error'=>'account_unauthorized'
			);
		}else {
			member_add_log($member['uid'], 'login');
			member_update_status(array('uid'=>$member['uid']), array(
					'lastvisit'=>TIMESTAMP,
					'lastvisitip'=>getIp()
			));
			member_update_cookie($member['uid']);
            unset($member['password']);
			return array(
					'errno'=>0,
					'error'=>'success',
					'userinfo'=>$member
			);
		}
	}
}

/**
 * 退出登录
 */
function member_logout(){
	member_update_status(array('uid'=>G('uid')), array('lastactive'=>TIMESTAMP));
	cookie('udata', null);
}

/**
 * 用户注册
 * @param array $data
 * @param number $login
 */
function member_register($data, $login=0){	
	$newmember = array();
	if (!$data['username'] && !$data['email'] && !$data['mobile']) {
		return array(
				'errno'=>1,
				'error'=>'invalid_parameter'
		);
	}else {
		if ($data['username']) {
			$newmember['username'] = $data['username'];
			if (member_get_count(array('username'=>$data['username']))) {
				//用户名已被人使用
				return array(
						'errno'=>2,
						'error'=>'username_be_occupied'
				);
			}
		}
			
		if ($data['mobile']) {
		    $ismobile = Core\Validate::ismobile($data['mobile']);
			if (!$ismobile) {
				//手机号不合法
				return array(
						'errno'=>3,
						'error'=>'mobile_incorrect'
				);
			}
			
			if (member_get_count(array('mobile'=>$data['mobile']))) {
				//手机号已被使用
				return array(
						'errno'=>4,
						'error'=>'mobile_be_occupied'
				);
			}
			$newmember['mobile'] = $data['mobile'];
		}
			
		if ($data['email']) {
		    $isemail = Core\Validate::isemail($data['email']);
			if (!$isemail) {
				//邮箱格式不合法
				return array(
						'errno'=>5,
						'error'=>'email_be_occupied'
				);
			}
			
			if (member_get_count(array('email'=>$data['email']))) {
				//邮箱已被人使用
				return array(
						'errno'=>6,
						'error'=>'email_be_occupied'
				);
			}
			$newmember['email'] = $data['email'];
		}
	}
	
	if (!$data['password'] || strlen($data['password']) < 6) {
		return array(
				'errno'=>7,
				'error'=>'password_incorrect'
		);
	}else {
		$newmember['password'] = getPassword($data['password']);
	}
	
	if ($data['gid']) {
		$newmember['gid'] = $data['gid'];
	}else {
		$group = M('member_group')->where("type='member' AND creditslower>=0")
		->order('creditslower','ASC')->getOne();
		$newmember['gid'] = $group['gid'];
	}
	
	$uid = member_add_data($newmember);
	member_add_info(array('uid'=>$uid));
	member_add_status(array(
			'uid'=>$uid,
			'regdate'=>time(),
			'regip'=>getIp(),
			'lastvisit'=>time(),
			'lastvisitip'=>getIp()
	));
	member_add_stat(array('uid'=>$uid));
	if (!$newmember['username']) {
		$newmember['username'] = 'user_'.$uid;
		member_update_data(array('uid'=>$uid), array('username'=>$newmember['username']));
	}
	if ($login) {
		return member_login($uid, $data['password'], 'uid');
	}else {
		$member = member_get_data(array('uid'=>$uid));
        unset($member['password']);
		return array(
				'errno'=>0,
				'error'=>'success',
				'userinfo'=>$member
		);
	}
}

/**
 * 添加会员信息
 * @param array $data
 * @param boolean $return
 * @return unknown
 */
function member_add_data($data,$return=FALSE){
	$uid = M('member')->insert($data, true);
	if ($return) {
		return member_get_data(array('uid'=>$uid));
	}else {
		return $uid;
	}
}

/**
 * 删除会员信息
 * @param mixed $condition
 */
function member_delete_data($condition){
	if ($condition){
		return M('member')->where($condition)->delete();
	}else {
		return false;
	}
}

/**
 * 更新用户信息
 * @param mixed $condition
 * @param array $data
 * @return boolean
 */
function member_update_data($condition, $data){
	return M('member')->where($condition)->update($data);
}

/**
 * 获取用户信息
 * @param mixed $condition
 * @return array
 */
function member_get_data($condition){
	$data = M('member')->where($condition)->getOne();
    return $data ? $data : array();
}

/**
 * 获取会员数量
 * @param mixed $condition
 */
function member_get_count($condition){
	return M('member')->where($condition)->count();
}

/**
 * 获取用户列表
 * @param mixed $condition
 * @param number $count
 * @param number $offset
 * @param mixed $order
 * @return string[][]
 */
function member_get_list($condition, $count=20, $offset=0, $order=null){
	global $_lang;
	$limit = $count ? "$offset,$count" : ($offset ? $offset : '');
	$order = $order ? $order : 'uid ASC';
	$memberlist = M('member')->where($condition)->limit($limit)->order($order)->select();
	if ($memberlist){
		$datalist = array();
		foreach ($memberlist as $list){
			unset($list['password']);
			$list['avatar'] = array(
					'big'=>avatar($list['uid'], 'big'),
					'middle'=>avatar($list['uid'], 'middle'),
					'small'=>avatar($list['uid'], 'small')
			);
			$list['status_name'] = $lang['member_status'][$list['status']];
			$datalist[$list['uid']] = $list;
		}
		return $datalist;
	}else {
		return array();
	}
}

/**
 * 添加用户资料
 * @param array $data
 * @return boolean|unknown
 */
function member_add_info($data){
	return M('member_info')->insert($data, false, true);
}

/**
 * 删除用户资料
 * @param mixed $condition
 * @return boolean
 */
function member_delete_info($condition){
	if ($condition) {
		return M('member_info')->where($condition)->delete();
	}else {
		return false;
	}
}

/**
 * 更新用户资料
 * @param mixed $condition
 * @param mixed $data
 * @return boolean
 */
function member_update_info($condition, $data){
	return M('member_info')->where($condition)->update($data);
}

/**
 * 获取用户资料
 * @param mixed $condition
 * @return array
 */
function member_get_info($condition){
	$data = M('member_info')->where($condition)->getOne();
	if ($data) {
		return $data;
	}else {
		return array();
	}
}

/**
 * 获取用户资料列表
 * @param mixed $condition
 * @param number $num
 * @return array
 */
function member_get_info_list($condition, $num=20){
	$datalist = M('member_info')->where($condition)->limit(0, $num)->select();
	if ($datalist) {
		return $datalist;
	}else {
		return array();
	}
}

/**
 * 添加用户统计
 * @param array $data
 * @return boolean|unknown
 */
function member_add_stat($data){
	return M('member_stat')->insert($data, false, true);
}

/**
 * 删除用户统计数据
 * @param mixed $condition
 * @return boolean
 */
function member_delete_stat($condition){
	if ($condition) {
		return M('member_stat')->where($condition)->delete();
	}else {
		return false;
	}
}

/**
 * 更新用户统计
 * @param mixed $condition
 * @param array $data
 * @return boolean
 */
function member_update_stat($condition, $data){
	return M('member_stat')->where($condition)->update($data);
}

/**
 * 获取用户统计数据
 * @param mixed $condition
 * @return array
 */
function member_get_stat($condition){
	$data = M('member_stat')->where($condition)->getOne();
	if ($data) {
		return $data;
	}else {
		return array();
	}
}

/**
 * 获取用户统计列表
 * @param mixed $condition
 * @param number $num
 * @return unknown
 */
function member_get_stat_list($condition, $num=20){
	$datalist = M('member_stat')->where($condition)->limit(0, $num)->select();
	if ($datalist) {
		return $datalist;
	}else {
		return array();
	}
}

/**
 * 添加用户状态
 * @param array $data
 * @return boolean|unknown
 */
function member_add_status($data){
	return M('member_status')->insert($data, false, true);
}

/**
 * 删除用户状态
 * @param mixed $condition
 * @return boolean
 */
function member_delete_status($condition){
	if ($condition) {
		return M('member_status')->where($condition)->delete();
	}else {
		return false;
	}
}

/**
 * 更新用户状态
 * @param mixed $condition
 * @param array $data
 * @return boolean
 */
function member_update_status($condition, $data){
	return M('member_status')->where($condition)->update($data);
}

/**
 * 获取用户状态
 * @param mixed $condition
 */
function member_get_status($condition){
	return M('member_status')->where($condition)->getOne();
}

/**
 * 获取用户统计列表
 * @param mixed $condition
 * @param int $num
 * @return array
 */
function member_get_status_list($condition, $num){
	$datalist = M('member_status')->where($condition)->limit(0,$num)->select();
	if ($datalist) {
		return $datalist;
	}else {
		return array();
	}
}

/**
 * 添加字段
 * @param array $data
 * @return boolean|unknown
 */
function member_add_field($data){
	return M('member_field')->insert($data);
}

/**
 * 删除字段
 * @param mixed $condition
 * @return boolean
 */
function member_delete_field($condition){
	if ($condition) {
		return M('member_field')->where($condition)->delete();
	}else {
		return false;
	}
}

/**
 * 更新字段
 * @param mixed $condition
 * @param array $data
 * @return boolean
 */
function member_update_field($condition,$data){
	return M('member_field')->where($condition)->update($data);
}

/**
 * 获取字段内容
 * @param mixed $condition
 * @return array
 */
function member_get_field($condition){
	$data = M('member_field')->where($condition)->getOne();
	if ($data) {
		return $data;
	}else {
		return array();
	}
}

/**
 * 获取字段数目
 * @param mixed $condition
 * @return integer
 */
function member_get_field_count($condition){
	return M('member_field')->where($condition)->count();
}

/**
 * 获取字段列表
 * @param mixed $condition
 * @param number $count
 * @param number $offset
 * @return array
 */
function member_get_field_list($condition, $count=20, $offset=0){
	$limit = $count ? "$offset,$count" : ($offset ? $offset : '');
	$itemlist = M('member_field')->where($condition)->limit($limit)->select();
	if ($itemlist) {
		return $itemlist;
	}else {
		return array();
	}
}

/**
 * ====================
 * 第三方登录操作
 * ====================
 */

/**
 * 添加连接
 * @param array $data
 * @param number $return
 * @return mixed
 */
function member_add_connect($data, $return=0){
	$id = M('member_connect')->insert($data, true, true);
	if ($return) {
		return member_get_connect(array('id'=>$id));
	}else {
		return $id;
	}
}

/**
 * 删除连接
 * @param mixed $condition
 */
function member_delete_connect($condition){
	if ($condition) {
		return M('member_connect')->where($condition)->delete();
	}else {
		return false;
	}
}

/**
 * 更新连接
 * @param mixed $condition
 * @param array $data
 * @return boolean
 */
function member_update_connect($condition, $data){
	return M('member_connect')->where($condition)->update($data);
}

/**
 * 获取连接信息
 * @param mixed $condition
 * @return array
 */
function member_get_connect($condition){
	$data = M('member_connect')->where($condition)->getOne();
	if ($data) {
		return $data;
	}else {
		return array();
	}
}

/**
 * 获取连接数
 * @param mixed $condition
 * @param string $field
 * @return integer
 */
function member_get_connect_count($condition, $field='*'){
	return M('member_connect')->where($condition)->count($field);
}

/**
 * 获取连接列表
 * @param mixed $condition
 * @param number $count
 * @param number $offset
 * @param unknown $order
 * @return array
 */
function member_get_connect_list($condition, $count=20, $offset=0, $order=null){
	$limit = $count ? "$offset,$count" : ($offset ? $offset : '');
	$order = $order ? $order : 'id DESC';
	$itemlist = M('member_connect')->where($condition)->limit($limit)->order($order)->select();
	if ($itemlist) {
		return $itemlist;
	}else {
		return array();
	}
}

/**
 * =====================
 * 日志操作
 * =====================
 */

/**
 * 添加用户日志
 * @param integer $uid
 * @param string $operate
 * @return boolean|unknown|number|boolean
 */
function member_add_log($uid,$operate){
	if ($uid && $operate) {
		return M('member_log')->insert(array(
				'uid'=>$uid,
				'ip'=>getIp(),
				'operate'=>$operate,
				'dateline'=>TIMESTAMP
		), true);
	}else {
		return false;
	}
}

/**
 * 删除用户日志
 * @param mixed $condition
 * @return boolean|number|boolean
 */
function member_delete_log($condition){
	if ($condition) {
		return M('member_log')->where($condition)->delete();
	}else {
		return false;
	}
}

/**
 * 获取日志数目
 * @param mixed $condition
 * @param string $field
 * @return mixed
 */
function member_get_log_count($condition, $field='*'){
	return M('member_log')->where($condition)->count($field);
}

/**
 * 获取日志列表
 * @param mixed $condition
 * @param number $count
 * @param number $offset
 * @param mixed $order
 * @return array
 */
function member_get_log_list($condition, $count=20, $offset=0, $order=null){
	$limit = $count ? "$offset,$count" : ($offset ? $offset : '');
	$order = $order ? $order : 'id DESC';
	$itemlist = M('member_log')->where($condition)->limit($limit)->order($order)->select();
	if ($itemlist) {
		return $itemlist;
	}else {
		return array();
	}
}

/**
 * =================
 * 权限操作
 * =================
 */

/**
 * 设置权限
 * @param int $uid
 * @param mixed $perms
 */
function member_set_perm($uid, $perms){
	$res = M('member_perm')->where(array('uid'=>$uid))->update($perms);
	if (!$res) {
		if (is_array($perms)) $perms = serialize($perms);
		M('member_perm')->insert(array('uid'=>$uid, 'perm'=>$perms), false, true);
	}
}

/**
 * 获取权限
 * @param integer $uid
 * @param number $cookie
 * @return mixed
 */
function member_get_perm($uid, $cookie=0){
	if ($cookie) {
		$permission = authcode(cookie('my_perm'), 1);
		$myperm = unserialize($permission);
	}
	if (!$myperm){
		$permission = M('member_perm')->where(array('uid'=>$uid))->getOne();
		$myperm = unserialize($permission['perm']);
	}
	return $myperm;
}

function member_check_perm($action){
	
}

/**
 * 删除权限
 * @param mixed $condition
 * @return boolean
 */
function member_delete_perm($condition){
	if ($condition) {
		return M('member_perm')->where($condition)->delete();
	}else {
		return false;
	}
}

/**
 * 添加会员分组
 * @param array $data
 * @param string $return
 * @return array|bool|int|mysqli_result|null|string
 */
function member_add_group($data, $return=FALSE){
	$gid = M('member_group')->insert($data, true);
    return $return ? member_get_group(array('gid'=>$gid)) : $gid;
}

/**
 * 删除用户组
 * @param mixed $condition
 */
function member_delete_group($condition){
    return $condition ? M('member_group')->where($condition)->delete() : false;
}

/**
 * 更新用户组信息
 * @param mixed $condition
 * @param array $data
 */
function member_update_group($condition,$data){
	return M('member_group')->where($condition)->update($data);
}

/**
 * 获取用户组信息
 * @param mixed $condition
 */
function member_get_group($condition, $field='*'){
	$data =  M('member_group')->where($condition)->field($field)->getOne();
    return $data ? $data : array();
}

/**
 * 获取用户分组列表
 * @param mixed $condition
 * @param string $order
 */
function member_get_group_list($usecache=1){
    if ($usecache) {
        $grouplist = cache('member_groups');
        if (!is_array($grouplist)) {
            member_update_group_cache();
            return cache('member_groups');
        }else {
            return $grouplist;
        }
    }else {
        $grouplist = M('member_group')->select();
        if ($grouplist) {
            $datalist = array();
            foreach ($grouplist as $group){
                $datalist[$group['gid']] = $group;
            }
            return $datalist;
        }else {
            return array();
        }
    }
}

/**
 * 更新分组缓存
 * @return bool|mixed
 */
function member_update_group_cache(){
    return cache(member_get_group_list(0));
}