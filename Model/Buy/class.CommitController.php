<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/5
 * Time: 上午10:57
 */

namespace Model\Buy;


use Data\Trade\OrderModel;

class CommitController extends BaseController
{
    /**
     * 订单已提交
     */
    public function index(){
        $order_id = intval($_GET['order_id']);
        $order = (new OrderModel())->where(array('order_id'=>$order_id))->getOne();

        $_G['title'] = L('order_commited');
        include template('order_commited');
    }

}