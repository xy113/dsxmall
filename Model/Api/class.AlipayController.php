<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/13
 * Time: 下午12:35
 */

namespace Model\Api;

use Data\Trade\OrderModel;
use Data\Trade\TradeModel;
use Payment\AliPay\AlipayClient;
use Payment\AliPay\Builder\AlipayTradeAppPayContentBuilder;
use Payment\AliPay\Builder\AlipayTradeQueryContentBuilder;

class AlipayController extends BaseController
{

    /**
     * 获取APP支付字符串
     */
    public function get_trade_content(){
        $order = $trade = array();
        $order_id = intval($_GET['order_id']);
        $orderModel = new OrderModel();
        if ($order_id) {
            $order = $orderModel->where(array('order_id'=>$order_id))->getOne();
        }elseif ($_GET['order_no']) {
            $order = $orderModel->where(array('order_no'=>trim($_GET['order_no'])))->getOne();
        }
        if (!$order) {
            $this->showAjaxError(1, '订单不存在');
        }
        if ($order['pay_status']) {
            $this->showAjaxError(2, '订单已支付，不能重复支付');
        }

        $tradeModel = new TradeModel();
        $trade = $tradeModel->where(array('trade_no'=>$order['trade_no']))->getOne();

        $client = new AlipayClient();
        $content = new AlipayTradeAppPayContentBuilder();
        $content->setOut_trade_no($trade['trade_no']);
        $content->setBody($trade['trade_desc']);
        $content->setSubject($trade['trade_name']);
        $content->setTotal_amount($trade['trade_fee']);

        $params = array(
            'app_id'=>setting('alipay_appid'),
            'method'=>'alipay.trade.app.pay',
            'format'=>'JSON',
            'charset'=>'utf-8',
            'sign_type'=>'RSA2',
            'timestamp'=>date('Y-m-d H:i:s'),
            'version'=>'1.0',
            'notify_url'=>rawurlencode(curPageURL()),
            'biz_content'=>$content->getBizContent()
        );
        ksort($params);
        $params['sign'] = $client->generateSign($params, 'RSA2');
        $this->showAjaxReturn(array('payStr'=>http_build_query($params)));

    }

    /**
     * 查询支付结果
     */
    public function query(){
        ignore_user_abort(true);
        $order_id = intval($_GET['order_id']);

        $orderModel = new OrderModel();
        $tradeModel = new TradeModel();
        $order = $orderModel->where(array('order_id'=>$order_id))->getOne();
        //订单已支付
        if ($order['pay_status']) $this->showAjaxReturn();

        $out_trade_no = $order['trade_no'];
        if ($this->alipayCheckOrder($out_trade_no)){
            //支付成功
            $orderModel->where(array('trade_no'=>$out_trade_no))->data(array('pay_status'=>1, 'pay_type'=>1, 'pay_time'=>time()))->save();
            $tradeModel->where(array('trade_no'=>$out_trade_no))->data(array('trade_status'=>'PAID', 'pay_type'=>'alipay'))->save();
            $this->showAjaxReturn();
        }else {
            $this->showAjaxError(1, '订单支付失败');
        }
    }

    /**
     * 验证订单支付状态
     */
    private function alipayCheckOrder($out_trade_no, $trade_no=null){
        //创建支付实例
        $client = new AlipayClient();
        //创建查询订单
        $content = new AlipayTradeQueryContentBuilder();
        $content->setOut_trade_no($out_trade_no);
        if (!is_null($trade_no)) $content->setTrade_no($trade_no);

        $request = new \AlipayTradeQueryRequest();
        $request->setBizContent($content->getBizContent());
        $result = $client->execute($request);
        //var_dump($result);exit();
        $msg = strtoupper($result->alipay_trade_query_response->msg);
        $status = strtoupper($result->alipay_trade_query_response->trade_status);
        if ($status == 'TRADE_SUCCESS' && $msg == 'SUCCESS'){
            return true;
        }else {
            return false;
        }
    }
}