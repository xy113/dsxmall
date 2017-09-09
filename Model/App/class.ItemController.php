<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/25
 * Time: 下午12:31
 */

namespace Model\App;


class ItemController extends BaseController
{
    /**
     * 商品详情
     */
    public function index(){
        global $_G,$_lang;
        $itemid = intval($_GET['itemid']);
        if (!$itemid) $itemid = intval($_GET['id']);
        $item_data = item_get_data(array('itemid'=>$itemid));
        if (!$item_data) {

        }else {
            item_get_data(array('itemid'=>$itemid), '`view_num`=`view_num`+1');
            $item_desc = item_get_desc(array('itemid'=>$itemid));
            $item_desc['content'] = cleanUpStyle($item_desc['content']);
            $item_desc['content'] = preg_replace('/\<img(.*?)src=\"(.*?)\"(.*?)\>/is',
                '<img class="lazyload" data-original="\\2">', $item_desc['content']);
            $gallery = item_get_image_list(array('itemid'=>$itemid));
            if (!$gallery) {
                $gallery = array(
                    array(
                        'thumb'=>$item_data['thumb'],
                        'image'=>$item_data['image']
                    )
                );
            }
            //店铺资料
            $shop = shop_get_data(array('shop_id'=>$item_data['shop_id']));
            if ($shop) {
                $shop['short_shop_name']  = cutstr($shop['shop_name'], 24);
                $shop['short_owner_username'] = cutstr($shop['owner_username'], 16);
                $shop_item_count = item_get_count(array('shop_id'=>$shop['shop_id'], 'on_sale'=>1));
            }

            //掌柜热卖
            $hot_sale_list = item_get_list(array('shop_id'=>$item_data['shop_id'] ,'on_sale'=>1), 10, 0 ,'sold DESC');
            $_G['title'] = $item_data['name'];
            include template('item');
        }
    }
}