<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/7/25
 * Time: 下午2:02
 */
namespace Model\Account;
use Core\Validate;
class LoginController extends BaseController{
    /**
     * LoginController constructor.
     */
    function __construct()
    {
        parent::__construct();
        if ($this->isLogin()) $this->redirect(U('m=member'));
    }

    /**
     *
     */
    public function index(){
        global $_G, $_lang;

        include template('login');
    }

    /**
     * 验证登录
     */
    public function chklogin(){
        $account  = htmlspecialchars(trim($_GET['account_'.FORMHASH]));
        $password = trim($_GET['password_'.FORMHASH]);
        $captchacode = trim($_GET['captchacode']);
        $this->checkCaptchacode($captchacode, G('inajax'));

        if (Validate::isemail($account)){
            $returns = member_login($account, $password, 'email');
        }elseif (Validate::ismobile($account)){
            $returns = member_login($account, $password, 'mobile');
        }else {
            $returns = member_login($account, $password, 'username');
        }

        if ($returns['errno'] == 0 && $returns['userinfo']){
            if (G('inajax')) {
                $this->showAjaxReturn();
            }else {
                $continue = $_GET['continue'] ? $_GET['continue'] : $_SERVER['HTTP_REFERER'];
                if ($continue !== curPageURL()){
                    $this->redirect($continue);
                }else {
                    $this->redirect(U(array('m'=>'member')));
                }
            }
        }else {
            if (G('inajax')) {
                $this->showAjaxError($returns['errno'], L($returns['error']));
            }else {
                $this->showError($returns['error']);
            }
        }
    }
}