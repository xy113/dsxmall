<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午10:55
 */

namespace Data\Shop\Builder;


use Core\Builder;

class ShopAuthContentBuilder extends Builder
{
    protected $data = array(
        'id'=>'',
        'uid'=>'',
        'shop_id'=>'',
        'owner_id'=>'',
        'owner_name'=>'',
        'id_card_pic_1'=>'',
        'id_card_pic_2'=>'',
        'id_card_pic_3'=>'',
        'license_no'=>'',
        'license_pic'=>'',
        'other_card_pic'=>'',
        'business_scope'=>'',
        'auth_status'=>'',
        'auth_time'=>'',
        'update_time'=>''
    );

    public function setId($value){
        $this->data['id'] = $value;
    }

    public function getId(){
        return $this->data['id'];
    }

    public function setUid($value){
        $this->data['uid'] = $value;
    }

    public function getUid(){
        return $this->data['uid'];
    }

    public function setOwner_id($value){
        $this->data['owner_id'] = $value;
    }

    public function getOwner_id(){
        return $this->data['owner_id'];
    }

    public function setOwner_name($value){
        $this->data['owner_name'] = $value;
    }

    public function getOwner_name(){
        return $this->data['owner_name'];
    }

    public function setId_card_pic_1($value){
        $this->data['id_card_pic_1'] = $value;
    }

    public function getId_card_pic_1(){
        return $this->data['id_card_pic_1'];
    }

    public function setId_card_pic_2($value){
        $this->data['id_card_pic_2'] = $value;
    }

    public function getId_card_pic_2(){
        return $this->data['id_card_pic_2'];
    }

    public function setId_card_pic_3($value){
        $this->data['id_card_pic_3'] = $value;
    }

    public function getId_card_pic_3(){
        return $this->data['id_card_pic_3'];
    }

    public function setLicense_no($value){
        $this->data['license_no'] = $value;
    }

    public function getLicense_no(){
        return $this->data['license_no'];
    }

    public function setLicense_pic($value){
        $this->data['license_pic'] = $value;
    }

    public function getLicense_pic(){
        return $this->data['license_pic'];
    }

    public function setOther_card_pic($value){
        $this->data['other_card_pic'] = $value;
    }

    public function getOther_card_pic(){
        $this->data['other_card_pic'];
    }

    public function setBusiness_scope($value){
        $this->data['business_scope'] = $value;
    }

    public function getBusiness_scope(){
        return $this->data['business_scope'];
    }

    public function setAuth_status($value){
        $this->data['auth_status'] = $value;
    }

    public function getAuth_status(){
        return $this->data['auth_status'];
    }

    public function setAuth_time($value){
        $this->data['auth_time'] = $value;
    }

    public function getAuth_time(){
        return $this->data['auth_time'];
    }

    public function setUpdate_time($value){
        $this->data['update_time'] = $value;
    }

    public function getUpdate_time(){
        return $this->data['update_time'];
    }
}