<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/12
 * Time: 上午10:46
 */

namespace Data\Trade\Builder;


use Core\Builder;

class OrderItemContentBuilder extends Builder
{
    protected $data = array(
        'id'=>'',
        'uid'=>'',
        'order_id'=>'',
        'itemid'=>'',
        'title'=>'',
        'price'=>'',
        'promotion_price'=>'',
        'discount'=>'',
        'thumb'=>'',
        'image'=>'',
        'quantity'=>'',
        'sku_id'=>'',
        'sku_name'=>'',
        'promotion_fee'=>'',
        'shipping_fee'=>'',
        'total_fee'=>''
    );

    /**
     * @param $value
     */
    public function setId($value){
        $this->data['id'] = $value;
    }

    /**
     * @return mixed
     */
    public function getId(){
        return $this->data['id'];
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
    public function setOrder_id($value){
        $this->data['order_id'] = $value;
    }

    /**
     * @return mixed
     */
    public function getOrder_id(){
        return $this->data['order_id'];
    }

    /**
     * @param $value
     */
    public function setItemid($value){
        $this->data['itemid'] = $value;
    }

    /**
     * @return mixed
     */
    public function getItemid(){
        return $this->data['itemid'];
    }

    /**
     * @param $value
     */
    public function setTitle($value){
        $this->data['title'] = $value;
    }

    /**
     * @return mixed
     */
    public function getTitle(){
        return $this->data['title'];
    }

    /**
     * @param $value
     */
    public function setPrice($value){
        $this->data['price'] = $value;
    }

    /**
     * @return mixed
     */
    public function getPrice(){
        return $this->data['price'];
    }

    /**
     * @param $value
     */
    public function setPromotion_price($value){
        $this->data['promotion_price'] = $value;
    }

    /**
     * @return mixed
     */
    public function getPromotion_price(){
        return $this->data['promotion_price'];
    }

    /**
     * @param $value
     */
    public function setDiscount($value){
        $this->data['discount'] = $value;
    }

    /**
     * @return mixed
     */
    public function getDiscount(){
        return $this->data['discount'];
    }

    /**
     * @param $value
     */
    public function setThumb($value){
        $this->data['thumb'] = $value;
    }

    /**
     * @return mixed
     */
    public function getThumb(){
        return $this->data['thumb'];
    }

    /**
     * @param $value
     */
    public function setImage($value){
        $this->data['image'] = $value;
    }

    /**
     * @return mixed
     */
    public function getImage(){
        return $this->data['image'];
    }

    /**
     * @param $value
     */
    public function setQuantity($value){
        $this->data['quantity'] = $value;
    }

    /**
     * @return mixed
     */
    public function getQuantity(){
        return $this->data['quantity'];
    }

    /**
     * @param $value
     */
    public function setSku_id($value){
        $this->data['sku_id'] = $value;
    }

    /**
     * @return mixed
     */
    public function getSku_id(){
        return $this->data['sku_id'];
    }

    /**
     * @param $value
     */
    public function setSku_name($value){
        $this->data['sku_name'] = $value;
    }

    /**
     * @return mixed
     */
    public function getSku_name(){
        return $this->data['sku_name'];
    }

    /**
     * @param $value
     */
    public function setPromotion_fee($value){
        $this->data['promotion_fee'] = $value;
    }

    /**
     * @return mixed
     */
    public function getPromotion_fee(){
        return $this->data['promotion_fee'];
    }

    /**
     * @param $value
     */
    public function setShipping_fee($value){
        $this->data['shipping_fee'] = $value;
    }

    /**
     * @return mixed
     */
    public function getShipping_fee(){
        return $this->data['shipping_fee'];
    }

    /**
     * @param $value
     */
    public function setTotal_fee($value){
        $this->data['total_fee'] = $value;
    }

    /**
     * @return mixed
     */
    public function getTotal_fee(){
        return $this->data['total_fee'];
    }
}