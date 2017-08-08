<?php
return array(
		/* Cookie设置 */
		'COOKIE_EXPIRE'    =>  0,       // Cookie有效期
		'COOKIE_DOMAIN'    =>  '',      // Cookie有效域名
		'COOKIE_PATH'      =>  '/',     // Cookie路径
		'COOKIE_PREFIX'    =>  'dsxcms_',      // Cookie前缀 避免冲突
		'COOKIE_SECURE'    =>  false,   // Cookie安全传输
		'COOKIE_HTTPONLY'  =>  '1',      // Cookie httponly设置
		
		//自动加载文件配置
		'AUTO_LOAD_CONFIG'=>array(),
		'AUTO_LOAD_LANGS'=>array('post'),
		'AUTO_LOAD_FUNCTIONS'=>array('wallet', 'game'),
		
		/*应用配置*/
		'FOUNDERS'=>array('1000000'), //创始人UID
		'AUTHKEY'=>'000000000000',//信息加密秘钥
		'STATICURL'=>'/static/',  //静态资源修正地址
		'ATTACHDIR'=>ROOT_PATH.'data/attachment/', //附件保存目录
		'ATTACHURL'=>'/data/attachment/',  //附件修正地址
		'AVATARDIR'=>ROOT_PATH.'data/avatar/' //头像保存目录
);