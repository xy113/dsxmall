<?php
namespace Model\Home;

class IndexController extends BaseController{
    /**
     *
     */
    public function index(){
		global $_G,$_lang;

        $goods_list['new'] = goods_get_item_list(array('on_sale'=>1), 5);
		include template('index');
	}
}