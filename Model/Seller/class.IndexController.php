<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/7/31
 * Time: 上午10:13
 */
namespace Model\Seller;
class IndexController extends BaseController{
    /**
     *
     */
    public function index(){
        global $_G,$_lang;

        $shop_data = $this->shop_data;
        $wallet = wallet_get_data($this->uid);

        $order_data['wait_pay'] = order_get_count(array('pay_status'=>0, 'shop_id'=>$this->shop_id));
        $order_data['wait_send'] = order_get_count(array('pay_status'=>1, 'shipping_status'=>0, 'shop_id'=>$this->shop_id));
        $_G['title'] = '卖家中心';
        include template('index');
    }
}