<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/28
 * Time: 上午10:18
 */

namespace Model\Api;

use Alisms\AlismsApi;
use Core\Validate;
use Data\Common\VerifyModel;
use Data\Member\MemberModel;

class FindpassController extends BaseController
{
    public function index(){

    }

    /**
     *
     */
    public function check_mobile(){
        $model = new MemberModel();
        $mobile = htmlspecialchars($_GET['mobile']);
        $memberdata = $model->where(array('mobile'=>$mobile))->getOne();
        if ($memberdata) {
            $this->showAjaxReturn(array(
                'uid'=>$memberdata['uid'],
                'username'=>$memberdata['username'],
                'mobile'=>$memberdata['mobile'],
                'email'=>$memberdata['email']
            ));
        }else {
            $this->showAjaxError(1, '手机号不存在');
        }
    }

    /**
     *
     */
    public function get_sms(){
        $mobile = htmlspecialchars($_GET['mobile']);
        if (Validate::ismobile($mobile)){
            $seccode = random(6, 1);
            $verifyModel = new VerifyModel();
            $verifyModel->data(array(
                'seccode'=>$seccode,
                'phone'=>$mobile,
                'dateline'=>time(),
                'used'=>0
            ))->add();
            $api = new AlismsApi();
            $api->sendSms(setting('sms_signname'), setting('sms_tpl_verify'), $mobile, array('code'=>$seccode));
            $this->showAjaxReturn();
        }else {
            $this->showAjaxError(1, '手机号输入错误');
        }
    }

    /**
     *
     */
    public function set_password(){
        $uid = intval($_GET['uid']);
        $mobile = htmlspecialchars($_GET['mobile']);
        $seccode = htmlspecialchars($_GET['seccode']);
        $newpassword = $_GET['newpassword'];
        if ($uid && $mobile && $seccode && $newpassword){
            if (strlen($newpassword) < 6 || strlen($newpassword) > 20){
                $this->showAjaxError(2, '密码输入错误');
            }else {
                $newpassword = getPassword($newpassword);
            }
            $verifyModel = new VerifyModel();
            $check = $verifyModel->where(array('seccode'=>$seccode, 'phone'=>$mobile))->order('id', 'DESC')->getOne();
            if ((time() - 300) < $check['dateline'] && $check['used'] == 0){
                $verifyModel->where(array('seccode'=>$seccode))->data(array('used'=>1))->save();
                $memberModel = new MemberModel();
                $memberModel->where(array('uid'=>$uid, 'mobile'=>$mobile))->data(array('password'=>$newpassword))->save();
                $this->showAjaxReturn();
            }else {
                $this->showAjaxError(3, '验证码已失效');
            }
        }else {
            $this->showAjaxError(1, '参数错误');
        }
    }
}