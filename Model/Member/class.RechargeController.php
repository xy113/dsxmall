<?php
namespace Model\Member;
class RechargeController extends BaseController{
	public function index(){
		global $_G,$_lang;
		
		$_G['title'] = $_lang['account_recharge'];
		include template('recharge_index');
	}
}