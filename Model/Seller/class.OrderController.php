<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/23
 * Time: 上午11:51
 */

namespace Model\Seller;


class OrderController extends BaseController
{
    /**
     * OrderController constructor.
     */
    function __construct()
    {
        parent::__construct();
        G('menu', 'sold_item');
    }

    /**
     *
     */
    public function index(){

    }

    /**
     * 订单详情
     */
    public function detail(){
        global $_G,$_lang;

        $order_id = intval($_GET['order_id']);
        $order = order_get_data(array('order_id'=>$order_id));
        $trade_status = order_get_trade_status($order);
        $trade_status_tips = $_lang['order_trade_status'][$trade_status];
        if ($trade_status == 3) $shipping = order_get_shipping(array('order_id'=>$order_id));

        if ($order['shipping_status']){
            $shipping = order_get_shipping(array('order_id'=>$order_id));
        }else {
            $express_list = M('express')->order('id', 'ASC')->select();
        }
        //商品列表
        $itemlist = order_get_item_list(array('order_id'=>$order_id));

        $_G['title'] = '订单详情';
        include template('order_detail');
    }

    /**
     * 订单已发货
     */
    public function send(){
        $order_id = intval($_GET['order_id']);
        $order = order_get_data(array('order_id'=>$order_id, 'seller_uid'=>$this->uid));
        if (!$order) {
            $this->showError('order_not_exists');
        }
        if ($order['shipping_status']) {
            $this->showError('order_has_send');
        }

        $shipping_type = intval($_GET['shipping_type']);
        if ($order['pay_type'] == 1){
            //更新订单状态
            order_update_data(array('order_id'=>$order_id, 'seller_uid'=>$this->uid),
                array('shipping_type'=>$shipping_type, 'shipping_status'=>1, 'shipping_time'=>time()));
        }

        if ($order['pay_type'] == 2 && $order['shipping_status'] == 0){
            //更新订单状态
            order_update_data(array('order_id'=>$order_id, 'seller_uid'=>$this->uid),
                array('shipping_type'=>$shipping_type, 'shipping_status'=>1, 'shipping_time'=>time(), 'is_accepted'=>1));
        }
        if ($shipping_type == 1){
            $express_id = intval($_GET['express_id']);
            $express_no = htmlspecialchars($_GET['express_no']);
            if ($express_id && $express_no) {
                $express = M('express')->where(array('id'=>$express_id))->getOne();
                order_add_shipping(array(
                    'uid'=>$this->uid,
                    'order_id'=>$order_id,
                    'shipping_type'=>1,
                    'express_id'=>$express_id,
                    'express_name'=>$express['name'],
                    'express_no'=>$express_no,
                    'shipping_time'=>time()
                ));
            }else {
                $this->showError('invalid_parameter');
            }
        }else {
            order_add_shipping(array(
                'uid'=>$this->uid,
                'order_id'=>$order_id,
                'shipping_type'=>2,
                'shipping_time'=>time()
            ));
        }
        $this->showSuccess('order_send_success');
    }

    /**
     * 修改订单价格
     */
    public function edit_price(){
        global $_G,$_lang;

        $order_id = intval($_GET['order_id']);
        $order = order_get_data(array('seller_uid'=>$this->uid, 'order_id'=>$order_id));
        if ($this->checkFormSubmit()){
            $itemlist = $_GET['itemlist'];
            if ($itemlist) {
                $order_total_fee = $order_shipping_fee = $order_order_fee = 0;
                foreach ($itemlist as $itemid=>$item){
                    $item['promotion_price'] = floatval($item['promotion_price']);
                    $item['quantity'] = intval($item['quantity']);
                    $item['shipping_fee'] = floatval($item['shipping_fee']);
                    if ($item['promotion_price'] != $item['price']){
                        $item['discount'] = $item['promotion_price']/$item['price'];
                        $item['promotion_fee'] = $item['price'] - $item['promotion_price'];
                        $item['total_fee'] = $item['promotion_price']*$item['quantity']+$item['shipping_fee'];
                        $order_order_fee+= $item['promotion_price']*$item['quantity'];
                    }else {
                        $item['promotion_price'] = 0;
                        $item['total_fee'] = $item['price']*$item['quantity']+$item['shipping_fee'];
                        $order_order_fee+= $item['price']*$item['quantity'];
                    }
                    order_update_item(array('itemid'=>$itemid, 'order_id'=>$order_id), $item);
                    $order_total_fee+= $item['total_fee'];
                    $order_shipping_fee+= $item['shipping_fee'];
                }
                order_update_data(array('seller_uid'=>$this->uid, 'order_id'=>$order_id),array(
                    'order_fee'=>$order_order_fee,
                    'shipping_fee'=>$order_shipping_fee,
                    'total_fee'=>$order_total_fee
                ));
                trade_update_data(array('trade_no'=>$order['trade_no']), array('trade_fee'=>$order_total_fee));
                $this->showAjaxReturn();
            }
        }else {
            $itemlist = array();
            if ($order) {
                $itemlist = order_get_item_list(array('order_id'=>$order_id));
                if ($itemlist) {
                    $datalist = array();
                    foreach ($itemlist as $item){
                        if(!$item['promotion_price']) $item['promotion_price'] = $item['price'];
                        $datalist[$item['itemid']] = $item;
                    }
                    $itemlist = $datalist;
                }
                include template('frame_edit_price');
            }
        }
    }
}