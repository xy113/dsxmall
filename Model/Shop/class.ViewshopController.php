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
            shop_update_data(array('shop_id'=>$shop_id), '`view_num`=`view_num`+1');
            //掌柜热卖
            $hot_item_list = goods_get_item_list(array('on_sale'=>1, 'shop_id'=>$shop_id), 5, 0, 'sold DESC');

            $pagesize = 20;
            $condition = array('shop_id'=>$shop_id, 'on_sale'=>1);
            $totalnum  = goods_get_item_count($condition);
            $pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
            $offset = ($_G['page'] - 1) * $pagesize;
            $itemlist = goods_get_item_list($condition, $pagesize, $offset, 'sold DESC');
            $pages = $this->showPages($_G['page'], $pagecount, $totalnum, "shop_id=$shop_id", true);

            $_G['title'] = $shop['shop_name'];
            include template('viewshop');
        }
    }
}