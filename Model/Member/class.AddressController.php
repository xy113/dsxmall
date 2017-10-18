<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/7
 * Time: 上午12:14
 */
namespace Model\Member;
use Data\Member\AddressModel;
use Data\Member\Object\AddressObject;

class AddressController extends BaseController{
    /**
     * AddressController constructor.
     */
    function __construct()
    {
        parent::__construct();
        $this->var['menu'] = 'address';
    }

    /**
     * 收货地址管理
     */
    public function index(){
        global $_G,$_lang;

        $address_id = intval($_GET['address_id']);
        $model = new AddressModel();
        if ($this->checkFormSubmit()){

            $address = $_GET['address'];
            $object = (new AddressObject())->initWithData($address);
            if ($object->getConsignee() && $object->getPhone() && $object->getStreet()){
                $address['isdefault'] = intval($address['isdefault']);
                if ($address['isdefault']) {
                    $model->where(array('uid'=>$this->uid))->data(array('isdefault'=>0))->save();
                }
                if ($address_id) {
                    $model->where(array('uid'=>$this->uid, 'address_id'=>$address_id))->data($address)->save();
                }else {
                    $address['uid'] = $this->uid;
                    $model->data($address)->add();
                }
                $this->redirect(U('c=address&a=index'));
            }else {
                $this->showError('undefined_action');
            }
        }else {

            if ($address_id) $address = $model->where(array('address_id'=>$address_id, 'uid'=>$this->uid))->getOne();
            $itemlist = $model->where(array('uid'=>$this->uid))->select();

            $_G['title'] = $_lang['address_manage'];
            include template('address');
        }
    }

    /**
     * 设置默认地址
     */
    public function set_default(){
        $address_id = intval($_GET['address_id']);
        $model = new AddressModel();
        $model->where(array('uid'=>$this->uid))->data(array('isdefault'=>0))->save();
        $model->where(array('uid'=>$this->uid, 'address_id'=>$address_id))->data(array('isdefault'=>1))->save();
        $this->showAjaxReturn();
    }

    /**
     * 删除地址
     */
    public function delete(){
        $address_id = intval($_GET['address_id']);
        (new AddressModel())->where(array('uid'=>$this->uid, 'address_id'=>$address_id))->delete();
        $this->showAjaxReturn();
    }

    public function frame(){
        global $_G,$_lang;

        $address_id = intval($_GET['address_id']);
        if ($address_id) $address = (new AddressModel())->where(array('address_id'=>$address_id, 'uid'=>$this->uid))->getOne();
        include template('address_frame');
    }

    public function save(){
        $address = $_GET['address'];
        $address_id = intval($_GET['address_id']);
        if ($address['consignee'] && $address['phone'] && $address['street']){
            $address['isdefault'] = intval($address['isdefault']);

            $model = new AddressModel();
            if ($address['isdefault']) {
                $model->where(array('uid'=>$this->uid))->data(array('isdefault'=>0))->save();
            }
            if ($address_id) {
                $model->where(array('uid'=>$this->uid, 'address_id'=>$address_id))->data($address)->save();
            }else {
                $address['uid'] = $this->uid;
                $address_id = $model->data($address)->add();
            }
            $this->showAjaxReturn($model->where(array('address_id'=>$address_id))->getOne());
        }else {
            $this->showAjaxError(1, L('undefined_action'));
        }
    }

    /**
     * 批量获取地址
     */
    public function batchget(){
        $itemlist = (new AddressModel())->where(array('uid'=>$this->uid))->select();
        $this->showAjaxReturn($itemlist);
    }
}