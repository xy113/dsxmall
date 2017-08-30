<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/27
 * Time: 上午9:35
 */

namespace Model\App;


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
        $offset = (G('page') - 1) * 20;
        $fields = 'shop_id, shop_name, shop_logo, total_sold, city, county';
        $condition = array('shop_status'=>'OPEN', 'auth_status'=>'SUCCESS');
        $q = $_GET['q'] ? htmlspecialchars($_GET['q']) : '';
        if ($q) $condition['shop_name'] = array('LIKE' , trim($q));

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
        unset($shop_list, $shop, $goods_list, $goods, $shop_ids);
        $this->showAjaxReturn(array_values($datalist));
    }
}