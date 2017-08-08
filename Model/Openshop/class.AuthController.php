<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/2
 * Time: 上午9:46
 */
namespace Model\Openshop;
class AuthController extends BaseController{
    public function index(){
        global $_G,$lang;

        if ($this->checkFormSubmit()){
            if (!cookie('_formcode')){
                $this->showError('undefined_action');
            }else {
                cookie('_formcode', null);
                $owner = $_GET['owner'];
                if ($owner['owner_name'] && $owner['id_card_no'] && $owner['id_card_pic_1'] &&
                    $owner['id_card_pic_2'] && $owner['id_card_pic_3']){
                    $owner['owner_uid'] = $this->uid;
                    $owner['auth_status'] = 'PENDING';
                    $owner['auth_time'] = time();
                    if (shop_get_owner_count(array('owner_uid'=>$this->uid))){
                        shop_update_owner(array('owner_uid'=>$this->uid), $owner);
                    }else {
                        shop_add_owner($owner);
                    }
                    $this->redirect(U('m=openshop&c=shop'));
                }else {
                    $this->showError('invalid_parameter');
                }
            }
        }else {
            $owner = shop_get_owner(array('owner_uid'=>$this->uid));
            cookie('_formcode', md5(random(5)));
            $_G['title'] = '填写认证资料';
            include template('auth');
        }
    }
}