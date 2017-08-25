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

        $id = intval($_GET['id']);
        $goods = goods_get_item(array('id'=>$id));
        if (!$goods) {

        }else {
            $goods['short_name'] = cutstr($goods['goods_name'], 20, '...');
            goods_update_item(array('id'=>$id), '`view_num`=`view_num`+1');
            $goods_desc = goods_get_desc(array('goods_id'=>$id));
            $goods_desc['content'] = cleanUpStyle($goods_desc['content']);
            $goods_desc['content'] = preg_replace('/\<img(.*?)src=\"(.*?)\"(.*?)\>/is',
                '<img class="lazyload" data-original="\\2">', $goods_desc['content']);
            $gallery = goods_get_image_list(array('goods_id'=>$id));
            if (!$gallery) {
                $gallery = array(
                    array(
                        'thumb'=>$goods['goods_thumb'],
                        'image'=>$goods['goods_image']
                    )
                );
            }
            //店铺资料
            $shop = shop_get_data(array('shop_id'=>$goods['shop_id']));
            if ($shop) {
                $shop_info = shop_get_info(array('shop_id'=>$shop['shop_id']));
                $shop['short_shop_name']  = cutstr($shop['shop_name'], 24);
                $shop['short_owner_username'] = cutstr($shop['owner_username'], 16);
                $shop_item_count = goods_get_item_count(array('shop_id'=>$shop['shop_id'], 'on_sale'=>1));
            }

            //掌柜热卖
            $hot_sale_list = goods_get_item_list(array('shop_id'=>$goods['shop_id'] ,'on_sale'=>1), 10, 0 ,'sold DESC');
            $_G['title'] = $goods['goods_name'];
            include template('item');
        }
    }
}