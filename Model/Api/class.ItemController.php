<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/28
 * Time: 上午11:26
 */

namespace Model\Api;


class ItemController extends BaseController
{
    /**
     * 获取商品资料
     */
    public function get(){
        $itemid = intval($_GET['itemid']);
        if (!$itemid) $itemid = intval($_GET['id']);
        $item = item_get_data(array('itemid'=>$itemid, 'on_sale'=>1));
        if ($item) {
            $item['formated_price'] = formatAmount($item['price']);
            $item['formated_market_price'] = formatAmount($item['market_price']);
            $item['goods_thumb'] = image($item['thumb']);
            $item['thumb'] = image($item['thumb']);

            $shop = shop_get_data(array('shop_id'=>$item['shop_id']));
            if ($shop) {
                $item['shop_name'] = $shop['shop_name'];
                $item['shop_logo'] = image($shop['shop_logo']);
                $item['province'] = $shop['province'];
                $item['city'] = $shop['city'];
                $item['county'] = $shop['county'];
            }else {
                $item['shop_name'] = '';
                $item['shop_logo'] = image($shop['shop_logo']);
                $item['province'] = '贵州省';
                $item['city'] = '六盘水市';
                $item['county'] = '水城县';
            }
            $this->showAjaxReturn($item);
        }else {
            $this->showAjaxReturn(array());
        }
    }

}