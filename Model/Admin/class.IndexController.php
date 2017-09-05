<?php
namespace Model\Admin;
class IndexController extends BaseController{
    /**
     *
     */
    public function index(){
		global $_G, $_lang;

        $_G['title'] = $_lang['home'];
		include template('admin');
	}

	public function wellcome(){
        global $G,$_lang;

        include template('wellcome');
    }
}