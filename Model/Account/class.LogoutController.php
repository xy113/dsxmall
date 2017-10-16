<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/7/25
 * Time: 下午2:26
 */
namespace Model\Account;
class LogoutController extends BaseController{
    /**
     *
     */
    public function index(){
        if ($this->uid && $this->username){
            cookie('uid', null);
            cookie('username', null);
            $redirect = trim($_GET['redirect']);
            $redirect = $redirect ? $redirect : $_SERVER['HTTP_REFERER'];
            if ($redirect !== curPageURL()){
                $this->redirect($redirect);
            }else {
                $this->redirect(U('m=account&c=login'));
            }
        }else {
            $this->redirect(U('m=account&c=login'));
        }
    }
}