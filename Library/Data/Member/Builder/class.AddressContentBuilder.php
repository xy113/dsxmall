<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/12
 * Time: 下午1:56
 */

namespace Data\Member\Builder;


use Core\Builder;

class AddressContentBuilder extends Builder
{
    protected $data = array(
        'address_id'=>'',
        'uid'=>'',
        'consignee'=>'',
        'phone'=>'',
        'province'=>'',
        'city'=>'',
        'county'=>'',
        'street'=>'',
        'postcode'=>'',
        'isdefault'=>''
    );

    /**
     * @param $value
     */
    public function setAddress_id($value){
        $this->data['address_id'] = $value;
    }

    /**
     * @return mixed
     */
    public function getAddress_id(){
        return $this->data['address_id'];
    }

    /**
     * @param $value
     */
    public function setUid($value){
        $this->data['uid'] = $value;
    }

    /**
     * @return mixed
     */
    public function getUid(){
        return $this->data['uid'];
    }

    /**
     * @param $value
     */
    public function setConsignee($value){
        $this->data['consignee'] = $value;
    }

    /**
     * @return mixed
     */
    public function getConsignee(){
        return $this->data['consignee'];
    }
}