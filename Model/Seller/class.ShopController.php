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

        $myshop = $this->shop;
        $owner  = shop_get_owner(array('owner_uid'=>$this->uid));
        $shop_info = shop_get_info(array('shop_id'=>$this->shop_id));
        $_G['title'] = '我的店铺';
        include template('shop_index');
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
}