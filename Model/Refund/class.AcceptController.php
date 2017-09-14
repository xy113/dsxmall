<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/12
 * Time: 下午4:28
 */

namespace Model\Refund;

use Payment\AliPay\AlipayClient;
use Payment\AliPay\Builder\AlipayTradeRefundContentBuilder;
use Payment\WxPay\WxPayApi;
use Payment\WxPay\WxPayRefund;

class AcceptController extends BaseController
{
    /**
     *
     */
    public function index(){
        global $_G,$_lang;

        $order_id = intval($_GET['order_id']);
        $order = order_get_data(array('order_id'=>$order_id, 'buyer_uid'=>$this->uid, 'refund_status'=>1));
        if (!$order) {
            $this->showError('order_not_exists');
        }
        if ($order['pay_type'] != 1 || $order['pay_status'] != 1){
            $this->showError('order_can_not_refund');
        }

        if ($this->checkFormSubmit()){

            $refund_id = intval($_GET['refund_id']);
            $accept_type = intval($_GET['accept_type']);
            $reply_text = htmlspecialchars($_GET['reply_text']);
            if ($accept_type == 1){
                //同意退款

                $refund = order_get_refund(array('refund_id'=>$refund_id));
                $trade = trade_get_data(array('trade_no'=>$order['trade_no']));
                $trade_no = trade_create_no();

                $refund_status = 0;
                if ($trade['pay_type'] == 'wxpay'){
                    //微信退款
                    $refundOrder = new WxPayRefund();
                    $refundOrder->setOut_trade_no($trade['trade_no']);
                    $refundOrder->setTotal_fee($trade['total_fee']*100);
                    $refundOrder->setOut_refund_no($trade_no);
                    $refundOrder->setRefund_fee($refund['refund_fee']*100);
                    $refundOrder->setRefund_desc($refund['refund_reason']);

                    $res = WxPayApi::refund($refundOrder);
                    if ($res['return_code'] == 'SUCCESS' && $res['result_code'] == 'SUCCESS'){
                        $refund_status = 1;
                    }else {
                        print_array($res);exit();
                    }
                }

                if ($trade['pay_type'] == 'alipay'){
                    //支付宝退款
                    $content = new AlipayTradeRefundContentBuilder();
                    $content->setOut_trade_no($trade['trade_no']);
                    $content->setRefund_amount($refund['refund_fee']);
                    $content->setRefund_reason($refund['refund_reason']);
                    $content->setOut_request_no($trade_no);

                    $request = new \AlipayTradeRefundRequest();
                    $request->setNotifyUrl(curPageURL());
                    $request->setReturnUrl(curPageURL());
                    $request->setBizContent($content->getBizContent());

                    $clinet = new AlipayClient();
                    $resObj = $clinet->execute($request);
                    $msg = strtoupper($resObj->alipay_trade_query_response->msg);
                    $status = strtoupper($resObj->alipay_trade_query_response->trade_status);
                    if ($status == 'TRADE_SUCCESS' && $msg == 'SUCCESS'){
                        $refund_status = 1;
                    }else {
                        var_dump($resObj);
                    }
                }

                if ($trade['trade_type'] == 'balance'){
                    $refund_status = 1;
                    wallet_income($refund['buyer_uid'], $refund['refund_fee']);
                }

                if ($refund_status) {
                    order_update_data(array('seller_uid'=>$this->uid, 'order_id'=>$order_id), array('refund_status'=>2));
                    order_update_refund(array('seller_uid'=>$this->uid, 'refund_id'=>$refund_id),array(
                        'seller_accept_type'=>1,'seller_reply_text'=>$reply_text,'seller_accepted'=>1
                    ));

                    trade_add_data(array(
                        'payer_uid'=>$trade['payee_uid'],
                        'payer_name'=>$trade['payee_name'],
                        'payee_uid'=>$trade['payer_uid'],
                        'payee_name'=>$trade['payer_name'],
                        'pay_type'=>$trade['pay_type'],
                        'trade_no'=>$trade_no,
                        'trade_name'=>$_lang['refund'],
                        'trade_desc'=>$trade['trade_desc'],
                        'trade_fee'=>$refund['refund_fee'],
                        'trade_type'=>'REFUND',
                        'trade_status'=>'PAID',
                        'trade_time'=>time(),
                        'out_trade_no'=>$trade_no
                    ));
                    $this->showSuccess('refund_accept_success');
                }else {
                    $this->showError('refund_fail');
                }

            }else {
                order_update_refund(array('seller_uid'=>$this->uid, 'refund_id'=>$refund_id),array(
                     'seller_accept_type'=>0,'seller_reply_text'=>$reply_text,'seller_accepted'=>1
                ));
                $this->showSuccess('refund_accept_success');
            }
        }else {
            $item = order_get_item(array('order_id'=>$order_id));
            $shop = shop_get_data(array('shop_id'=>$order['shop_id']));
            $refund = order_get_refund(array('order_id'=>$order_id,'seller_accepted'=>0, 'seller_uid'=>$this->uid));

            $_G['title'] = $_lang['accept_refund'];
            include template('accept_refund');
        }
    }
}