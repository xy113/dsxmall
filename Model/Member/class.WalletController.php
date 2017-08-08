<?php
namespace Model\Member;
class WalletController extends BaseController{
	public function index(){
		global $_G,$_lang;
		
		$wallet = wallet_get_data($this->uid);
		$_G['title'] = $_lang['account_balance'];
		include template('wallet_index');
	}
}