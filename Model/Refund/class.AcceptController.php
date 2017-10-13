<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/12
 * Time: 下午4:28
 */

namespace Model\Refund;

use Data\Shop\ShopModel;
use Data\Trade\OrderItemModel;
use Data\Trade\OrderModel;
use Data\Trade\OrderRefundModel;
use Data\Trade\TradeModel;
use Data\Trade\WalletModel;
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
        $orderModel = new OrderModel();
        $order = $orderModel->where(array('order_id'=>$order_id, 'buyer_uid'=>$this->uid, 'refund_status'=>1))->getOne();
        if (!$order) {
            $this->showError('order_not_exists');
        }
        if ($order['pay_type'] != 1 || $order['pay_status'] != 1){
            $this->showError('order_can_not_refund');
        }

        $refundModel = new OrderRefundModel();
        if ($this->checkFormSubmit()){

            $refund_id = intval($_GET['refund_id']);
            $accept_type = intval($_GET['accept_type']);
            $reply_text = htmlspecialchars($_GET['reply_text']);
            if ($accept_type == 1){
                //同意退款
                $refund = $refundModel->where(array('refund_id'=>$refund_id))->getOne();
                $trade = (new TradeModel())->where(array('trade_no'=>$order['trade_no']))->getOne();
                $trade_no = createTradeNo();

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
                    (new WalletModel())->increase($refund['buyer_uid'], $refund['refund_fee']);
                }

                if ($refund_status) {
                    (new OrderModel())->where(array('seller_uid'=>$this->uid, 'order_id'=>$order_id))->data(array('refund_status'=>2))->save();
                    $refundModel->where(array('seller_uid'=>$this->uid, 'refund_id'=>$refund_id))
                        ->data(array('seller_accept_type'=>1,'seller_reply_text'=>$reply_text,'seller_accepted'=>1))->save();
                    (new TradeModel())->data(array(
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
                    ))->add();
                    $this->showSuccess('refund_accept_success');
                }else {
                    $this->showError('refund_fail');
                }

            }else {
                $refundModel->where(array('seller_uid'=>$this->uid, 'refund_id'=>$refund_id))
                    ->data(array('seller_accept_type'=>0,'seller_reply_text'=>$reply_text,'seller_accepted'=>1))->save();
                $this->showSuccess('refund_accept_success');
            }
        }else {
            $item = (new OrderItemModel())->where(array('order_id'=>$order_id))->getOne();
            $shop = (new ShopModel())->where(array('shop_id'=>$order['shop_id']))->getOne();
            $refund = $refundModel->where(array('order_id'=>$order_id,'seller_accepted'=>0, 'seller_uid'=>$this->uid))->getOne();

            $_G['title'] = $_lang['accept_refund'];
            include template('accept_refund');
        }
    }
}