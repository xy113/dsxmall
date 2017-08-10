<?php
namespace Model\Home;

class IndexController extends BaseController{
    /**
     *
     */
    public function index(){
		global $_G,$_lang;

        //商品分类列表
        $goods_cat_list = array();
        foreach (goods_get_cat_list() as $cat){
            $goods_cat_list[$cat['fid']][$cat['catid']] = $cat;
        }
        unset($cat);

        $goods_list['new'] = goods_get_item_list(array('on_sale'=>1), 5);
        $goods_list['hot'] = goods_get_item_list(array('on_sale'=>1), 6, 0, 'sold DESC');
        //企业店铺
        $shop_list = shop_get_list(array('shop_status'=>'OPEN'), 10);

        $_G['nav'] = 'home';
		include template('index');
	}
}