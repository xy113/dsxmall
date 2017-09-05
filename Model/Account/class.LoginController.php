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

        $redirect = htmlspecialchars($_GET['redirect']);
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

        if ($_GET['formhash'] !== formhash()){
            $this->showAjaxError('FAIL', L('undefined_action'));
        }

        if (Validate::isemail($account)){
            $returns = member_login($account, $password, 'email');
        }elseif (Validate::ismobile($account)){
            $returns = member_login($account, $password, 'mobile');
        }else {
            $returns = member_login($account, $password, 'username');
        }

        if ($returns['errcode'] == 0 && $returns['userinfo']){
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
                $this->showAjaxError($returns['errcode'], $returns['errmsg']);
            }else {
                $this->showError($returns['errmsg']);
            }
        }
    }

    /**
     * AJAX login
     */
    public function ajaxlogin(){
        global $_G,$_lang;

        include template('ajaxlogin');
    }

    /**
     *
     */
    public function qrcode(){
        $login_code = cookie('login_code');
        if (!$login_code) {
            $login_code = md5(time().random(10));
            M('scan_login')->insert(array(
                'uid'=>0,
                'login_code'=>$login_code,
                'scaned'=>0,
                'create_time'=>time()
            ));
            cookie('login_code', $login_code);
        }
        $url = "cgapp://scanLogin?login_code=".$login_code;
        include LIB_PATH.'Vendor/phpqrcode.php';
        \QRcode::png($url, false, QR_ECLEVEL_H, 10);
    }

    /**
     *
     */
    public function scan_query(){
        $login_code = cookie('login_code');
        $check = M('scan_login')->where(array('login_code'=>$login_code, 'scaned'=>1))->getOne();
        if ($check) {
            $this->showAjaxReturn();
        }else {
            $this->showAjaxError(1, 'not scaned');
        }
    }

    /**
     *
     */
    public function confirm_login(){
        $login_code = cookie('login_code');
        $check = M('scan_login')->where(array('login_code'=>$login_code, 'scaned'=>1))->getOne();
        if ($check) {
            cookie('login_code', null);
            member_add_log($check['uid'], 'login');
            member_update_status(array('uid'=>$check['uid']), array(
                'lastvisit'=>TIMESTAMP,
                'lastvisitip'=>getIp()
            ));
            member_update_cookie($check['uid']);
            M('scan_login')->where(array('login_code'=>$login_code))->delete();
            $this->showAjaxReturn();
        }else {
            $this->showAjaxError(1, 'not scaned');
        }
    }
}