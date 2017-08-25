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

        $shop_list = shop_get_list(array('shop_status'=>'OPEN', 'auth_status'=>'SUCCESS'), 10);
        include template('shop_index');
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
            $itemlist = goods_get_item_list($condition, 0);
            $shop_item_count = goods_get_item_count(array('shop_id'=>$shop['shop_id'], 'on_sale'=>1));

            $_G['title'] = $shop['shop_name'];
            include template('viewshop');
        }
    }
}