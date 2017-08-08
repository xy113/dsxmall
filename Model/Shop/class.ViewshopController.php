<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/3
 * Time: 下午4:53
 */
namespace Model\Shop;
class ViewshopController extends BaseController{
    /**
     * 查看店铺详情
     */
    public function index(){
        global $_G,$_lang;

        $shop_id = intval($_GET['shop_id']);
        $shop = shop_get_data(array('shop_id'=>$shop_id));
        if (!$shop) {

        }else {
            shop_update_data(array('shop_id'=>$shop_id), 'viewnum=viewnum+1');
            $shop['viewnum']++;

            $_G['title'] = $shop['shop_name'];
            include template('viewshop');
        }
    }
}