<?php
namespace Model\Weixin;
use Core\Controller;
use Core\Http;
use Data\Member\MemberConnectModel;
use Data\Member\MemberInfoModel;
use Data\Member\MemberModel;
use Data\Member\MemberStatusModel;
use WxApi\WxApi;
use WxApi\WxUserApi;

class BaseController extends Controller{
	protected $openid = '';

    /**
     * BaseController constructor.
     */
    function __construct(){
		parent::__construct();

		$this->openid = cookie('openid');
		if (!$this->uid || !$this->username || !$this->openid){
            $this->autoLogin();
        }
	}


    /**
     * 生成JSSDK签名
     * @return array
     */
    protected function createJssdkSign(){
        $ticket = (new WxApi())->getJsApiTicket();
        $timestamp = TIMESTAMP;
        $nonceStr  = random(10);
        $url = curPageURL();
        //$timestamp = "$timestamp";
        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$ticket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
        $signature = sha1($string);

        $signPackage = array(
            "appid"     => setting('wx_appid'),
            "noncestr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage;
    }
	
	/**
	 * 微信自动登录
	 */
	protected function autoLogin(){
		if (!$this->uid || !$this->username){
			if ($_GET['code']) {
				$openid = $this->getOpenid($_GET['code']);
				$connect = new MemberConnectModel();
				$userinfo = $connect->where(array('openid'=>$openid))->getOne();
				if ($userinfo) {
				    cookie('uid', $userinfo['uid']);
				    cookie('username', $userinfo['nickname']);
				    cookie('openid', $openid);
                }else {
				    $api = new WxUserApi();
				    $userinfo = $api->getInfo($openid);

				    $member = new MemberModel();
				    $uid = $member->data(array('username'=>$userinfo['nickname']))->add(null, true);
                    (new MemberInfoModel())->data(array(
                        'uid'=>$uid,
                        'usersex'=>$userinfo['sex'],
                        'nickname'=>$userinfo['nickname'],
                        'country'=>$userinfo['country'],
                        'province'=>$userinfo['province'],
                        'city'=>$userinfo['city']
                    ))->add();
                    (new MemberStatusModel())->data(array(
                        'uid'=>$uid,
                        'regdate'=>time(),
                        'regip'=>getIp(),
                        'lastvisit'=>time(),
                        'lastvisitip'=>getIp()
                    ))->add();
				    $connect->data(array(
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
                    ))->add();
                }
                $this->redirect(curPageURL());
			}else {
				$this->getCode(curPageURL());
			}
		}
	}

    /**
     * 获取CODE
     * @param $redirect_uri
     */
	private function getCode($redirect_uri){
		$url = $this->__CreateOauthUrlForCode($redirect_uri);
		$this->redirect($url);
	}
	
	/**
	 * 获取用户信息
	 * @param string $code
	 * @return mixed|boolean
	 */
	private function getOpenid($code){
		$url = $this->__CreateOauthUrlForOpenid($code);
		$res = Http::curlGet($url);
		$data = json_decode($res, true);
		if ($data['openid']) {
			return $data['openid'];
		}else {
			return false;
		}
	}

    /**
     * 拼接签名字符串
     * @param array $urlObj
     * @return string 返回已经拼接好的字符串
     */
    private function toUrlParams($urlObj)
    {
        $buff = "";
        foreach ($urlObj as $k => $v)
        {
            if($k != "sign"){
                $buff .= $k . "=" . $v . "&";
            }
        }

        $buff = trim($buff, "&");
        return $buff;
    }

    /**
     * 构造获取code的url连接
     * @param string $redirectUrl 微信服务器回跳的url，需要url编码
     * @return string 返回构造好的url
     */
    private function __CreateOauthUrlForCode($redirectUrl)
    {
        $urlObj["appid"] = setting('wx_appid');
        $urlObj["redirect_uri"] = "$redirectUrl";
        $urlObj["response_type"] = "code";
        $urlObj["scope"] = "snsapi_base";
        $urlObj["state"] = "STATE"."#wechat_redirect";
        $bizString = $this->toUrlParams($urlObj);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
    }

    /**
     * 构造获取open和access_toke的url地址
     * @param $code
     * @return string 请求的url
     */
    private function __CreateOauthUrlForOpenid($code)
    {
        $urlObj["appid"] = setting('wx_appid');
        $urlObj["secret"] = setting('wx_appsecret');
        $urlObj["code"] = $code;
        $urlObj["grant_type"] = "authorization_code";
        $bizString = $this->toUrlParams($urlObj);
        return "https://api.weixin.qq.com/sns/oauth2/access_token?".$bizString;
    }
}