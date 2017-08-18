<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/14
 * Time: 下午12:33
 */
namespace Model\Home;
use Payment\AliPay\AlipayClient;
use Payment\AliPay\AlipayTradeOrder;

class PaymentController extends BaseController{
    /**
     *
     */
    public function index(){
        /*
        $payOrder = new AliPayOrder();
        $payOrder->setOut_trade_no('1234567');
        $payOrder->setTotal_fee(1);
        $payOrder->setSubject('测试订单');
        $payOrder->setBody('测试订单');

        $alipay = new AliPay();
        $alipay->setReturn_url(urlencode(curPageURL()));
        $alipay->setNotify_url(urlencode(curPageURL()));
        $alipay->submit($payOrder);
        */
        $client = new AlipayClient();

        $order = new AlipayTradeOrder();
        $order->setOut_trade_no('20150320010101003');
        $order->setTotal_amount("0.1");
        $order->setSubject("Iphone7 32G");
        $order->setBody("Iphone7 32G");

        $request = new \AlipayTradePagePayRequest();
        $request->setReturnUrl(getSiteURL());
        $request->setNotifyUrl(getSiteURL());
        $request->setBizContent($order->getBizContent());

        //请求
        $result = $client->pageExecute ($request);

        //输出
        echo $result;
    }
}