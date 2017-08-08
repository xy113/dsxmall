<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/3
 * Time: 下午5:02
 */
namespace Model\Goods;
class ItemController extends BaseController{
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
            goods_update_item(array('id'=>$id), 'viewnum=viewnum+1');
            $goods_desc = goods_get_desc(array('goods_id'=>$id));
            $gallery = goods_get_image_list(array('goods_id'=>$id));
            if (!$gallery) {
                $gallery = array(
                    array(
                        'thumb'=>$goods['goods_thumb'],
                        'image'=>$goods['goods_image']
                    )
                );
            }

            $shop = shop_get_data(array('shop_id'=>$goods['shop_id']));
            $shop_info = shop_get_info(array('shop_id'=>$shop['shop_id']));

            $_G['title'] = $goods['goods_name'];
            include template('item');
        }
    }
}