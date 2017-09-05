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
}