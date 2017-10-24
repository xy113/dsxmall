<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/7/31
 * Time: 下午4:52
 */
namespace Model\Seller;
use Data\Item\ItemModel;
use Data\Shop\ShopAuthModel;
use Data\Shop\ShopDescModel;
use Data\Shop\ShopModel;
use Data\Trade\OrderModel;
use Data\Trade\TradeModel;

class ShopController extends BaseController{
    /**
     * ShopController constructor.
     */
    function __construct()
    {
        parent::__construct();
        $_GET['menu'] = 'shop_set';
    }

    /**
     * 店铺首页
     */
    public function index(){
        global $_G,$_lang;

        if ($this->checkFormSubmit()){
            $shop_data = $_GET['shop_data'];
            $shopModel = new ShopModel();
            if ($shop_data['shop_name'] && $shop_data['phone']){
                if ($this->shop_id){
                    $shop_data['update_time'] = time();
                    $shopModel->where(array('shop_id'=>$this->shop_id))->data($shop_data)->save();
                }else {
                    $shop_data['uid'] = $this->uid;
                    $shop_data['username'] = $this->username;
                    $shop_data['create_time'] = time();
                    $shop_data['auth_status'] = 'PENDING';
                    $shop_data['closed'] = '1';
                    $this->shop_id = $shopModel->data($shop_data)->add();
                }

                $descModel = new ShopDescModel();
                $shopContent = trim($_GET['shopContent']);
                $res = $descModel->where(array('shop_id'=>$this->shop_id, 'uid'=>$this->uid))
                    ->data(array('content'=>$shopContent, 'update_time'=>time()))->save();
                if (!$res) {
                    $descModel->data(array(
                        'uid'=>$this->uid,
                        'shop_id'=>$this->shop_id,
                        'content'=>$shopContent,
                        'update_time'=>time()
                    ))->add();
                }
                $this->showSuccess('save_succeed');
            }else {
                $this->showError('invalid_parameter');
            }
        }else {
            $shop_data = $this->shop_data;
            $shop_desc = (new ShopDescModel())->where(array('shop_id'=>$this->shop_id))->getOne();
            $editorname = 'shopContent';
            $editorcontent = $shop_desc['content'];
            $_G['title'] = '我的店铺';
            include template('shop_index');
        }
    }

    /**
     * 店铺认证
     */
    public function auth(){
        global $_G,$_lang;

        $authModel = new ShopAuthModel();
        if ($this->checkFormSubmit()){
            $auth = $_GET['auth'];
            if ($auth['owner_id'] && $auth['owner_name'] && $auth['id_card_pic_1'] &&
                $auth['id_card_pic_2'] && $auth['id_card_pic_3'] && $auth['license_pic'] && $auth['license_no']){
                $auth['update_time'] = time();
                $auth['auth_status'] = 'PENDING';
                $auth['shop_id'] = $this->shop_id;
                $res = $authModel->where(array('uid'=>$this->uid))->data($auth)->save();
                if (!$res) {
                    $auth['uid'] = $this->uid;
                    $auth['shop_id'] = $this->shop_id;
                    $authModel->data($auth)->add();
                }
                $this->showSuccess('auth_info_submit_success');
            }else {
                $this->showError('invalid_parameter');
            }
        }else {

            $auth = $authModel->where(array('uid'=>$this->uid))->getOne();
            $_G['title'] = '店铺认证';
            include template('shop_auth');
        }
    }

    /**
     * 修改店铺信息
     */
    public function update_shop(){
        $data = array();
        if ($_GET['shop_name']) $data['shop_name'] = htmlspecialchars($_GET['shop_name']);
        if ($_GET['phone']) $data['phone'] = trim($_GET['phone']);

        if ($data) (new ShopModel())->where(array('owner_uid'=>$this->uid))->data($data)->save();
        $this->showAjaxReturn();
    }

    /**
     * 店铺实时数据
     */
    public function live_data(){
        global $_G,$_lang;

        $shop = (new ShopModel())->where(array('uid'=>$this->uid))->getOne();
        $item_count = (new ItemModel())->where(array('shop_id'=>$shop['shop_id'], 'on_sale'=>1))->count();
        $order_count = (new OrderModel())->where(array('shop_id'=>$shop['shop_id']))->count();

        $tradeModel = new TradeModel();
        $payer_count = $tradeModel->where(array('payee_uid'=>$this->uid, 'pay_status'=>1))->count();
        $data = $tradeModel->field('SUM(trade_fee) AS total_income')->where(array('payee_uid'=>$this->uid, 'trade_status'=>'PAID'))->getOne();
        $total_income = floatval($data['total_income']);
        include template('shop_live_data');
    }
}