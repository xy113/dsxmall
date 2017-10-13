<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/3
 * Time: 下午5:02
 */
namespace Model\Item;
use Data\Item\ItemDescModel;
use Data\Item\ItemImageModel;
use Data\Item\ItemModel;
use Data\Shop\ShopModel;

class ItemController extends BaseController{
    /**
     * 商品详情
     */
    public function index(){
        global $_G,$_lang;

        $itemModel = new ItemModel();
        $itemid = intval($_GET['itemid']);
        if (!$itemid) $itemid = intval($_GET['id']);//兼容老版本
        $item_data = $itemModel->where(array('itemid'=>$itemid))->getOne();
        if (!$item_data) {
            
        }else {
            $item_data['short_title'] = cutstr($item_data['title'], 20, '...');
            $itemModel->where(array('itemid'=>$itemid))->data('`view_num`=`view_num`+1')->save();
            $item_desc = (new ItemDescModel())->where(array('itemid'=>$itemid))->getOne();
            $gallery = (new ItemImageModel())->where(array('itemid'=>$itemid))->select();
            if (!$gallery) {
                $gallery = array(
                    array(
                        'thumb'=>$item_data['thumb'],
                        'image'=>$item_data['image']
                    )
                );
            }

            $shop = (new ShopModel())->where(array('shop_id'=>$item_data['shop_id']))->getOne();
            $shop['short_name']  = cutstr($shop['shop_name'], 24);
            $shop['short_username'] = cutstr($shop['username'], 16);

            //掌柜热卖
            $hot_sale_list = $itemModel->where(array('shop_id'=>$item_data['shop_id'] ,'on_sale'=>1))->limit(0, 5)->order('sold DESC')->select();
            $_G['title'] = $item_data['title'];
            include template('item');
        }
    }
}