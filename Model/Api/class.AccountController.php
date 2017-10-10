<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/25
 * Time: 上午12:29
 */

namespace Model\Api;


use Core\Validate;
use Data\Member\MemberGroupModel;
use Data\Member\MemberInfoModel;
use Data\Member\MemberModel;
use Data\Member\MemberStatusModel;

class AccountController extends BaseController
{
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
                    /*
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
                    */
                    member_update_cookie($member['uid']);
                    $info = member_get_info(array('uid'=>$member['uid']));
                    $this->showAjaxReturn(array(
                        'uid'=>$member['uid'],
                        'username'=>$member['username'],
                        'province'=>$info['province'],
                        'city'=>$info['city'],
                        'county'=>$info['county'],
                        'headimg'=>avatar($member['uid'])
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

            $memberModel = new MemberModel();
            if ($memberModel->where(array('username'=>$username))->count()){
                $this->showAjaxError(1, 'username_be_occupied');
            }

            if (!Validate::ismobile($mobile)){
                $this->showAjaxError(2, 'mobile_incorrect');
            }

            if ($memberModel->where(array('mobile'=>$mobile))->count()){
                $this->showAjaxError(3, 'mobile_be_occupied');
            }

            if (strlen($password)<6 || strlen($password)>20){
                $this->showAjaxError(4, 'password_input_incorrect');
            }

            $group = (new MemberGroupModel())->where(array('type'=>'member'))->order('creditslower', 'ASC')->getOne();
            $uid = $memberModel->data(array('gid'=>$group['gid'],'username'=>$username, 'password'=>getPassword($password), 'mobile'=>$mobile))->add();
            (new MemberStatusModel())->data(array('uid'=>$uid,'regdate'=>time(),'regip'=>getIp()))->add();
            (new MemberInfoModel())->data(array('uid'=>$uid))->add();

            cookie('uid', $uid);
            cookie('username', $username);

            $this->showAjaxReturn();
        }else {
            $this->showAjaxError('5', 'sign_error');
        }
    }
}