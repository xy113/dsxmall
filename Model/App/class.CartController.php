<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/25
 * Time: 下午4:46
 */

namespace Model\App;


class CartController extends BaseController
{
    /**
     *
     */
    public function index(){
        global $_G,$_lang;
        $itemlist = cart_get_list(array('uid'=>$this->uid), 0);
        $totalnum = count($itemlist);
        if ($itemlist) {
            $datalist = array();
            foreach ($itemlist as $item){
                $item['total_fee'] = floatval($item['goods_price']) * intval($item['goods_number']);
                $datalist[$item['shop_id']]['shop_id'] = $item['shop_id'];
                $datalist[$item['shop_id']]['shop_name'] = $item['shop_name'];
                $datalist[$item['shop_id']]['goods'][$item['goods_id']] = $item;
            }
            $itemlist = $datalist;
            unset($datalist);
        }

        $_G['title'] = $_lang['cart'];
        include template('cart');
    }
}