<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/3
 * Time: 下午5:02
 */
namespace Model\Item;
class ItemController extends BaseController{
    /**
     * 商品详情
     */
    public function index(){
        global $_G,$_lang;

        $itemid = intval($_GET['itemid']);
        if (!$itemid) $itemid = intval($_GET['id']);//兼容老版本
        $item_data = item_get_data(array('itemid'=>$itemid));
        if (!$item_data) {
            
        }else {
            $item_data['short_title'] = cutstr($item_data['title'], 20, '...');
            item_update_data(array('itemid'=>$itemid), '`view_num`=`view_num`+1');
            $item_desc = item_get_desc(array('itemid'=>$itemid));
            $gallery = item_get_image_list(array('itemid'=>$itemid));
            if (!$gallery) {
                $gallery = array(
                    array(
                        'thumb'=>$item_data['thumb'],
                        'image'=>$item_data['image']
                    )
                );
            }

            $shop = shop_get_data(array('shop_id'=>$item_data['shop_id']));
            $shop['short_name']  = cutstr($shop['shop_name'], 24);
            $shop['short_username'] = cutstr($shop['username'], 16);

            //掌柜热卖
            $hot_sale_list = item_get_list(array('shop_id'=>$item_data['shop_id'] ,'on_sale'=>1), 5, 0 ,'sold DESC');
            $_G['title'] = $item_data['title'];
            include template('item');
        }
    }
}