<?php
namespace Model\Admin;
use Core\Controller;
class BaseController extends Controller{
    /**
     * BaseController constructor.
     */
    function __construct(){
		parent::__construct();
		define('IN_ADMIN', true);
        //print_array($GLOBALS['_G']);exit();
		if (!cookie('_cplogin') || !$this->uid || !$this->username){
			if (G('c') != 'login'){
				$this->showlogin();
			}
		}
	}
	
	/**
	 * 显示管理员登录
	 */
	protected function showlogin(){
		global $_G, $_lang;
		include template('admin_login');
		exit();
	}
}