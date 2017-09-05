<?php
namespace Model\Home;

use Alisms\AlismsApi;

class IndexController extends BaseController{
    /**
     *
     */
    public function index(){
		global $_G,$_lang;

        //商品分类列表
        $item_cat_list = array();
        foreach (item_get_cat_list() as $cat){
            $item_cat_list[$cat['fid']][$cat['catid']] = $cat;
        }
        unset($cat);

        $item_list['baopin']  = item_get_list(array('on_sale'=>1, 'catid_1=47 OR catid_2=47 OR catid_3=47'), 5);
        $item_list['youxuan'] = item_get_list(array('on_sale'=>1, 'catid_1=48 OR catid_2=48 OR catid_3=48'), 5);
        $item_list['jingpin'] = item_get_list(array('on_sale'=>1, 'catid_1=50 OR catid_2=50 OR catid_3=50'), 5);
        $item_list['haoping'] = item_get_list(array('on_sale'=>1, 'catid_1=66 OR catid_2=66 OR catid_3=66'), 5);
        $item_list['xihuan']  = item_get_list(array('on_sale'=>1, 'catid_1=71 OR catid_2=71 OR catid_3=71'), 5);
        $item_list['new'] = item_get_list(array('on_sale'=>1), 6, 0);
        $item_list['hot'] = item_get_list(array('on_sale'=>1), 5, 0, 'sold DESC');
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

    public function update(){
	    $order_list = M('order_0905')->where(array('pay_type'=>3))->select();
	    foreach ($order_list as $order){
	        order_update_data(array('order_id'=>$order['order_id']), array(
	            'order_status'=>0,'pay_status'=>0,'pay_type'=>2,'is_commited'=>1
            ));
        }
        echo 'complete';
    }
}