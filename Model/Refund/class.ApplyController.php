<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/12
 * Time: 下午4:13
 */

namespace Model\Refund;


class ApplyController extends BaseController
{
    /**
     *
     */
    public function index(){
        global $_G,$_lang;

        $order_id = intval($_GET['order_id']);
        $order = order_get_data(array('order_id'=>$order_id, 'buyer_uid'=>$this->uid, 'refund_status'=>0));
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
                $refund['refund_no'] = order_create_refund_no();

                order_add_refund($refund);
                order_update_data(array('order_id'=>$order_id),array('refund_status'=>1));
                $this->showSuccess('refund_apply_commited', null, array(
                    array('text'=>'go_back', 'url'=>U('m=member&c=order&a=index'))
                ));
            }
        }else {
            $item = order_get_item(array('order_id'=>$order_id));
            $shop = shop_get_data(array('shop_id'=>$order['shop_id']));

            $_G['title'] = $_lang['apply_refund'];
            include template('apply_refund');
        }
    }
}