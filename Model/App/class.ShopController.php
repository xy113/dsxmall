<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/25
 * Time: 上午11:42
 */

namespace Model\App;


class ShopController extends BaseController
{
    /**
     *
     */
    public function index(){
        global $_G,$_lang;

        include template('shop_index');
    }

    /**
     * 获取店铺信息
     */
    public function batchget(){
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
        $itemlist = M('item')->field('shop_id, MIN(price) AS min_price')
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
        if ($shop_id) {
            $shop = shop_get_data(array('shop_id'=>$shop_id));
        }elseif ($_GET['uid']) {
            $shop = shop_get_data(array('owner_uid'=>intval($_GET['uid'])));
            $shop_id = $shop['shop_id'];
        }

        if (!$shop) {

        }else {
            shop_update_data(array('shop_id'=>$shop_id), '`view_num`=`view_num`+1');
            $condition = array('shop_id'=>$shop_id, 'on_sale'=>1);
            $itemlist = item_get_list($condition, 0);
            $shop_item_count = item_get_count(array('shop_id'=>$shop['shop_id'], 'on_sale'=>1));

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