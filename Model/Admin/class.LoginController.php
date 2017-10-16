<?php
namespace Model\Admin;
use Data\Member\MemberModel;

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

			$memberModel = new MemberModel();
			if ($this->uid && $this->username){
				$member = $memberModel->where(array('uid'=>$this->uid))->getOne();
			}else {
			    $member = $memberModel->where("`username`='$account' OR `mobile`='$account' OR `email`='$account'")->getOne();
			}
            if ($member['admincp'] == 1 && $member['password'] === getPassword($password)){
                cookie('_cplogin', 1 ,7200);
                cookie('uid', $member['uid']);
                cookie('username', $member['username']);
                $this->showAjaxReturn();
            }else {
                $this->showAjaxError(101, L('password_incorrect'));
            }
		}else {
			$this->showlogin();
		}
	}
}