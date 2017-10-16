<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/7/25
 * Time: 下午2:02
 */
namespace Model\Account;
use Core\Validate;
use Data\Member\MemberModel;
use Data\Member\MemberStatusModel;

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

        $model = new MemberModel();
        $member = $model->where("`username`='$account' OR `mobile`='$account' OR `email`='$account'")->getOne();
        if ($member) {
            if ($member['password'] == getPassword($password)){
                cookie('uid', $member['uid']);
                cookie('username', $member['username']);
                (new MemberStatusModel())->where(array('uid'=>$member['uid']))
                    ->data(array('lastvisit'=>time(), 'lastvisitip'=>getIp()))->save();
                $this->showAjaxReturn();
            }else {
                $this->showAjaxError('1003', 'password_incorrect');
            }
        }else {
            $this->showAjaxError(1, 'account_invalid');
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
            $member = (new MemberModel())->where(array('uid'=>$check['uid']))->getOne();
            cookie('login_code', null);
            cookie('uid', $member['uid']);
            cookie('username', $member['username']);
            (new MemberStatusModel())->where(array('uid'=>$check['uid']))->data(array('lastvisit'=>TIMESTAMP, 'lastvisitip'=>getIp()))->save();
            M('scan_login')->where(array('login_code'=>$login_code))->delete();
            $this->showAjaxReturn();
        }else {
            $this->showAjaxError(1, 'not scaned');
        }
    }
}