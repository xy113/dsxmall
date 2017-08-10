<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/7
 * Time: 下午12:09
 */
namespace Model\Buy;
class OrderController extends BaseController{
    /**
     * 购买确认
     */
    public function index(){

    }

    /**
     * 立即购买
     */
    public function buy_now(){
        global $_G,$_lang;

        $goods_id = intval($_GET['goods_id']);
        $goods_number = intval($_GET['goods_number']);
        $shipping_type = intval($_GET['shipping_type']);
        $pay_type = intval($_GET['pay_type']);
        if ($goods_id && $goods_number) {
            $goods = goods_get_item(array('id'=>$goods_id));
            $shop  = shop_get_data(array('shop_id'=>$goods['shop_id']));
        } else{
            $this->showError('can_not_buy');
        }

        if ($this->checkFormSubmit()) {
            //防止重复提交
            if ($_GET['_token_'] !== cookie('_token_')){
                $this->showError('can_not_buy');
            }else {
                cookie('_token_', null);
            }

            $trade_no = trade_create_no();
            $order_no = order_create_no($this->uid);
            //卖家信息
            $seller   = member_get_data(array('uid'=>$goods['uid']), 'uid,username');
            //收货地址
            $address  = address_get_data(array('id'=>intval($_GET['address_id'])));
            //订单金额
            $order_fee = floatval($goods['goods_price']) * $goods_number;
            //运费
            $shipping_fee = 0;
            //总金额
            $total_fee = $order_fee + $shipping_fee;
            //创建订单
            $order_id = order_add_item(array(
                'uid'=>$this->uid,
                'seller_uid'=>$seller['uid'],
                'seller_username'=>$seller['username'],
                'shop_id'=>$shop['shop_id'],
                'shop_name'=>$shop['shop_name'],
                'order_no'=>$order_no,
                'order_fee'=>$order_fee,
                'shipping_fee'=>$shipping_fee,
                'total_fee'=>$total_fee,
                'create_time'=>time(),
                'pay_type'=>$pay_type,
                'shipping_type'=>$shipping_type,
                'order_status'=>0,
                'pay_status'=>0,
                'evaluate_status'=>0,
                'shipping_status'=>0,
                'consignee'=>$address['consignee'],
                'phone'=>$address['phone'],
                'address'=>$address['province'].$address['city'].$address['county'].$address['street'].' '.$address['postcode'],
                'trade_no'=>$trade_no,
                'order_remark'=>trim($_GET['remark'])
            ));
            //记录订单商品信息
            order_add_goods(array(
                'uid'=>$this->uid,
                'order_id'=>$order_id,
                'goods_id'=>$goods['id'],
                'goods_name'=>$goods['goods_name'],
                'market_price'=>$goods['market_price'],
                'goods_price'=>$goods['goods_price'],
                'goods_number'=>$goods_number,
                'goods_thumb'=>$goods['goods_thumb'],
                'goods_image'=>$goods['goods_image']
            ));
            //创建订单操作记录
            order_add_action(array(
                'uid'=>$this->uid,
                'username'=>$this->username,
                'order_id'=>$order_id,
                'action_name'=>L('checkout_success'),
                'action_time'=>time()
            ));
            //创建支付流水
            trade_add_data(array(
                'uid'=>$this->uid,
                'payee_uid'=>$seller['uid'],
                'payee_name'=>$seller['username'],
                'trade_no'=>$trade_no,
                'trade_name'=>$goods['goods_name'],
                'trade_desc'=>$goods['goods_name'],
                'trade_fee'=>$total_fee,
                'trade_type'=>'SHOPPING',
                'trade_status'=>'UNPAID',
                'trade_time'=>time()
            ));
            goods_update_item(array('id'=>$goods_id), "`sold`=`sold`+$goods_number");
            shop_update_data(array('shop_id'=>$shop['shop_id']), "`total_sold`=`total_sold`+$goods_number");
            $this->redirect(U('c=pay&order_id='.$order_id));
        }else {
            cookie('_token_', md5_16(random(10)));
            $total_fee = floatval($goods['goods_price']) * $goods_number;

            $_G['title'] = $_lang['confirm_order'];
            include template('buy_now');
        }
    }

    /**
     * 购物车结算
     */
    public function confirm_order(){
        global $_G,$_lang;

        $goods_id = intval($_GET['goods_id']);
        $goods_number = intval($_GET['goods_number']);
        $shipping_type = intval($_GET['shipping_type']);
        $pay_type = intval($_GET['pay_type']);

        $goods = goods_get_item(array('id'=>$goods_id));
        $shop  = shop_get_data(array('shop_id'=>$goods['shop_id']));
        $total_fee = floatval($goods['goods_price']) * $goods_number;

        $_G['title'] = $_lang['confirm_order'];
        $_G['step'] = 'confirm_order';
        include template('confirm_order');
    }

    /**
     *
     */
    public function create_order(){
        if (trim($_GET['formhash']) !== formhash()){
            $this->showError('can_not_buy');
        }

        print_array($_GET);exit();
    }
}