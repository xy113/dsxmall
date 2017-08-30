<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/8
 * Time: 下午5:11
 */
namespace Model\Cart;
class IndexController extends BaseController{
    /**
     *
     */
    public function index(){
        global $_G,$_lang;

        $itemlist = cart_get_list(array('uid'=>$this->uid), 0);
        $totalnum = count($itemlist);
        if ($itemlist) {
            $datalist = array();
            foreach ($itemlist as $item){
                $item['total_fee'] = floatval($item['goods_price']) * intval($item['goods_number']);
                $datalist[$item['shop_id']]['shop_id'] = $item['shop_id'];
                $datalist[$item['shop_id']]['shop_name'] = $item['shop_name'];
                $datalist[$item['shop_id']]['goods'][$item['goods_id']] = $item;
            }
            $itemlist = $datalist;
            unset($datalist);
        }

        $_G['title'] = $_lang['cart'];
        include template('index');
    }

    /**
     * 添加购物车
     */
    public function add(){
        $goods_id = intval($_GET['goods_id']);
        $goods_number = intval($_GET['goods_number']);
        $item = goods_get_item(array('id'=>$goods_id));
        if ($item) {
            if (cart_get_count(array('uid'=>$this->uid, 'goods_id'=>$goods_id))){
                cart_update_data(array('uid'=>$this->uid, 'goods_id'=>$goods_id), "`goods_number`=`goods_number`+".$goods_number);
            }else {
                $shop = shop_get_data(array('shop_id'=>$item['shop_id']));
                cart_add_data(array(
                    'uid'=>$this->uid,
                    'shop_id'=>$shop['shop_id'],
                    'shop_name'=>$shop['shop_name'],
                    'goods_id'=>$goods_id,
                    'goods_name'=>$item['goods_name'],
                    'goods_number'=>$goods_number,
                    'goods_price'=>$item['goods_price'],
                    'goods_thumb'=>$item['goods_thumb'],
                    'goods_image'=>$item['goods_image'],
                    'create_time'=>time()
                ));
            }

            $this->showAjaxReturn();
        }else {
            $this->showAjaxError('FAIL', 'goods_not_exists');
        }
    }

    /**
     * AJAX删除宝贝
     */
    public function delete(){
        $goods_id = $_GET['goods_id'];
        $id_list = explode(',', $goods_id);
        foreach ($id_list as $id) {
            cart_delete_data(array('uid'=>$this->uid, 'goods_id'=>intval($id)));
        }
        $this->showAjaxReturn();
    }

    /**
     * 更新商品数量
     */
    public function update_num(){
        $goods_id = intval($_GET['goods_id']);
        $goods_number = intval($_GET['goods_number']);

        cart_update_data(array('uid'=>$this->uid, 'goods_id'=>$goods_id), array('goods_number'=>$goods_number));
        $this->showAjaxReturn();
    }
}

