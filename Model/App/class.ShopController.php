<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/25
 * Time: 上午11:42
 */

namespace Model\App;


use Data\Common\BlockModel;
use Data\Item\ItemModel;
use Data\Shop\ShopModel;

class ShopController extends BaseController
{
    /**
     *
     */
    public function index(){
        global $_G,$_lang;

        $blockModel = new BlockModel();
        $slide_list = $blockModel->getCache(6);
        $brand_list = $blockModel->getCache(7);
        include template('shop_index');
    }

    /**
     * 获取店铺信息
     */
    public function batchget(){
        $shopModel = new ShopModel();
        $fields = 'shop_id, shop_name, shop_logo, total_sold, city, county';
        $condition = array('closed'=>'0');
        $shoplist = $shopModel->where($condition)->field($fields)->page(G('page'), 20)->select();
        $datalist = array();
        foreach ($shoplist as $shop){
            $shop['shop_logo'] = image($shop['shop_logo']);
            if (!$shop['city']) $shop['city'] = '贵州';
            if (!$shop['county']) $shop['county'] = '六盘水';
            $datalist[$shop['shop_id']] = $shop;
        }
        $shop_ids = implodeids(array_keys($datalist));
        $itemlist = (new ItemModel())->field('shop_id, MIN(price) AS min_price')
            ->where("`on_sale`=1 AND (shop_id IN($shop_ids))")->group('shop_id')->select();
        foreach ($itemlist as $item){
            $datalist[$item['shop_id']]['min_price'] = formatAmount($item['min_price']);
        }
        unset($shop_list, $shop, $itemlist, $item, $shop_ids);
        $this->showAjaxReturn(array_values($datalist));
    }

    /**
     * 店铺详情
     */
    public function viewshop(){
        global $_G,$_lang;

        $shop = array();
        $shop_id = intval($_GET['shop_id']);
        $shopModel = new ShopModel();
        if ($shop_id) {
            $shop = $shopModel->where(array('shop_id'=>$shop_id))->getOne();
        }elseif ($_GET['uid']) {
            $shop = $shopModel->where(array('uid'=>intval($_GET['uid'])))->getOne();
            $shop_id = $shop['shop_id'];
        }

        if (!$shop) {

        }else {
            $shopModel->where(array('shop_id'=>$shop_id))->data('`view_num`=`view_num`+1')->save();

            $itemModel = new ItemModel();
            $condition = array('shop_id'=>$shop_id, 'on_sale'=>1);
            $itemlist = $itemModel->where($condition)->select();
            $shop_item_count = $itemModel->where(array('shop_id'=>$shop['shop_id'], 'on_sale'=>1))->count();

            $_G['title'] = $shop['shop_name'];
            include template('viewshop');
        }
    }

    public function dingxiang(){
        global $_G,$_lang;

        $offset = (G('page') - 1) * 20;
        $fields = 'shop_id, shop_name, shop_logo, total_sold, city, county';
        $condition = array('shop_status'=>'OPEN', 'auth_status'=>'SUCCESS');
        $shop_list = shop_get_list($condition, 20, $offset, null, $fields);
        $datalist = array();
        foreach ($shop_list as $shop){
            $shop['shop_logo'] = image($shop['shop_logo']);
            if (!$shop['city']) $shop['city'] = '贵州';
            if (!$shop['county']) $shop['county'] = '六盘水';
            $datalist[$shop['shop_id']] = $shop;
        }
        $shop_ids = implodeids(array_keys($datalist));
        $goods_list = M('goods_item')->field('shop_id, MIN(goods_price) AS price')
            ->where("`on_sale`=1 AND (shop_id IN($shop_ids))")->group('shop_id')->select();
        foreach ($goods_list as $goods){
            $datalist[$goods['shop_id']]['goods_price'] = formatAmount($goods['price']);
        }
        $shop_list = $datalist;
        unset($shop, $goods_list, $goods, $shop_ids, $datalist);
        $_G['title'] = '定向采购';
        include template('shop_dingxiang');
    }
}