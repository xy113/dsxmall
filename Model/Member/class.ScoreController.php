<?php
namespace Model\Member;
class ScoreController extends BaseController{
	public function index(){
		global $_G,$_lang;
		
		$wallet = wallet_get_data($this->uid);
		$itemlist = score_get_list(array('uid'=>$this->uid));
		$_G['title'] = $_lang['my_score'];
		include template('score_index');
	}
	
	public function itemlist(){
		
	}
}