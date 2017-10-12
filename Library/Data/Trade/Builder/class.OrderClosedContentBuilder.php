<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/12
 * Time: 上午11:35
 */

namespace Data\Trade\Builder;


use Core\Builder;

class OrderClosedContentBuilder extends Builder
{
    protected $data = array(
        'id'=>'',
        'uid'=>'',
        'order_id'=>'',
        'close_reason'=>'',
        'close_time'=>''
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
    public function setClose_reason($value){
        $this->data['close_reason'] = $value;
    }

    /**
     * @return mixed
     */
    public function getClose_reason(){
        return $this->data['close_reason'];
    }

    /**
     * @param $value
     */
    public function setClose_time($value){
        $this->data['close_time'] = $value;
    }

    /**
     * @return mixed
     */
    public function getClose_time(){
        return $this->data['close_time'];
    }
}