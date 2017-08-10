<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/8
 * Time: 下午2:32
 */
namespace Model\Buy;
class PayController extends BaseController{
    /**
     * 订单付款
     */
    public function index(){
        global $_G,$_lang;

        $order_id = intval($_GET['order_id']);
        if ($order_id) {
            $order = order_get_item(array('order_id'=>$order_id));
        }elseif ($_GET['order_no']) {
            $order = order_get_item(array('order_no'=>trim($_GET['order_no'])));
        }

        //订单不存在或订单状态不匹配
        if (!$order || $order['pay_status'] != 0){
            $this->showError('cannot_complete_payment');
        }
        $wallet = wallet_get_data($this->uid);

        $_G['step'] = 'pay_order';
        $_G['title'] = $_lang['pay_order'];
        include template('pay');
    }
}