<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/7
 * Time: 上午12:14
 */
namespace Model\Member;
class AddressController extends BaseController{
    function __construct()
    {
        parent::__construct();
        G('menu', 'address');
    }

    /**
     * 收货地址管理
     */
    public function index(){
        global $_G,$_lang;

        $address_id = intval($_GET['address_id']);
        if ($this->checkFormSubmit()){

            $address = $_GET['address'];
            if ($address['consignee'] && $address['phone'] && $address['street']){
                $address['isdefault'] = intval($address['isdefault']);
                if ($address['isdefault']) {
                    address_update_data(array('uid'=>$this->uid), array('isdefault'=>0));
                }
                if ($address_id) {
                    address_update_data(array('uid'=>$this->uid, 'address_id'=>$address_id), $address);
                }else {
                    $address['uid'] = $this->uid;
                    address_add_data($address);
                }
                $this->redirect(U('c=address&a=index'));
            }else {
                $this->showError('undefined_action');
            }
        }else {

            if ($address_id) $address = address_get_data(array('address_id'=>$address_id, 'uid'=>$this->uid));
            $itemlist = address_get_list(array('uid'=>$this->uid));

            $_G['title'] = $_lang['address_manage'];
            include template('address');
        }
    }

    /**
     * 设置默认地址
     */
    public function set_default(){
        $address_id = intval($_GET['address_id']);
        address_update_data(array('uid'=>$this->uid), array('isdefault'=>0));
        address_update_data(array('uid'=>$this->uid, 'address_id'=>$address_id), array('isdefault'=>1));
        $this->showAjaxReturn();
    }

    /**
     * 删除地址
     */
    public function delete(){
        $address_id = intval($_GET['address_id']);
        address_delete_data(array('uid'=>$this->uid, 'address_id'=>$address_id));
        $this->redirect(U('c=address&a=index'));
    }

    public function frame(){
        global $_G,$_lang;

        $address_id = intval($_GET['address_id']);
        if ($address_id) $address = address_get_data(array('address_id'=>$address_id, 'uid'=>$this->uid));
        include template('address_frame');
    }

    public function save(){
        $address = $_GET['address'];
        $address_id = intval($_GET['address_id']);
        if ($address['consignee'] && $address['phone'] && $address['street']){
            $address['isdefault'] = intval($address['isdefault']);
            if ($address['isdefault']) {
                address_update_data(array('uid'=>$this->uid), array('isdefault'=>0));
            }
            if ($address_id) {
                address_update_data(array('uid'=>$this->uid, 'address_id'=>$address_id), $address);
            }else {
                $address['uid'] = $this->uid;
                $address_id = address_add_data($address);
            }
            $this->showAjaxReturn(address_get_data(array('address_id'=>$address_id)));
        }else {
            $this->showAjaxError(1, L('undefined_action'));
        }
    }

    /**
     * 批量获取地址
     */
    public function batchget(){
        $itemlist = address_get_list(array('uid'=>$this->uid));
        $this->showAjaxReturn($itemlist);
    }
}