<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/12
 * Time: 上午11:04
 */

namespace Data\Trade\Builder;


use Core\Builder;

class OrderShippingContentBuilder extends Builder
{
    protected $data = array(
        'id'=>'',
        'uid'=>'',
        'order_id'=>'',
        'shipping_type'=>'',
        'express_id'=>'',
        'express_name'=>'',
        'express_no'=>'',
        'shipping_time'=>''
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
    public function getId()
    {
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
    public function setShipping_type($value){
        $this->data['shipping_type'] = $value;
    }

    /**
     * @return mixed
     */
    public function getShipping_type(){
        return $this->data['shipping_type'];
    }

    /**
     * @param $value
     */
    public function setExpress_id($value){
        $this->data['express_id'] = $value;
    }

    /**
     * @return mixed
     */
    public function getExpress_id(){
        return $this->data['express_id'];
    }

    /**
     * @param $value
     */
    public function setExpress_name($value){
        $this->data['express_name'] = $value;
    }

    /**
     * @return mixed
     */
    public function getExpress_name(){
        return $this->data['express_name'];
    }

    /**
     * @param $value
     */
    public function setExpress_no($value){
        $this->data['express_no'] = $value;
    }

    /**
     * @return mixed
     */
    public function getExpress_no(){
        return $this->data['express_no'];
    }

    /**
     * @param $value
     */
    public function setShipping_time($value){
        $this->data['shipping_time'] = $value;
    }

    /**
     * @return mixed
     */
    public function getShipping_time(){
        return $this->data['shipping_time'];
    }
}