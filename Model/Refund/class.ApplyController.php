<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/12
 * Time: 下午4:13
 */

namespace Model\Refund;


use Data\Shop\ShopModel;
use Data\Trade\OrderItemModel;
use Data\Trade\OrderModel;
use Data\Trade\OrderRefundModel;

class ApplyController extends BaseController
{
    /**
     *
     */
    public function index(){
        global $_G,$_lang;

        $order_id = intval($_GET['order_id']);
        $orderModel = new OrderModel();
        $order = $orderModel->where(array('order_id'=>$order_id, 'buyer_uid'=>$this->uid, 'refund_status'=>0))->getOne();
        if (!$order) $this->showError('order_not_exists');
        if ($order['pay_type'] != 1 || $order['pay_status'] != 1){
            $this->showError('order_can_not_refund');
        }

        if ($this->checkFormSubmit()){
            $refund = $_GET['refund'];
            if ($refund['refund_type'] && $refund['refund_reason'] && $refund['refund_fee']){
                $refund['refund_fee'] = floatval($refund['refund_fee']);
                if ($refund['refund_fee'] > $order['total_fee']) $refund['refund_fee'] = $order['total_fee'];
                $refund['refund_time'] = time();
                $refund['buyer_uid'] = $order['buyer_uid'];
                $refund['seller_uid'] = $order['seller_uid'];
                $refund['shop_id'] = $order['shop_id'];
                $refund['refund_status'] = 1;
                $refund['order_id'] = $order_id;
                $refund['refund_no'] = createReundNo();

                (new OrderRefundModel())->data($refund)->add();
                $orderModel->where(array('order_id'=>$order_id))->data(array('refund_status'=>1))->save();

                $this->showSuccess('refund_apply_commited', null, array(
                    array('text'=>'go_back', 'url'=>U('m=member&c=order&a=index'))
                ));
            }
        }else {
            $item = (new OrderItemModel())->where(array('order_id'=>$order_id))->getOne();
            $shop = (new ShopModel())->where(array('shop_id'=>$order['shop_id']))->getOne();

            $_G['title'] = $_lang['apply_refund'];
            include template('apply_refund');
        }
    }
}