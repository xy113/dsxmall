<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/25
 * Time: 下午4:46
 */

namespace Model\App;


use Data\Cart\CartModel;

class CartController extends BaseController
{
    /**
     *
     */
    public function index(){
        global $_G,$_lang;

        $cart_item_list = (new CartModel())->where(array('uid'=>$this->uid))->select();
        $totalnum = count($cart_item_list);
        if ($cart_item_list) {
            $datalist = array();
            foreach ($cart_item_list as $item){
                $item['total_fee'] = floatval($item['price']) * intval($item['quantity']);
                $datalist[$item['shop_id']]['shop_id'] = $item['shop_id'];
                $datalist[$item['shop_id']]['shop_name'] = $item['shop_name'];
                $datalist[$item['shop_id']]['items'][$item['itemid']] = $item;
            }
            $cart_item_list = $datalist;
            unset($datalist);
        }

        $_G['title'] = $_lang['cart'];
        include template('cart');
    }
}