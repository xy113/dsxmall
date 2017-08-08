<?php
namespace Weixin;
use Core\Controller;

class BaseController extends Controller{
	protected $appid = '';
	protected $appsecret = '';
	protected $mch_id = '';
	protected $mch_key = '';
	protected $openid = '';
	function __construct(){
		parent::__construct();
		$this->appid = setting('wx_appid');
		$this->appsecret = setting('wx_appsecret');
		$this->mch_id = setting('wx_mch_id');
		$this->mch_key = setting('wx_mch_key');
		$this->autoLogin();
	}
	
	/**
	 * 微信自动登录
	 */
	protected function autoLogin(){
		if (!$this->uid || !$this->username){
			if ($_GET['code']) {
				$userinfo = $this->getUserInfo($_GET['code']);
				$connect = member_get_connect(array('openid'=>$userinfo['openid'], 'platform'=>'weixin'));
				if ($connect) {
					member_update_cookie($connect['uid']);
				}else {
					$uid = weixin_register($userinfo);
					member_add_connect(array(
							'uid'=>$uid,
							'platform'=>'weixin',
							'openid'=>$userinfo['openid'],
							'sex'=>$userinfo['sex'],
							'nickname'=>$userinfo['nickname'],
							'country'=>$userinfo['country'],
							'province'=>$userinfo['province'],
							'city'=>$userinfo['city'],
							'headimgurl'=>$userinfo['headimgurl'],
							'dateline'=>TIMESTAMP
					));
					member_update_cookie($uid);
				}
				$this->redirect(curPageURL());
			}else {
				$this->getCode(curPageURL());
			}
		}
	}
	
	/**
	 * 获取CODE
	 * @param string $weixin_uri
	 */
	private function getCode($redirect_uri){
		$weixin_uri = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$this->appid;
		$weixin_uri.= '&redirect_uri='.urlencode($redirect_uri).'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
		$this->redirect($weixin_uri);
	}
	
	/**
	 * 获取用户信息
	 * @param string $code
	 * @return mixed|boolean
	 */
	private function getUserInfo($code){
		$url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->appid;
		$url.= '&secret='.$this->appsecret.'&code='.$code.'&grant_type=authorization_code';
		$data = json_decode(httpGet($url), true);
		if ($data['openid'] && $data['access_token']) {
			$json = httpGet("https://api.weixin.qq.com/sns/userinfo?access_token=$data[access_token]&openid=$data[openid]&lang=zh_CN");
			return json_decode($json, true);
			//$token = weixin_get_access_token($this->appid, $this->appsecret);
			//return weixin_get_userinfo($token, $data['openid']);
			
		}else {
			return false;
		}
	}
}