<?php
namespace Model\App;
class IndexController extends BaseController{
    /**
     * APP首页
     */
    public function index(){
		global $_G,$_lang;


		include template('index');
	}
}