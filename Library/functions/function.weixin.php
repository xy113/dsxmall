<?php
/**
 * 微信登录
 * @param string $openid
 */
function weixin_login($openid){
	$connect = member_get_connect(array('platform'=>'weixin', 'openid'=>$openid));
	if ($connect) {
		member_update_status($connect['uid'], array(
				'lastvisit'=>TIMESTAMP,
				'lastvisitip'=>getIp()
		));
		return member_update_cookie($connect['uid']);
	}else {
		return false;
	}
}

/**
 * 微信注册
 * @param array $userinfo
 */
function weixin_register($userinfo){
	if ($userinfo['nickname'] && $userinfo['openid']){
		$group = M('member_group')->where("type='member' AND creditslower>=0")
		->order('creditslower','ASC')->getOne();
		$uid = member_add_data(array(
				'gid'=>$group['gid'],
				'username'=>$userinfo['nickname']
		));
		member_add_info(array(
				'uid'=>$uid,
				'usersex'=>($userinfo['sex'] == 1 ? 0 : 1),
				'country'=>$userinfo['country'],
				'province'=>$userinfo['province'],
				'city'=>$userinfo['city']
		));
		member_add_status(array(
				'uid'=>$uid,
				'regdate'=>time(),
				'regip'=>getIp(),
				'lastvisit'=>time(),
				'lastvisitip'=>getIp()
		));
		member_add_stat(array(
				'uid'=>$uid
		));
		weixin_sync_headimg($uid, $userinfo['headimgurl']);
		return $uid;
	}else {
		return false;
	}
}

/**
 * 获取用户信息
 * @param string $token
 * @param string $openid
 * @return mixed
 */
function weixin_get_userinfo($token,$openid){
	$res = httpGet("https://api.weixin.qq.com/cgi-bin/user/info?access_token=$token&openid=$openid&lang=zh_CN");
	return json_decode($res, true);
}

/**
 * 同步微信头像
 * @param int $uid
 * @param string $headimgurl
 */
function weixin_sync_headimg($uid,$headimgurl){
	$content = httpGet($headimgurl);
	$handle  = @fopen(CACHE_PATH.$uid.'_avatar.jpg', 'w');
	if ($handle){
		@fwrite($handle, $content);
		$avatardir = C('AVATARDIR').$uid;
		@mkdir($avatardir,0777,true);
		$image = new \Core\Image(CACHE_PATH.$uid.'_avatar.jpg');
		$image->thumb(500, 500);
		$image->save($avatardir.'/big.png');

		$image->thumb(200, 200);
		$image->save($avatardir.'/middle.png');

		$image->thumb(100, 100);
		$image->save($avatardir.'/small.png');
		@unlink(CACHE_PATH.$uid.'_avatar.jpg');
	}
	@fclose($handle);
}

/**
 * 获取公众号access_token
 * @param string $appid
 * @param string $appsecret
 * @return boolean|string
 */
function weixin_get_access_token($appid,$appsecret){
	$token = cache('weixin_access_token');
	if ($token && ((time() - $token['expires_time']) < 0)){
		return $token['access_token'];
	}else {
		$res = httpGet("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret");
		$data = json_decode($res, true);
		if ($data['access_token']) {
			$token = array(
					'access_token'=>$data['access_token'],
					'expires_time'=>(time()+7000),
					'create_time'=>date('Y-m-d H:i:s', time())
			);
			cache('weixin_access_token', $token);
			return $token['access_token'];
		}else {
			return false;
		}
	}
}

/**
 * 获取微信JSPAI ticket
 * @param string $token
 * @return boolean|unknown
 */
function weixin_get_jsapi_ticket($token){
	// 如果是企业号用以下 URL 获取 ticket
	// $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
	$ticket = cache('weixin_jsapi_ticket');
	if ($ticket && ((time() - $ticket['expire_time']) < 0)){
		return $ticket['jsapi_ticket'];
	}else {
		$res = httpGet("https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$token");
		$data = json_decode($res, true);
		if ($data['ticket']){
			$ticket = array(
					'jsapi_ticket'=>$data['ticket'],
					'expire_time'=>(time()+7000),
					'create_time'=>date('Y-m-d H:i:s', time())
			);
			cache('weixin_jsapi_ticket', $ticket);
			return $data['ticket'];
		}else {
			return false;
		}
	}
}

/**
 * 获取微信分享签名
 * @param string $appid
 * @param string $ticket
 * @param string $url
 * @return unknown[]|string[]|NULL[]
 */
function weixin_get_jssdk_sign($appid, $ticket, $url){
	$timestamp = TIMESTAMP;
	$nonceStr  = random(10);
	//$timestamp = "$timestamp";
	// 这里参数的顺序要按照 key 值 ASCII 码升序排序
	$string = "jsapi_ticket=$ticket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
	$signature = sha1($string);
	
	$signPackage = array(
			"appid"     => $appid,
			"noncestr"  => $nonceStr,
			"timestamp" => $timestamp,
			"url"       => $url,
			"signature" => $signature,
			"rawString" => $string
	);
	return $signPackage;
}

/**
 * 发送客服消息
 * @param string $token
 * @param array $message
 * @return boolean|mixed
 */
function weixin_send_msg($token, $message=array()){
	if (!$message['touser'] || !$message['msgtype']){
		return false;
	}else {
		$message = json_encode($message);
		$message = urldecode($message);
		$res = httpPost("https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=$token", $message);
		return json_decode($res, true);
	}
}

/**
 * 发送微信模板消息
 * @param string $token
 * @param string $openid
 * @param string $template_id
 * @param array $data
 * @param string $url
 * @return bool|mixed
 */
function weixin_send_template_msg($token,$openid,$template_id,$data,$url=''){
	if (!$token || !$openid || !$template_id || !$data){
		return false;
	}else {
		$message = array(
				'touser'=>$openid,
				'template_id'=>$template_id,
				'data'=>$data
		);
		if ($url) $message['url'] = $url;
		$message = json_encode($message);
		$res = httpPost("https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$token", $message);
		return $res;
	}
}

/**
 * 创建自定义菜单
 * @param string $token
 * @param string $menu
 * @return mixed
 */
function weixin_create_menu($token, $menu){
	$res = httpPost("https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$token", $menu);
	return json_decode($res, true);
}

/**
 * 删除自定义菜单
 * @param string $token
 * @return mixed
 */
function weixin_delete_menu($token){
	$res = httpGet("https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=$token");
	return json_decode($res, true);
}


/**
 * 添加永久素材到微信服务器
 * @param string $access_token
 * @param string $type
 * @param array $data
 * @return mixed
 */
function weixin_add_material($access_token, $type, $data){
	$res = httpPost("https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=$access_token&type=$type", $data);
	$res = json_decode($res, true);
	return $res;
}

/**
 * 从微信服务器删除永久素材
 * @param string $access_token
 * @param string $media_id
 * @return mixed
 */
function weixin_delete_material($access_token, $media_id){
	$access_data = json_encode(array('media_id'=>$media_id));
	$res = httpPost("https://api.weixin.qq.com/cgi-bin/material/del_material?access_token=$access_token", $access_data);
	return json_decode($res, true);
}

/**
 * 获取永久素材
 * @param string $access_token
 * @param string $media_id
 * @param string $type
 * @return mixed|unknown
 */
function weixin_get_material($access_token, $media_id, $type='image'){
	$access_data = json_encode(array('media_id'=>$media_id));
	$res = httpPost("https://api.weixin.qq.com/cgi-bin/material/get_material?access_token=$access_token", $access_data);
	if ($type == 'image' || $type == 'voice') {
		return $res;
	}else {
		return json_decode($res, true);
	}
}

/**
 * 获取微信素材数目
 * @param string $access_token
 * @return bool|mixed
 */
function weixin_get_material_count($access_token){
	$count = cache('weixin_material_count');
	if (!$count) {
		$count = httpGet("https://api.weixin.qq.com/cgi-bin/material/get_materialcount?access_token=$access_token");
		$count = json_decode($count, true);
		cache('weixin_material_count', $count);
	}
	return $count;
}

/**
 * 从服务器获取微信素材列表
 * @param string $access_token
 * @param string $type
 * @param number $offset
 * @param number $count
 * @return mixed
 */
function weixin_get_material_list($access_token, $type='image', $offset=0, $count=20){
	$access_data = json_encode(array(
			'type'=>$type,
			'offset'=>$offset,
			'count'=>$count
	));
	$res = httpPost("https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=$access_token", $access_data);
	$res = json_decode($res, true);
	return $res;
}

/**
 * 添加图文素材到服务器
 * @param string $access_token
 * @param json $news_data
 * @return mixed
 * @desc
 * {
 "articles": [{
 "title": TITLE,
 "thumb_media_id": THUMB_MEDIA_ID,
 "author": AUTHOR,
 "digest": DIGEST,
 "show_cover_pic": SHOW_COVER_PIC(0 / 1),
 "content": CONTENT,
 "content_source_url": CONTENT_SOURCE_URL
 },    //若新增的是多图文素材，则此处应还有几段articles结构
 ]
 }
 */
function weixin_add_news($access_token, $news_data){
	$res = httpPost("https://api.weixin.qq.com/cgi-bin/material/add_news?access_token=$access_token", $news_data);
	return json_decode($res, true);
}

/**
 * 更新图文消息到服务器
 * @param string $access_token
 * @param string $news_data
 * @return mixed
 * @desc
 {
 "media_id":MEDIA_ID,
 "index":INDEX,
 "articles": {
	 "title": TITLE,
	 "thumb_media_id": THUMB_MEDIA_ID,
	 "author": AUTHOR,
	 "digest": DIGEST,
	 "show_cover_pic": SHOW_COVER_PIC(0 / 1),
	 "content": CONTENT,
	 "content_source_url": CONTENT_SOURCE_URL
	 }
 }
 */
function weixin_update_news($access_token, $news_data){
	$res = httpPost("https://api.weixin.qq.com/cgi-bin/material/update_news?access_token=$access_token", $news_data);
	return json_decode($res, true);
}

/**
 * 从微信服务器删除图文消息
 * @param string $access_token
 * @param string $media_id
 * @return mixed
 */
function weixin_delete_news($access_token, $media_id){
	$access_data = json_encode(array('media_id'=>$media_id));
	$res = httpPost("https://api.weixin.qq.com/cgi-bin/material/del_material?access_token=$access_token", $access_data);
	return json_decode($res, true);
}
