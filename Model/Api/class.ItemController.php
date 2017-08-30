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
        $id = intval($_GET['id']);
        $item = goods_get_item(array('id'=>$id, 'on_sale'=>1));
        if ($item) {
            $item['formated_price'] = formatAmount($item['goods_price']);
            $item['formated_market_price'] = formatAmount($item['market_price']);
            $item['goods_thumb'] = image($item['goods_thumb']);

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