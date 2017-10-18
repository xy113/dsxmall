<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/3
 * Time: 下午4:53
 */
namespace Model\Shop;
use Data\Item\ItemModel;
use Data\Shop\ShopModel;

class ViewshopController extends BaseController{
    /**
     * 查看店铺详情
     */
    public function index(){
        global $_G,$_lang;

        $shop = array();
        $shop_id = intval($_GET['shop_id']);
        $shopModel = new ShopModel();
        if ($shop_id) {
            $shop = $shopModel->where(array('shop_id'=>$shop_id))->getOne();
        }elseif ($_GET['uid']) {
            $shop = $shopModel->where(array('uid'=>intval($_GET['uid'])))->getOne();
            $shop_id = $shop['shop_id'];
        }

        if (!$shop) {

        }else {
            //掌柜热卖
            $itemModel = new ItemModel();
            $hot_item_list = $itemModel->where(array('on_sale'=>1, 'shop_id'=>$shop_id))->limit(0, 5)->order('sold DESC')->select();

            $pagesize = 20;
            $condition = array('shop_id'=>$shop_id, 'on_sale'=>1);
            $totalnum  = $itemModel->where($condition)->count();
            $pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
            $itemlist  = $itemModel->where($condition)->page($_G['page'], $pagesize)->order('sold DESC')->select();
            $pagination = $this->pagination($_G['page'], $pagecount, $totalnum, "shop_id=$shop_id", true);

            $_G['title'] = $shop['shop_name'];
            include template('viewshop');
        }
    }
}