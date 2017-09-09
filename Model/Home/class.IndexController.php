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

        $item_list['baopin']  = item_get_list(array('on_sale'=>1, 'catid=47'), 5);
        $item_list['youxuan'] = item_get_list(array('on_sale'=>1, 'catid=48'), 5);
        $item_list['jingpin'] = item_get_list(array('on_sale'=>1, 'catid=50'), 5);
        $item_list['haoping'] = item_get_list(array('on_sale'=>1, 'catid=66'), 5);
        $item_list['xihuan']  = item_get_list(array('on_sale'=>1, 'catid=71'), 5);
        $item_list['new'] = item_get_list(array('on_sale'=>1, 'catid'=>47), 6, 0);
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
/*	    $order_list = M('order')->field("shop_id,total_fee, FROM_UNIXTIME(create_time, '%Y%m%d') AS datestamp")->order('create_time')->select();
	    $datalist = array();
	    foreach ($order_list as $order){
	        if (!isset($datalist[$order['shop_id']][$order['datestamp']]['order_num'])){
                $datalist[$order['shop_id']][$order['datestamp']]['order_num'] = 0;
            }
            if (!isset($datalist[$order['shop_id']][$order['datestamp']]['turnovers'])){
                $datalist[$order['shop_id']][$order['datestamp']]['turnovers'] = 0;
            }
            $datalist[$order['shop_id']][$order['datestamp']]['order_num']+= 1;
            $datalist[$order['shop_id']][$order['datestamp']]['turnovers']+= $order['total_fee'];
        }
        print_array($datalist);

        foreach ($datalist as $shop_id=>$record_list){
            foreach ($record_list as $datestamp=>$record){
                shop_add_record(array(
                    'shop_id'=>$shop_id,
                    'order_num'=>$record['order_num'],
                    'datestamp'=>$datestamp,
                    'turnovers'=>$record['turnovers']
                ));
            }
        }
        echo '111111';*/
    }
}