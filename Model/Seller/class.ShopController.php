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
            $shop = $_GET['shop'];
            if ($shop['shop_name'] && $shop['phone']){
                shop_update_data(array('shop_id'=>$this->shop_id), $shop);
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
            $shop = shop_get_data(array('shop_id'=>$this->shop_id));
            $desc = shop_get_desc(array('shop_id'=>$this->shop_id));
            $editorname = 'shopContent';
            $editorcontent = $desc['content'];
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

        }else {

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
}