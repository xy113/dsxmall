<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/7/31
 * Time: 上午10:13
 */
namespace Model\Seller;
use Data\Post\PostItemModel;
use Data\Trade\OrderModel;
use Data\Trade\WalletModel;

class IndexController extends BaseController{
    /**
     *
     */
    public function index(){
        global $_G,$_lang;

        $shop_data = $this->shop_data;
        $wallet = (new WalletModel())->getWallet($this->uid);

        $orderModel = new OrderModel();
        $order_data['wait_pay'] = $orderModel->where(array('pay_status'=>0, 'shop_id'=>$this->shop_id))->count();
        $order_data['wait_send'] = $orderModel->where(array('pay_status'=>1, 'shipping_status'=>0, 'shop_id'=>$this->shop_id))->count();
        //卖家必读
        $postItemList = (new PostItemModel())->limit(0, 6)->select();

        $_G['title'] = '卖家中心';
        include template('index');
    }
}