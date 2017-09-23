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
                    cart_delete_data(array('uid'=>$this->uid, 'itemid'=>$item['itemid']));
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
            cookie('cart_total_count', cart_get_count(array('uid'=>$this->uid)));
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
                cart_delete_data(array('uid'=>$this->uid, 'itemid'=>intval($itemid)));
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

        cart_update_data(array('uid'=>$this->uid, 'itemid'=>$itemid), array('quantity'=>$quantity));
        $this->showAjaxReturn();
    }

    public function move_to_favor(){
        $items = $_GET['items'];
        if ($items) {
            $itemlist = cart_get_list(array('uid'=>$this->uid, 'itemid'=>array('IN', $items)));
            foreach ($itemlist as $item){
                if (!collection_get_count(array('uid'=>$this->uid, 'dataid'=>$item['itemid'], 'datatype'=>'item'))){
                    collection_add_data(array(
                        'uid'=>$this->uid,
                        'dataid'=>$item['itemid'],
                        'datatype'=>'item',
                        'title'=>$item['title'],
                        'image'=>$item['thumb'],
                        'create_time'=>time()
                    ));
                }
                cart_delete_data(array('uid'=>$this->uid, 'itemid'=>$item['itemid']));
            }
        }
        $this->showAjaxReturn();
    }
}

