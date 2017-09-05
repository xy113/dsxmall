<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/26
 * Time: 上午10:09
 */

namespace Model\App;


class ItemsearchController extends BaseController
{
    /**
     *
     */
    public function index(){
        global $_G,$lang;

        $formdata = json_encode(array(
            'catid'=>intval($_GET['catid']),
            'q'=>htmlspecialchars($_GET['q'])
        ));

        include template('item_list');
    }

    /**
     * 获取搜索结果
     */
    public function batchget(){
        $condition = array('on_sale'=>1);
        $catid = intval($_GET['catid']);
        if ($catid) $condition[] = "(`cat_id`='$catid' OR `catid_2`='$catid' OR `catid_3`='$catid')";
        $q = $_GET['q'] ? htmlspecialchars($_GET['q']) : '';
        $q = str_replace(array(',',' ', '、'), '|', $q);
        $arr = array();
        foreach (explode('|', $q) as $key){
            if ($key) {
                $arr[] = "`name` LIKE '%$key%'";
            }
        }
        if (!empty($arr)) $condition[] = "(".implode(' OR ', $arr).")";

        $offset = (G('page') - 1) * 20;
        $fields = 'id,uid,shop_id,name,price,market_price,sold,thumb';
        $itemlist = item_get_list($condition, 20, $offset, 'sold DESC', $fields);
        $shop_ids = array();
        foreach ($itemlist as $item){
            $shop_ids[] = $item['shop_id'];
        }
        unset($item);

        $shop_list = array();
        $shop_ids = $shop_ids ? implodeids($shop_ids) : 0;
        if ($shop_ids) {
            $shop_list = shop_get_list(array('shop_id'=>array('IN', $shop_ids)), 0, 0, null, 'shop_id,shop_name,city,county');
            $datalist = array();
            foreach ($shop_list as $shop){
                $datalist[$shop['shop_id']] = $shop;
            }
            $shop_list = $datalist;
            unset($shop_ids, $datalist, $shop);
        }

        $datalist = array();
        foreach ($itemlist as $item){
            $item['price'] = formatAmount($item['price']);
            $item['thumb'] = image($item['thumb']);
            $item['shop_name'] = $shop_list[$item['shop_id']]['shop_name'] ? $shop_list[$item['shop_id']]['shop_name'] : '';
            $item['city'] = $shop_list[$item['shop_id']]['city'] ? $shop_list[$item['shop_id']]['city'] : '贵州';
            $item['county'] = $shop_list[$item['shop_id']]['county'] ? $shop_list[$item['shop_id']]['county'] : '六盘水';
            $datalist[] = $item;
        }
        unset($itemlist, $shop_list);
        $this->showAjaxReturn($datalist);
    }
}