<?php
namespace Model\Admin;
class LoginController extends BaseController{
	function __construct(){
		parent::__construct();
		if (cookie('_cplogin') && $this->uid && $this->username){
			$this->redirect(U('m=admin'));
		}
	}

    /**
     * 管理员登录
     */
    public function index(){
		if ($this->checkFormSubmit()){
			$account  = trim($_GET['account_'.FORMHASH]);
			$password = trim($_GET['password_'.FORMHASH]);
			if ($this->uid && $this->username){
				$userdata = member_get_data(array('uid'=>$this->uid));
			}else {
			    $userdata = member_get_data("`username`='$account' OR `mobile`='$account' OR `email`='$account'");
			}
            if ($userdata['admincp'] == 1 && $userdata['password'] == getPassword($password)){
                cookie('_cplogin', 1 ,7200);
                member_update_cookie($userdata['uid']);
                $this->showAjaxReturn();
            }else {
                $this->showAjaxError(101, L('password_incorrect'));
            }
		}else {
			$this->showlogin();
		}
	}
}