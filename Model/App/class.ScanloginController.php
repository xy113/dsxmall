<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/3
 * Time: 下午2:07
 */

namespace Model\App;


use Data\Member\ScanLoginModel;

class ScanloginController extends BaseController
{
    /**
     *
     */
    public function index(){
        global $_G,$_lang;

        $login_code = htmlspecialchars($_GET['login_code']);
        include template('scanlogin');
    }

    /**
     * 确认登录
     */
    public function confirm_login(){
        $uid = intval($_GET['uid']);
        $login_code = trim($_GET['login_code']);
        (new ScanLoginModel())->where(array('login_code'=>$login_code))->data(array('uid'=>$uid, 'scaned'=>1))->save();
        $this->showAjaxReturn();
    }
}