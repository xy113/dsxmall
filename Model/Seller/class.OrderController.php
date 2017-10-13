<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/23
 * Time: 上午11:51
 */

namespace Model\Seller;


use Data\Common\ExpressModel;
use Data\Trade\OrderItemModel;
use Data\Trade\OrderModel;
use Data\Trade\OrderShippingModel;
use Data\Trade\TradeModel;

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
        $order = (new OrderModel())->where(array('order_id'=>$order_id))->getOne();
        $trade_status = order_get_trade_status($order);
        $trade_status_tips = $_lang['order_trade_status'][$trade_status];
        if ($trade_status == 3) $shipping = (new OrderShippingModel())->where(array('order_id'=>$order_id))->getOne();

        if ($order['shipping_status']){
            $shipping = (new OrderShippingModel())->where(array('order_id'=>$order_id))->getOne();
        }else {
            $express_list = (new ExpressModel())->order('id', 'ASC')->select();
        }
        //商品列表
        $itemlist = (new OrderItemModel())->where(array('order_id'=>$order_id))->select();

        $_G['title'] = '订单详情';
        include template('order_detail');
    }

    /**
     * 订单已发货
     */
    public function send(){
        $order_id = intval($_GET['order_id']);
        $orderModel = new OrderModel();
        $order = $orderModel->where(array('order_id'=>$order_id, 'seller_uid'=>$this->uid))->getOne();
        if (!$order) {
            $this->showError('order_not_exists');
        }
        if ($order['shipping_status']) {
            $this->showError('order_has_send');
        }

        $shipping_type = intval($_GET['shipping_type']);
        if ($order['pay_type'] == 1){
            //更新订单状态
            $orderModel->where(array('order_id'=>$order_id, 'seller_uid'=>$this->uid))
                ->data(array('shipping_type'=>$shipping_type, 'shipping_status'=>1, 'shipping_time'=>time()))->save();
        }

        if ($order['pay_type'] == 2 && $order['shipping_status'] == 0){
            //更新订单状态
            $orderModel->where(array('order_id'=>$order_id, 'seller_uid'=>$this->uid))
                ->data(array('shipping_type'=>$shipping_type, 'shipping_status'=>1, 'shipping_time'=>time(), 'is_accepted'=>1))->save();
        }
        if ($shipping_type == 1){
            $express_id = intval($_GET['express_id']);
            $express_no = htmlspecialchars($_GET['express_no']);
            if ($express_id && $express_no) {
                $express = (new ExpressModel())->where(array('id'=>$express_id))->getOne();
                (new OrderShippingModel())->data(array(
                    'uid'=>$this->uid,
                    'order_id'=>$order_id,
                    'shipping_type'=>1,
                    'express_id'=>$express_id,
                    'express_name'=>$express['name'],
                    'express_no'=>$express_no,
                    'shipping_time'=>time()
                ))->save();
            }else {
                $this->showError('invalid_parameter');
            }
        }else {
            (new OrderShippingModel())->data(array(
                'uid'=>$this->uid,
                'order_id'=>$order_id,
                'shipping_type'=>2,
                'shipping_time'=>time()
            ))->save();
        }
        $this->showSuccess('order_send_success');
    }

    /**
     * 修改订单价格
     */
    public function edit_price(){
        global $_G,$_lang;

        $order_id = intval($_GET['order_id']);
        $orderModel = new OrderModel();
        $order = $orderModel->where(array('seller_uid'=>$this->uid, 'order_id'=>$order_id))->getOne();
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
                    $orderModel->where(array('itemid'=>$itemid, 'order_id'=>$order_id))->data($item)->save();
                    $order_total_fee+= $item['total_fee'];
                    $order_shipping_fee+= $item['shipping_fee'];
                }
                $orderModel->where(array('seller_uid'=>$this->uid, 'order_id'=>$order_id))
                    ->data(array(
                        'order_fee'=>$order_order_fee,
                        'shipping_fee'=>$order_shipping_fee,
                        'total_fee'=>$order_total_fee
                    ))->save();
                (new TradeModel())->where(array('trade_no'=>$order['trade_no']))->data(array('trade_fee'=>$order_total_fee))->save();
                $this->showAjaxReturn();
            }
        }else {
            $itemlist = array();
            if ($order) {
                $itemlist = (new OrderItemModel())->where(array('order_id'=>$order_id))->select();
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