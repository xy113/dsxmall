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
            member_logout();
            $contiue = trim($_GET['continue']);
            $contiue = $contiue ? $contiue : $_SERVER['HTTP_REFERER'];
            if ($contiue !== curPageURL()){
                $this->redirect($contiue);
            }else {
                $this->redirect(U('m=account&c=login'));
            }
        }else {
            $this->redirect(U('m=account&c=login'));
        }
    }
}