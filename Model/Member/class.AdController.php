<?php
namespace Model\Member;
class AdController extends BaseController{
	public function index(){
		$this->itemlist();
	}

    /**
     *
     */
    public function itemlist(){
		global $_G,$_lang;
		
		if ($this->checkFormSubmit()){
			
		}else {
			
			$tab = trim($_GET['tab']);
			$tab = in_array($tab, array('normal', 'pending', 'unaudit')) ? $tab : 'all';
			
			$_G['title'] = $_lang['my_ad'];
			include template('ad_list');
		}
	}
}