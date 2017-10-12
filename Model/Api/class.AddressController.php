<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/5
 * Time: 上午10:33
 */
namespace Model\Api;
use Data\Member\AddressModel;

class AddressController extends BaseController{
    /**
     *
     */
    public function index(){

    }

    /**
     * 添加收货地址
     */
    public function add(){
        $cosignee = htmlspecialchars($_GET['consignee']);
        $phone = trim($_GET['phone']);
        $province = trim($_GET['province']);
        $city = trim($_GET['city']);
        $county = trim($_GET['county']);
        $street = htmlspecialchars($_GET['street']);
        if ($cosignee && $phone) {
            $model = new AddressModel();
            $address_id = $model->data(array(
                'uid'=>$this->uid,
                'consignee'=>$cosignee,
                'phone'=>$phone,
                'province'=>$province,
                'city'=>$city,
                'county'=>$county,
                'street'=>$street
            ))->add();
            $this->showAjaxReturn(array('address_id'=>$address_id));
        }else {
            $this->showAjaxError(1, 'invalid_parameter');
        }
    }

    /**
     * 更新收货地址
     */
    public function update(){
        $address_id = intval($_GET['address_id']);
        if (!$address_id) $address_id = intval($_GET['id']);
        $cosignee = htmlspecialchars($_GET['consignee']);
        $phone = trim($_GET['phone']);
        $province = trim($_GET['province']);
        $city = trim($_GET['city']);
        $county = trim($_GET['county']);
        $street = htmlspecialchars($_GET['street']);
        if ($cosignee && $phone) {
            $model = new AddressModel();
            $model->where(array('address_id'=>$address_id, 'uid'=>$this->uid))->data(array(
                'consignee'=>$cosignee,
                'phone'=>$phone,
                'province'=>$province,
                'city'=>$city,
                'county'=>$county,
                'street'=>$street
            ))->save();
            $this->showAjaxReturn();
        }else {
            $this->showAjaxError(1, 'invalid_parameter');
        }
    }

    /**
     * 删除地址
     */
    public function delete(){
        $address_id = intval($_GET['address_id']);
        if (!$address_id) $address_id = intval($_GET['id']);
        (new AddressModel())->where(array('address_id'=>$address_id, 'uid'=>$this->uid))->delete();
        $this->showAjaxReturn();
    }

    /**
     * 设置默认地址
     */
    public function setdefault(){
        $address_id = intval($_GET['address_id']);
        if (!$address_id) $address_id = intval($_GET['id']);
        $model = new AddressModel();
        $model->where(array('uid'=>$this->uid))->data(array('isdefault'=>0))->save();
        $model->where(array('uid'=>$this->uid, 'address_id'=>$address_id))->data(array('isdefault'=>1))->save();
        $this->showAjaxReturn();
    }

    /**
     * 获取收货地址
     */
    public function get(){
        $address_id = intval($_GET['address_id']);
        $model = new AddressModel();
        if ($address_id) {
            $address = $model->where(array('address_id'=>$address_id, 'uid'=>$this->uid))->getOne();
        }else {
            $address = $model->where(array('isdefault'=>1, 'uid'=>$this->uid))->getOne();
        }
        if ($address) {
            $address['id'] = $address['address_id'];//兼容老版本
            $address['address'] = $address['province'].$address['city'].$address['county'].$address['street'];
        }else {
            $address = array();
        }
        $this->showAjaxReturn($address);
    }

    /**
     * 批量获取收货地址
     */
    public function batchget(){
        $addresslist = array();
        foreach ((new AddressModel())->where(array('uid'=>$this->uid))->select() as $address){
            $address['id'] = $address['address_id'];//兼容老版本
            $address['address'] = $address['province'].$address['city'].$address['county'].$address['street'];
            $addresslist[] = $address;
        }
        $this->showAjaxReturn($addresslist);
    }
}