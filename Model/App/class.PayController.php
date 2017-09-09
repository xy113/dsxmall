<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/29
 * Time: 上午10:14
 */

namespace Model\App;


class PayController extends BaseController
{
    public function index(){

    }

    /**
     * 订单支付结果查询
     */
    public function order_query(){
        global $_G,$_lang;

        $order_id = intval($_GET['order_id']);
        $order = order_get_data(array('order_id'=>$order_id));
        $item  = order_get_item(array('order_id'=>$order_id));

        include template('order_query');
    }

    public function order_commited(){
        global $_G,$_lang;

        $order_id = intval($_GET['order_id']);
        $order = order_get_data(array('order_id'=>$order_id));
        $item  = order_get_item(array('order_id'=>$order_id));

        include template('order_commited');
    }
}