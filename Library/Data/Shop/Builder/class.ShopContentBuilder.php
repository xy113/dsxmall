<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午10:24
 */

namespace Data\Shop\Builder;


use Core\Builder;

class ShopContentBuilder extends Builder
{
    protected $data = array(
        'shop_id'=>'',
        'uid'=>'',
        'username'=>'',
        'shop_name'=>'',
        'shop_logo'=>'',
        'shop_image'=>'',
        'shop_type'=>'',
        'phone'=>'',
        'province'=>'',
        'city'=>'',
        'county'=>'',
        'street'=>'',
        'create_time'=>'',
        'update_time'=>'',
        'view_num'=>'',
        'collection_num'=>'',
        'subscribe_num'=>'',
        'lat'=>'',
        'lng'=>'',
        'total_sold'=>'',
        'main_source'=>'',
        'intro'=>'',
        'closed'=>'',
        'auth_status'=>'',
        'review_num_1'=>'',
        'review_num_2'=>'',
        'review_num_3'=>''
    );

    public function setShop_id($value){
        $this->data['shop_id'] = $value;
    }

    public function getShop_id(){
        return $this->data['shop_id'];
    }

    public function setUid($value){
        $this->data['uid'] = $value;
    }

    public function getUid(){
        return $this->data['uid'];
    }

    public function setUsername($value){
        $this->data['username'] = $value;
    }

    public function getUsername(){
        return $this->data['username'];
    }

    public function setShop_name($value){
        $this->data['shop_name'] = $value;
    }

    public function getShop_name(){
        return $this->data['shop_name'];
    }

    public function setShop_logo($value){
        $this->data['shop_logo'] = $value;
    }

    public function getShop_logo(){
        return $this->data['shop_logo'];
    }

    public function setShop_image($value){
        $this->data['shop_image'] = $value;
    }

    public function getShop_image(){
        return $this->data['shop_image'];
    }

    public function setShop_type($value){
        $this->data['shop_type'] = $value;
    }

    public function getShop_type(){
        return $this->data['shop_type'];
    }

    public function setPhone($value){
        $this->data['phone'] = $value;
    }

    public function getPhone(){
        return $this->data['phone'];
    }

    public function setProvince($value){
        $this->data['province'] = $value;
    }

    public function getProvince(){
        return $this->data['province'];
    }

    public function setCity($value){
        $this->data['city'] = $value;
    }

    public function getCity(){
        return $this->data['city'];
    }

    public function setCounty($value){
        $this->data['county'] = $value;
    }

    public function getCounty(){
        return $this->data['county'];
    }

    public function setStreet($value){
        $this->data['street'] = $value;
    }

    public function getStreet(){
        return $this->data['street'];
    }

    public function setCreate_time($value){
        $this->data['create_time'] = $value;
    }

    public function getCreate_time(){
        return $this->data['create_time'];
    }

    public function setUpdate_time($value){
        $this->data['update_time'] = $value;
    }

    public function getUpdate_time(){
        return $this->data['update_time'];
    }

    public function setView_num($value){
        $this->data['view_num'] = $value;
    }

    public function getView_num(){
        return $this->data['view_num'];
    }

    public function setCollection_num($value){
        $this->data['collection_num'] = $value;
    }

    public function getCollection_num(){
        return $this->data['collection_num'];
    }

    public function setSubscribe_num($value){
        $this->data['subscribe_num'] = $value;
    }

    public function getSubscribe_num(){
        return $this->data['subscribe_num'];
    }

    public function setLat($value){
        $this->data['lat'] = $value;
    }

    public function getLat(){
        return $this->data['lat'];
    }

    public function setLng($value){
        $this->data['lng'] = $value;
    }

    public function getLng(){
        return $this->data['lng'];
    }

    public function setTotal_sold($value){
        $this->data['total_sold'] = $value;
    }

    public function getTotal_sold(){
        return $this->data['total_sold'];
    }

    public function setMain_source($value){
        $this->data['main_source'] = $value;
    }

    public function getMain_source(){
        return $this->data['main_source'];
    }

    public function setIntro($value){
        $this->data['intro'] = $value;
    }

    public function getIntro(){
        return $this->data['intro'];
    }

    public function setClosed($value){
        $this->data['closed'] = $value;
    }

    public function getClosed(){
        return $this->data['closed'];
    }

    public function setAuth_status($value){
        $this->data['auth_status'] = $value;
    }

    public function getAuth_status(){
        return $this->data['auth_status'];
    }
}