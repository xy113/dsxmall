<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/25
 * Time: 下午12:31
 */

namespace Model\App;


use Data\Item\ItemDescModel;
use Data\Item\ItemImageModel;
use Data\Item\ItemModel;
use Data\Shop\ShopModel;

class ItemController extends BaseController
{
    /**
     * 商品详情
     */
    public function index(){
        global $_G,$_lang;
        $itemid = intval($_GET['itemid']);
        if (!$itemid) $itemid = intval($_GET['id']);

        $itemModel = new ItemModel();
        $item_data = $itemModel->where(array('itemid'=>$itemid))->getOne();
        if (!$item_data) {

        }else {
            $itemModel->where(array('itemid'=>$itemid))->data('`view_num`=`view_num`+1')->save();
            $item_desc = (new ItemDescModel())->where(array('itemid'=>$itemid))->getOne();
            $item_desc['content'] = cleanUpStyle($item_desc['content']);
            $item_desc['content'] = preg_replace('/\<img(.*?)src=\"(.*?)\"(.*?)\>/is',
                '<img title="" class="lazyload" data-original="\\2">', $item_desc['content']);
            $gallery = (new ItemImageModel())->where(array('itemid'=>$itemid))->select();
            if (!$gallery) {
                $gallery = array(
                    array(
                        'thumb'=>$item_data['thumb'],
                        'image'=>$item_data['image']
                    )
                );
            }
            //店铺资料
            $shop = (new ShopModel())->where(array('shop_id'=>$item_data['shop_id']))->getOne();
            if ($shop) {
                $shop['short_shop_name']  = cutstr($shop['shop_name'], 24);
                $shop['short_owner_username'] = cutstr($shop['owner_username'], 16);
                $shop_item_count = $itemModel->where(array('shop_id'=>$shop['shop_id'], 'on_sale'=>1))->count();
            }

            //掌柜热卖
            $hot_sale_list = (new ItemModel())->where(array('shop_id'=>$item_data['shop_id'] ,'on_sale'=>1))->order('sold DESC')->limit(0, 10)->select();
            $_G['title'] = $item_data['title'];
            include template('item');
        }
    }
}