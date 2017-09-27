<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/7/31
 * Time: 下午4:52
 */
namespace Model\Seller;
class ShopController extends BaseController{
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
            if ($shop_data['shop_name'] && $shop_data['phone']){
                if ($this->shop_id){
                    $shop_data['update_time'] = time();
                    shop_update_data(array('shop_id'=>$this->shop_id), $shop_data);
                }else {
                    $shop_data['uid'] = $this->uid;
                    $shop_data['username'] = $this->username;
                    $shop_data['create_time'] = time();
                    $shop_data['auth_status'] = 'PENDING';
                    $shop_data['closed'] = '1';
                    $this->shop_id = shop_add_data($shop_data);
                }

                $shopContent = htmlspecialchars($_GET['shopContent']);
                $res = shop_update_desc(array('shop_id'=>$this->shop_id), array('content'=>$shopContent, 'update_time'=>time()));
                if (!$res) {
                    shop_add_desc(array(
                        'uid'=>$this->uid,
                        'shop_id'=>$this->shop_id,
                        'content'=>$shopContent,
                        'update_time'=>time()
                    ));
                }
                $this->showSuccess('save_succeed');
            }else {
                $this->showError('invalid_parameter');
            }
        }else {
            $shop_data = $this->shop_data;
            $shop_desc = shop_get_desc(array('shop_id'=>$this->shop_id));
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

        if ($this->checkFormSubmit()){
            $auth = $_GET['auth'];
            if ($auth['owner_id'] && $auth['owner_name'] && $auth['id_card_pic_1'] &&
                $auth['id_card_pic_2'] && $auth['id_card_pic_3'] && $auth['license_pic'] && $auth['license_no']){
                $auth['update_time'] = time();
                $auth['auth_status'] = 'PENDING';
                $auth['shop_id'] = $this->shop_id;
                $res = shop_update_auth(array('uid'=>$this->uid), $auth);
                if (!$res) {
                    $auth['uid'] = $this->uid;
                    $auth['shop_id'] = $this->shop_id;
                    shop_add_auth($auth);
                }
                $this->showSuccess('auth_info_submit_success');
            }else {
                $this->showError('invalid_parameter');
            }
        }else {

            $auth = shop_get_auth(array('uid'=>$this->uid));
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

        if ($data) shop_update_data(array('owner_uid'=>$this->uid), $data);
        $this->showAjaxReturn();
    }

    /**
     * 店铺实时数据
     */
    public function live_data(){
        global $_G,$_lang;

        $shop = shop_get_data(array('uid'=>$this->uid));
        $item_count = item_get_count(array('shop_id'=>$shop['shop_id'], 'on_sale'=>1));
        $order_count = order_get_count(array('shop_id'=>$shop['shop_id']));
        $payer_count = trade_get_count(array('payee_uid'=>$this->uid, 'trade_status'=>'PAID'));
        $data = M('trade')->field('SUM(trade_fee) AS total_income')->where(array('payee_uid'=>$this->uid, 'trade_status'=>'PAID'))->getOne();
        $total_income = floatval($data['total_income']);
        include template('shop_live_data');
    }
}