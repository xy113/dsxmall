<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/7/25
 * Time: 下午2:27
 */
namespace Model\Account;
class RegisterController extends BaseController{
    /**
     * RegisterController constructor.
     */
    function __construct(){
        parent::__construct();
        if ($this->uid) $this->redirect(U('/'));
    }

    public function index(){
        if ($this->checkFormSubmit()){
            $this->save();
        }else {
            member_show_register();
        }
    }

    /**
     * 保存注册信息
     */
    function save(){
        $username = htmlspecialchars(trim($_GET['username_'.FORMHASH]));
        $password = trim($_GET['password_'.FORMHASH]);
        $email    = trim($_GET['email_'.FORMHASH]);
        $mobile   = trim($_GET['mobile_'.FORMHASH]);
        $captchacode = trim($_GET['captchacode']);
        $this->checkCaptchacode($captchacode, true);

        if ($username && $mobile && $password){
            $data = array(
                'username'=>$username,
                'password'=>$password,
                'email'=>$email,
                'mobile'=>$mobile
            );

            $returns = member_register($data, true);
            if ($returns['errcode'] == 0 && $returns['userinfo']) {
                $this->showAjaxReturn($returns['userinfo']);
            }else {
                $this->showAjaxError('FAIL', $returns['errmsg']);
            }
        }else {
            $this->showAjaxError('FAIL', 'invalid_parameter');
        }
    }
}