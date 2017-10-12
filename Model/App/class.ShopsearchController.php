<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/27
 * Time: 上午9:35
 */

namespace Model\App;


use Data\Item\ItemModel;
use Data\Shop\ShopModel;

class ShopsearchController extends BaseController
{
    /**
     * 商品搜索结果
     */
    public function index(){
        global $_G,$_lang;

        $formdata = array();
        $q = $_GET['q'] ? htmlspecialchars($_GET['q']) : '';
        if ($q) $formdata['q'] = $q;
        $formdata = json_encode($formdata);

        include template('shop_list');
    }

    /**
     * 获取店铺信息
     */
    public function batchget(){
        $shopModel = new ShopModel();

        $condition = array('closed'=>'0');
        $fields = 'shop_id, shop_name, shop_logo, total_sold, city, county';
        $q = $_GET['q'] ? htmlspecialchars($_GET['q']) : '';
        if ($q) $condition['shop_name'] = array('LIKE' , trim($q));

        $shop_list = $shopModel->where($condition)->field($fields)->page(G('page'), 20)->select();
        $datalist = array();
        foreach ($shop_list as $shop){
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
}