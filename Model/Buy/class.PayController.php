<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/8
 * Time: 下午2:32
 */
namespace Model\Buy;
use Data\Member\MemberModel;
use Data\Trade\OrderModel;
use Data\Trade\TradeModel;
use Data\Trade\WalletModel;
use Payment\AliPay\AlipayClient;
use Payment\AliPay\Builder\AlipayTradePagePayContentBuilder;
use Payment\AliPay\Builder\AlipayTradeQueryContentBuilder;
use Payment\WxPay\WxPayApi;
use Payment\WxPay\WxNativePay;
use Payment\WxPay\WxPayOrderQuery;
use Payment\WxPay\WxPayUnifiedOrder;

class PayController extends BaseController{
    /**
     * 订单付款
     */
    public function index(){
        global $_G,$_lang;

        $order = array();
        $order_id = intval($_GET['order_id']);
        $orderModel = new OrderModel();
        if ($order_id) {
            $order = $orderModel->where(array('order_id'=>$order_id))->getOne();
        }elseif ($_GET['order_no']) {
            $order = $orderModel->where(array('order_no'=>trim($_GET['order_no'])))->getOne();
        }

        //订单不存在或订单状态不匹配
        if (!$order){
            $this->showError('cannot_complete_payment');
        }
        if ($order['pay_status'] != 0){
            $this->redirect(U('c=pay&a=order_query&order_id='.$order_id));
        }else {
            $wallet = (new WalletModel())->getWallet($this->uid);

            $_G['step'] = 'pay_order';
            $_G['title'] = $_lang['pay_order'];
            include template('pay');
        }
    }

    /**
     *
     */
    public function order_query(){
        global $_G,$_lang;

        $order = $trade = array();
        $order_id = intval($_GET['order_id']);
        $orderModel = new OrderModel();
        if ($order_id) {
            $order = $orderModel->where(array('order_id'=>$order_id))->getOne();
        }elseif ($_GET['order_no']) {
            $order = $orderModel->where(array('order_no'=>trim($_GET['order_no'])))->getOne();
        }

        $_G['step'] = 'pay_order';
        $_G['title'] = $_lang['pay_result'];
        include template('order_query');
    }

    /**
     * 余额支付
     */
    public function balance_pay(){
        if ($_GET['formhash'] !== formhash()){
            $this->showAjaxError('FAIL', 'cannot_complete_payment');
        }

        $password = trim($_GET['password']);
        $member = (new MemberModel())->where(array('uid'=>$this->uid))->field('password')->getOne();
        if ($member['password'] !== getPassword($password)){
            $this->showAjaxError('FAIL','password_incorrect');
        }

        $order_id = intval($_GET['order_id']);
        $orderModel = new OrderModel();
        $tradeModel = new TradeModel();
        $order = $orderModel->where(array('order_id'=>$order_id))->getOne();
        if ($order['pay_status'] != 0){
            $this->showAjaxError('FAIL', 'order_have_been_paid');
        }

        if ((new WalletModel())->deduction($this->uid, $order['total_fee'])){
            $orderModel->where(array('order_id'=>$order_id))->data(array('pay_status'=>1, 'pay_type'=>1, 'pay_time'=>time()))->save();
            $tradeModel->where(array('trade_no'=>$order['trade_no']))->data(array('pay_status'=>1, 'pay_type'=>'balance'))->save();
            $this->showAjaxReturn();
        }else {
            $this->showAjaxError('FAIL', 'balance_not_enough');
        }
    }

    /**
     *
     */
    public function wxpay_qrcode(){
        include LIB_PATH.'Vendor/phpqrcode.php';

        $order = array();
        $order_id = intval($_GET['order_id']);
        if ($order_id) {
            $order = (new OrderModel())->where(array('order_id'=>$order_id))->getOne();
        }elseif ($_GET['order_no']) {
            $order = (new OrderModel())->where(array('order_no'=>trim($_GET['order_no'])))->getOne();
        }
        $trade = (new TradeModel())->where(array('trade_no'=>$order['trade_no']))->getOne();

        $unifiedOrder = new WxPayUnifiedOrder();
        $unifiedOrder->setProduct_id($trade['trade_id']);
        $unifiedOrder->setBody($trade['trade_name']);
        //$unifiedOrder->setTotal_fee(1);
        $unifiedOrder->setTotal_fee($trade['trade_fee'] * 100);
        $unifiedOrder->setNotify_url(U('m=buy&c=notify&a=wxpay'));
        $unifiedOrder->setOut_trade_no($trade['trade_no']);

        $nativePay = new WxNativePay();
        $res = $nativePay->getPayUrl($unifiedOrder);
        if ($res['return_code'] == 'SUCCESS' && $res['result_code'] == 'SUCCESS'){
            cookie('code_url', authcode($res['code_url']));
            \QRcode::png($res['code_url'], false, QR_ECLEVEL_H, 10);
        }else {
            print_array($res);
        }
    }

    /**
     * 查询微信支付结果
     */
    public function wxpay_query(){
        $order_id = intval($_GET['order_id']);
        $order = $trade = array();
        $orderModel = new OrderModel();
        $tradeModel = new TradeModel();
        if ($order_id) {
            $order = $orderModel->where(array('order_id'=>$order_id, 'buyer_uid'=>$this->uid))->getOne();
        }elseif ($_GET['order_no']) {
            $order = $orderModel->where(array('order_no'=>trim($_GET['order_no']), 'buyer_uid'=>$this->uid))->getOne();
        }

        $trade = $tradeModel->where(array('trade_no'=>$order['trade_no'], 'payer_uid'=>$this->uid))->getOne();
        if ($order['pay_status'] == 0){
            $orderQuery = new WxPayOrderQuery();
            $orderQuery->setOut_trade_no($trade['out_trade_no']);
            $res = WxPayApi::orderQuery($orderQuery);
            if ($res['trade_state'] == 'SUCCESS'){
                $orderModel->where(array('order_id'=>$order_id))->data(array('pay_status'=>1, 'pay_type'=>1, 'pay_time'=>time()))->save();
                $tradeModel->where(array('trade_no'=>$order['trade_no']))->data(array('pay_status'=>'1', 'pay_type'=>'wxpay'))->save();
            }
        }
        $this->showAjaxReturn();
    }

    /**
     * 支付宝支付
     */
    public function alipay(){
        if ($_GET['sign'] && $_GET['trade_no'] && $_GET['out_trade_no']){
            $trade_no = htmlspecialchars($_GET['trade_no']);
            $out_trade_no = htmlspecialchars($_GET['out_trade_no']);

            $orderModel = new OrderModel();
            $order = $orderModel->where(array('trade_no'=>$out_trade_no))->getOne();
            if ($order['pay_status'] == 0){
                if ($this->alipayCheckOrder($out_trade_no, $trade_no)){
                    //支付成功
                    $out_trade_no = htmlspecialchars($_GET['out_trade_no']);
                    $orderModel->where(array('trade_no'=>$out_trade_no))->data(array('pay_status'=>1,'pay_type'=>2, 'pay_time'=>time()))->save();
                    $tradeModel = new TradeModel();
                    $tradeModel->where(array('trade_no'=>$out_trade_no))->data(array('pay_status'=>'1', 'pay_type'=>'alipay'))->save();
                    $this->redirect(U('c=pay&a=order_query&order_id='.$order['order_id']));
                }
            }
        }else {
            $order_id = intval($_GET['order_id']);
            $order = $trade = array();
            $orderModel = new OrderModel();
            $tradeModel = new TradeModel();
            if ($order_id) {
                $order = $orderModel->where(array('order_id'=>$order_id))->getOne();
            }elseif ($_GET['order_no']) {
                $order = $orderModel->where(array('order_no'=>trim($_GET['order_no'])))->getOne();
            }
            //已支付订单直接跳转
            if ($order['pay_status'] != 0){
                $this->redirect(U('c=pay&a=order_query&order_id='.$order_id));
            }

            $trade = $tradeModel->where(array('trade_no'=>$order['trade_no']))->getOne();
            //创建支付实例
            $client = new AlipayClient();
            //创建支付订单
            $content = new AlipayTradePagePayContentBuilder();
            $content->setOut_trade_no($trade['trade_no']);
            $content->setTotal_amount($trade['trade_fee']);
            //$content->setTotal_amount(0.1);
            $content->setSubject($trade['trade_name']);
            $content->setBody($trade['trade_desc']);
            //创建支付请求
            $request = new \AlipayTradePagePayRequest();
            $request->setReturnUrl(curPageURL());
            $request->setNotifyUrl(getSiteURL().'/index.php?m=buy&c=nofity&a=alipay');
            $request->setBizContent($content->getBizContent());
            //发送支付请求
            echo $client->pageExecute($request);
            exit();
        }
    }

    /**
     * 查询支付结果
     */
    public function alipay_query(){
        $order_id = intval($_GET['order_id']);

        $orderModel = new OrderModel();
        $order = $orderModel->where(array('order_id'=>$order_id, 'buyer_uid'=>$this->uid))->getOne();
        $out_trade_no = $order['trade_no'];
        if ($order['pay_status'] == 0){
            if ($this->alipayCheckOrder($out_trade_no)){
                //支付成功
                $orderModel->where(array('trade_no'=>$out_trade_no))->data(array('pay_status'=>1, 'pay_type'=>1, 'pay_time'=>time()))->save();
                $tradeModel = new TradeModel();
                $tradeModel->where(array('trade_no'=>$out_trade_no))->data(array('pay_status'=>1, 'pay_type'=>'alipay'))->save();
            }
        }
        $this->redirect(U('c=pay&a=order_query&order_id='.$order['order_id']));
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