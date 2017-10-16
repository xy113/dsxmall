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
		}else {
            cookie('_cplogin', 1, 1800);
        }
	}
	
	/**
	 * 显示管理员登录
	 */
	protected function showlogin($redirect=null){
		global $_G, $_lang;
		include template('admin_login');
		exit();
	}
}