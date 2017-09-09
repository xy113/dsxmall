<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/5
 * Time: 上午10:33
 */
namespace Model\Api;
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
            address_add_data(array(
                'uid'=>$this->uid,
                'consignee'=>$cosignee,
                'phone'=>$phone,
                'province'=>$province,
                'city'=>$city,
                'county'=>$county,
                'street'=>$street
            ));
            $this->showAjaxReturn();
        }else {
            $this->showAjaxError(1, 'invalid_parameter');
        }
    }

    /**
     * 更新收货地址
     */
    public function update(){
        $id = intval($_GET['id']);
        $cosignee = htmlspecialchars($_GET['consignee']);
        $phone = trim($_GET['phone']);
        $province = trim($_GET['province']);
        $city = trim($_GET['city']);
        $county = trim($_GET['county']);
        $street = htmlspecialchars($_GET['street']);
        if ($cosignee && $phone) {
            address_update_data(array('id'=>$id, 'uid'=>$this->uid), array(
                'consignee'=>$cosignee,
                'phone'=>$phone,
                'province'=>$province,
                'city'=>$city,
                'county'=>$county,
                'street'=>$street
            ));
            $this->showAjaxReturn();
        }else {
            $this->showAjaxError(1, 'invalid_parameter');
        }
    }

    public function delete(){
        $id = intval($_GET['id']);
        address_delete_data(array('id'=>$id, 'uid'=>$this->uid));
        $this->showAjaxReturn();
    }

    /**
     * 设为默认地址
     */
    public function setdefault(){
        $id = intval($_GET['id']);
        address_update_data(array('uid'=>$this->uid), array('isdefault'=>0));
        address_update_data(array('uid'=>$this->uid, 'id'=>$id), array('isdefault'=>1));
        $this->showAjaxReturn();
    }

    /**
     * 获取收货地址
     */
    public function get(){
        $address_id = intval($_GET['address_id']);
        if ($address_id) {
            $address = address_get_data(array('id'=>$address_id, 'uid'=>$this->uid));
        }else {
            $address = address_get_data(array('isdefault'=>1, 'uid'=>$this->uid));
        }
        if ($address) {
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
        $address_list = address_get_list(array('uid'=>$this->uid));
        $datalist = array();
        foreach ($address_list as $address){
            $address['address'] = $address['province'].$address['city'].$address['county'].$address['street'];
            $datalist[] = $address;
        }
        $this->showAjaxReturn($datalist);
    }
}