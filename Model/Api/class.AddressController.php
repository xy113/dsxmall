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

    }

    /**
     * 更新收货地址
     */
    public function update(){

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