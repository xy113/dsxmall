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

        $goods_list['baopin']  = goods_get_item_list(array('on_sale'=>1, 'catid_1=47 OR catid_2=47 OR catid_3=47'), 5);
        $goods_list['youxuan'] = goods_get_item_list(array('on_sale'=>1, 'catid_1=48 OR catid_2=48 OR catid_3=48'), 5);
        $goods_list['jingpin'] = goods_get_item_list(array('on_sale'=>1, 'catid_1=50 OR catid_2=50 OR catid_3=50'), 5);
        $goods_list['haoping'] = goods_get_item_list(array('on_sale'=>1, 'catid_1=66 OR catid_2=66 OR catid_3=66'), 5);
        $goods_list['xihuan']  = goods_get_item_list(array('on_sale'=>1, 'catid_1=71 OR catid_2=71 OR catid_3=71'), 5);
        $goods_list['new'] = goods_get_item_list(array('on_sale'=>1), 6, 0);
        $goods_list['hot'] = goods_get_item_list(array('on_sale'=>1), 5, 0, 'sold DESC');
        //企业店铺
        $shop_list = shop_get_list(array('shop_status'=>'OPEN'), 10);

        $_G['nav'] = 'home';
		include template('index');
	}

	public function app(){
        echo md5_16(random(10));
        echo '<br>';
        echo md5(random(10));
    }
}