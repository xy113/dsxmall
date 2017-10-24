<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/20
 * Time: 上午10:07
 */

namespace Model\Account;


use Alisms\AlismsApi;
use Core\Validate;
use Data\Common\Object\VerifyObject;
use Data\Common\VerifyModel;
use Data\Member\MemberModel;

class FindpassController extends BaseController
{
    /**
     *
     */
    public function index(){
        $this->step1();
    }

    /**
     *
     */
    public function step1(){
        global $_G,$_lang;

        $this->var['title'] = '填写登录名';
        include view('findpass_step1');
    }

    /**
     *
     */
    public function step2(){
        global $_G,$_lang;

        $account = htmlspecialchars($_GET['account']);
        $captchacode = htmlspecialchars($_GET['captchacode']);

        if (!$account || !$captchacode) {
            $this->showError('undefined_action');
        }

        $this->checkCaptchacode($captchacode, false);

        $member = MemberModel::getInstance()->where("`username`='$account' OR `mobile`='$account' OR `email`='$account'")
            ->field('uid,username,mobile,email')->getOne();
        if ($member) {
            $username = $this->substr_cut($member['username']);
            $mobile = '*******'.substr($member['mobile'], -4);
            cookie('find_pass_uid', $member['uid'], 300);
            cookie('find_pass_mobile', $member['mobile'], 300);

            $this->var['title'] = '填写认证信息';
            include view('findpass_step2');
        }else {
            $this->showError('account_invalid');
        }
    }

    /**
     *
     */
    public function set_pass(){
        global $_G,$_lang;

        if ($this->checkFormSubmit()) {
            $token = htmlspecialchars($_GET['_token_']);
            if ($token === cookie('_token_')){
                cookie('_token_', null);
                $newpassword = htmlspecialchars($_GET['newpassword']);
                if (strlen($newpassword) >5 && strlen($newpassword)<21){
                    $uid = cookie('find_pass_uid');
                    MemberModel::getInstance()->where(array('uid'=>$uid))->data(array('password'=>getPassword($newpassword)))->save();
                    cookie('find_pass_uid', null);
                    cookie('find_pass_mobile', null);
                    $this->showSuccess('你的密码已修改成功，请前往登录页面进行登录', null,
                        array(
                            array('text'=>'go_back', 'url'=>U('m=account&c=login'))
                        ));
                }else{
                    $this->showError('password_input_incorrect',null, array(
                        array('text'=>'go_back', 'url'=>U('m=account&c=findpass&a=index'))
                    ));
                }
            }else {
                $this->showError('undefined_action');
            }
        }else {
            $seccode = htmlspecialchars($_GET['seccode']);
            if (!$seccode) {
                $this->showError('captchacode_incorrect');
            }else {
                $mobile = cookie('find_pass_mobile');
                $verify = VerifyModel::getInstance()->where(array('phone'=>$mobile, 'seccode'=>$seccode))
                    ->order('id', 'DESC')->getOne();
                if ($verify['dateline'] < (time()-300) || $verify['used'] == 1){
                    $this->showError('验证码已过期，请重新操作', null, array(
                        array('text'=>'go_back', 'url'=>U('m=account&c=findpass&a=index'))
                    ));
                }else {
                    VerifyModel::getInstance()->where(array('phone'=>$mobile, 'seccode'=>$seccode))
                        ->data(array('used'=>1))->save();
                }
            }

            cookie('_token_', md5_16(time()));

            $this->var['title'] = '重设密码';
            include view('set_pass');
        }
    }

    public function get_code(){
        $mobile = cookie('find_pass_mobile');
        $seccode = random(6, 1);
        if (Validate::ismobile($mobile)) {
            $verifyObj = new VerifyObject();
            $verifyObj->setSecode($seccode)->setPhone($mobile)->setDateline(time())->setUsed(0);
            VerifyModel::getInstance()->data($verifyObj->getBizContent())->add();

            $api = new AlismsApi();
            $res = $api->sendSms(setting('sms_signname'), setting('sms_tpl_verify'), $mobile, array('code'=>$seccode));
            if ($res->Message == 'OK' && $res->Code == 'OK'){
                $this->showAjaxReturn($res);
            }else {
                $this->showAjaxError(2, $res->Message);
            }

        }else {
            cookie('find_pass_mobile', null);
            $this->showError(1, '手机号不合法');
        }
    }

    /**
     * 只保留字符串首尾字符，隐藏中间用*代替（两个字符时只显示第一个）
     * @param string $user_name 姓名
     * @return string 格式化后的姓名
     */
    function substr_cut($user_name){
        //$strlen   = mb_strlen($user_name, 'utf-8');
        $firstStr = mb_substr($user_name, 0, 1, 'utf-8');
        $lastStr  = mb_substr($user_name, -1, 1, 'utf-8');
        //return $strlen == 2 ? $firstStr . str_repeat('*', mb_strlen($user_name, 'utf-8') - 1) : $firstStr . str_repeat("*", $strlen - 2) . $lastStr;
        return $firstStr.'***'.$lastStr;
    }
}