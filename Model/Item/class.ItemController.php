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

        $id = intval($_GET['id']);
        $item_data = item_get_data(array('id'=>$id));
        if (!$item_data) {

        }else {
            $item_data['short_name'] = cutstr($item_data['name'], 20, '...');
            item_update_data(array('id'=>$id), '`view_num`=`view_num`+1');
            $item_desc = item_get_desc(array('itemid'=>$id));
            $gallery = item_get_image_list(array('itemid'=>$id));
            if (!$gallery) {
                $gallery = array(
                    array(
                        'thumb'=>$item_data['thumb'],
                        'image'=>$item_data['image']
                    )
                );
            }

            $shop = shop_get_data(array('shop_id'=>$item_data['shop_id']));
            $shop_info = shop_get_info(array('shop_id'=>$shop['shop_id']));
            $shop['short_shop_name']  = cutstr($shop['shop_name'], 24);
            $shop['short_owner_username'] = cutstr($shop['owner_username'], 16);

            //掌柜热卖
            $hot_sale_list = item_get_list(array('shop_id'=>$item_data['shop_id'] ,'on_sale'=>1), 5, 0 ,'sold DESC');
            $_G['title'] = $item_data['name'];
            include template('item');
        }
    }
}