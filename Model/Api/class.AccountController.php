<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/25
 * Time: 上午12:29
 */

namespace Model\Api;


class AccountController extends BaseController
{
    /**
     * AccountController constructor.
     */
    function __construct()
    {
        $this->verifyToken = false;
        parent::__construct();
    }

    /**
     *
     */
    public function login(){
        $appid = trim($_GET['appid']);
        $appconf = C('app_'.$appid);
        $appkey  = $appconf['appkey'];
        $account = htmlspecialchars($_GET['account']);
        $password = trim($_GET['password']);
        $timestamp = trim($_GET['timestamp']);

        $check_sign = md5($account.$password.$timestamp.$appid.$appkey);
        if ($appkey && $check_sign == $_GET['sign']){
            $member = member_get_data("`username`='$account' OR `mobile`='$account' OR `email`='$account'");
            if ($member) {
                if ($member['password'] == getPassword($password)){
                    $token = sha1(time().random(10));
                    $token_data = array(
                        'uid'=>$member['uid'],
                        'username'=>$member['username'],
                        'token'=>$token,
                        'expire_time'=>time()
                    );
                    cache('token_'.md5($member['uid']), $token_data);
                    if (!member_update_token($member['uid'], $token, time())){
                        member_add_token($token_data);
                    }
                    $info = member_get_info(array('uid'=>$member['uid']));
                    $this->showAjaxReturn(array(
                        'uid'=>$member['uid'],
                        'username'=>$member['username'],
                        'province'=>$info['province'],
                        'city'=>$info['city'],
                        'county'=>$info['county'],
                        'headimg'=>avatar($member['uid']),
                        'token'=>$token
                    ));
                }else {
                    $this->showAjaxError('1003', 'password_incorrect');
                }
            }else {
                $this->showAjaxError('1002', 'account_invalid');
            }
        }else {
            $this->showAjaxError('1001', 'sign_error');
        }
    }

    /**
     * 新用户注册接口
     */
    public function register(){
        $appid = trim($_GET['appid']);
        $appconf = C('app_'.$appid);
        $appkey  = $appconf['appkey'];
        $username  = htmlspecialchars($_GET['username']);
        $mobile    = htmlspecialchars($_GET['mobile']);
        $password  = trim($_GET['password']);
        $timestamp = trim($_GET['timestamp']);

        $check_sign = md5($username.$mobile.$password.$timestamp.$appid.$appkey);
        if ($check_sign == $_GET['sign']) {
            $res = member_register(array(
                'username'=>$username,
                'password'=>$password,
                'mobile'=>$mobile
            ));
            if ($res['errcode'] == 0){
                $this->showAjaxReturn(array(
                    'uid'=>$res['userinfo']['uid'],
                    'username'=>$res['userinfo']['username']
                ));
            }else {
                $this->showAjaxError($res['errcode'], $res['errmsg']);
            }
        }else {
            $this->showAjaxError('1001', 'sign_error');
        }
    }
}