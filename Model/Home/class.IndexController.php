<?php
namespace Model\Home;

use Data\Item\ItemCatlogModel;
use Data\Item\ItemModel;
use Data\Shop\ShopModel;

class IndexController extends BaseController{
    /**
     *
     */
    public function index(){
		global $_G,$_lang;

        //商品分类列表
        $item_catlog_list = array();
        foreach ((new ItemCatlogModel())->getCache() as $catlog){
            $item_catlog_list[$catlog['fid']][$catlog['catid']] = $catlog;
        }
        unset($catlog);

        $itemModel = new ItemModel();
        $item_list['baopin']  = $itemModel->where(array('on_sale'=>1, 'catid=47'))->limit(0, 5)->selectNew();
        $item_list['youxuan'] = $itemModel->where(array('on_sale'=>1, 'catid=48'))->limit(0, 5)->selectNew();
        $item_list['jingpin'] = $itemModel->where(array('on_sale'=>1, 'catid=50'))->limit(0, 5)->selectNew();
        $item_list['haoping'] = $itemModel->where(array('on_sale'=>1, 'catid=66'))->limit(0, 5)->selectNew();
        $item_list['xihuan']  = $itemModel->where(array('on_sale'=>1, 'catid=71'))->limit(0, 5)->selectNew();
        $item_list['new'] = $itemModel->where(array('on_sale'=>1, 'catid=47'))->limit(0, 6)->selectNew();
        $item_list['hot'] = $itemModel->where(array('on_sale'=>1))->limit(0, 5)->selectHot();
        //企业店铺
        $shop_list = (new ShopModel())->where(array('closed'=>0))->limit(0, 10)->select();
        $_G['nav'] = 'home';
		include template('index');
	}

    /**
     *
     */
    public function app(){
        echo md5_16(random(10));
        echo '<br>';
        echo md5(random(10));
        print_array($_SERVER);
    }
}