<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/2
 * Time: 上午9:49
 */
namespace Model\Openshop;
class ShopController extends BaseController{
    /**
     * 填写店铺资料
     */
    public function index(){
        global $_G, $_lang;

        $shop = shop_get_data(array('owner_uid'=>$this->uid));
        if ($shop['auth_status'] == 'SUCCESS'){
            $this->redirect(U('m=seller&c=index'));
        }

        cookie('_formcode', md5(time()));
        $_G['title'] = '填写店铺资料';
        include template('shop');
    }

    /**
     * 保存店铺信息
     */
    public function save(){
        //防止重复提交
        if (!cookie('_formcode')) {
            $this->showError('donot_repeat_submit');
        }else {
            cookie('_formcode', null);
        }
        //判断是否本站提交
        if ($this->checkFormSubmit()){
            $shop = $_GET['shop'];
            $shop_info = $_GET['shop_info'];
            if ($this->myshop) {
                $shop_id = $this->myshop['shop_id'];
                shop_update_data(array('shop_id'=>$shop_id), $shop);
            }else {
                $shop['owner_uid']   = $this->uid;
                $shop['owner_username'] = $this->username;
                $shop['create_time'] = time();
                $shop['shop_type']   = 2;
                $shop['auth_status'] = 'PENDING';
                $shop['shop_status'] = 'CLOSE';
                $shop_id = shop_add_data($shop);
            }
            if (shop_get_info(array('shop_id'=>$shop_info))){
                shop_update_info(array('shop_id'=>$shop_id), $shop_info);
            }else {
                $shop_info['shop_id'] = $shop_id;
                shop_add_info($shop_info);
            }
            $this->showSuccess('shop_create_succeed', null, array(
                array('text'=>'go_back', 'url'=>U('m=openshop&c=index')),
                array('text'=>'back_home', 'url'=>U())
            ));
        }else {
            $this->showError('undefined_action');
        }
    }
}