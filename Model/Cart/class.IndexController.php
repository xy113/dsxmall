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

        $cart_list = cart_get_list(array('uid'=>$this->uid), 0);
        $totalnum = count($cart_list);
        if ($cart_list) {
            $datalist = array();
            foreach ($cart_list as $cart){
                $cart['total_fee'] = floatval($cart['price']) * intval($cart['quantity']);
                $datalist[$cart['shop_id']]['shop_id'] = $cart['shop_id'];
                $datalist[$cart['shop_id']]['shop_name'] = $cart['shop_name'];
                $datalist[$cart['shop_id']]['items'][$cart['itemid']] = $cart;
            }
            $cart_list = $datalist;
            unset($datalist, $cart);
        }

        $_G['title'] = $_lang['cart'];
        include template('index');
    }

    /**
     * 添加购物车
     */
    public function add(){
        $itemid = intval($_GET['itemid']);
        $quantity = intval($_GET['quantity']);
        $item = item_get_data(array('itemid'=>$itemid));
        if ($item) {
            if (cart_get_count(array('uid'=>$this->uid, 'itemid'=>$itemid))){
                cart_update_data(array('uid'=>$this->uid, 'itemid'=>$itemid), "`quantity`=`quantity`+".$quantity);
            }else {
                $shop = shop_get_data(array('shop_id'=>$item['shop_id']));
                cart_add_data(array(
                    'uid'=>$this->uid,
                    'itemid'=>$itemid,
                    'quantity'=>$quantity,
                    'shop_id'=>$shop['shop_id'],
                    'shop_name'=>$shop['shop_name'],
                    'title'=>$item['title'],
                    'price'=>$item['price'],
                    'thumb'=>$item['thumb'],
                    'image'=>$item['image'],
                    'create_time'=>time()
                ));
            }

            $this->showAjaxReturn();
        }else {
            $this->showAjaxError('FAIL', 'item_not_exists');
        }
    }

    /**
     * AJAX删除宝贝
     */
    public function delete(){
        $itemid = $_GET['itemid'];
        $id_list = explode(',', $itemid);
        foreach ($id_list as $id) {
            cart_delete_data(array('uid'=>$this->uid, 'itemid'=>intval($id)));
        }
        $this->showAjaxReturn();
    }

    /**
     * 更新商品数量
     */
    public function update_quantity(){
        $itemid = intval($_GET['itemid']);
        $quantity = intval($_GET['quantity']);

        cart_update_data(array('uid'=>$this->uid, 'itemid'=>$itemid), array('quantity'=>$quantity));
        $this->showAjaxReturn();
    }
}

