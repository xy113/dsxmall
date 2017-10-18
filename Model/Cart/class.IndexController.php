<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/8
 * Time: 下午5:11
 */
namespace Model\Cart;
use Data\Cart\CartModel;
use Data\Common\CollectionModel;
use Data\Item\ItemModel;
use Data\Shop\ShopModel;

class IndexController extends BaseController{
    /**
     *
     */
    public function index(){
        global $_G,$_lang;

        $fields = 'c.itemid,c.shop_id,c.shop_name,c.sku_id,c.sku_name, c.price AS cart_price,c.quantity,i.price,i.thumb,i.title';
        $cart_item_list = M('cart c')->field($fields)->join('item i', 'i.itemid=c.itemid')
            ->where('c.uid='.$this->uid)->order('id', 'DESC')->select();
        $total_count = count($cart_item_list);
        cookie('cart_total_count', $total_count);

        $shop_item_list = array();
        if ($cart_item_list) {
            foreach ($cart_item_list as $item){
                if ($item['title']) {
                    $item['total_fee'] = $item['price'] * $item['quantity'];
                    $shop_item_list[$item['shop_id']]['shop_name'] = $item['shop_name'];
                    $shop_item_list[$item['shop_id']]['items'][$item['itemid']] = $item;
                }else {
                    (new CartModel())->where(array('uid'=>$this->uid, 'itemid'=>$item['itemid']))->delete();
                }
            }
        }
        unset($cart_item_list, $item);
        //print_array($shop_item_list);exit();

        $_G['title'] = $_lang['cart'];
        include template('index');
    }

    /**
     * 添加购物车
     */
    public function add(){
        $itemid = intval($_GET['itemid']);
        $quantity = intval($_GET['quantity']);
        $item = (new ItemModel())->where(array('itemid'=>$itemid))->getOne();
        $cartModel = new CartModel();
        if ($item) {
            if ($cartModel->where(array('uid'=>$this->uid, 'itemid'=>$itemid))->count()){
                $cartModel->where(array('uid'=>$this->uid, 'itemid'=>$itemid))->data("`quantity`=`quantity`+".$quantity)->save();
            }else {
                $shop = (new ShopModel())->where(array('shop_id'=>$item['shop_id']))->getOne();
                $cartModel->data(array(
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
                ))->add();
            }
            cookie('cart_total_count', $cartModel->where(array('uid'=>$this->uid))->count());
            $this->showAjaxReturn();
        }else {
            $this->showAjaxError('FAIL', 'item_not_exists');
        }
    }

    /**
     * AJAX删除宝贝
     */
    public function delete(){
        $items = $_GET['items'];
        if ($items) {
            foreach (explode(',', $items) as $itemid){
                (new CartModel())->where(array('uid'=>$this->uid, 'itemid'=>intval($itemid)))->delete();
            }
        }
        $this->showAjaxReturn();
    }

    /**
     * 更新商品数量
     */
    public function update_quantity(){
        $itemid = intval($_GET['itemid']);
        $quantity = intval($_GET['quantity']);

        (new CartModel())->where(array('uid'=>$this->uid, 'itemid'=>$itemid))->data(array('quantity'=>$quantity))->save();
        $this->showAjaxReturn();
    }

    /**
     * 移动到收藏夹
     */
    public function move_to_favor(){
        $items = $_GET['items'];
        if ($items) {
            $cartModel = new CartModel();
            $collectionModel = new CollectionModel();
            $itemlist = $cartModel->where(array('uid'=>$this->uid, 'itemid'=>array('IN', $items)))->select();
            foreach ($itemlist as $item){
                $count = $collectionModel->where(array('uid'=>$this->uid, 'dataid'=>$item['itemid'], 'datatype'=>'item'))->count();
                if ($count === 0){
                    $collectionModel->data(array(
                        'uid'=>$this->uid,
                        'dataid'=>$item['itemid'],
                        'datatype'=>'item',
                        'title'=>$item['title'],
                        'image'=>$item['thumb'],
                        'create_time'=>time()
                    ))->add();
                }
                $cartModel->where(array('uid'=>$this->uid, 'itemid'=>$item['itemid']))->delete();
            }
        }
        $this->showAjaxReturn();
    }
}

