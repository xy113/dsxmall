<?php
namespace Model\Admin;
class LogoutController extends BaseController{
    /**
     * 退出登录
     */
    public function index(){
		cookie('_cplogin',null);
        cookie('uid', null);
        cookie('username', null);
		$this->redirect($_SERVER['HTTP_REFERER']);
	}
}