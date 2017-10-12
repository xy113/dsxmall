<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/12
 * Time: 上午11:40
 */

namespace Data\Trade\Builder;


use Core\Builder;

class OrderActionContentBuilder extends Builder
{
    protected $data = array(
        'action_id'=>'',
        'uid'=>'',
        'username'=>'',
        'order_id'=>'',
        'action_name'=>'',
        'action_time'=>''
    );

    /**
     * @param $value
     */
    public function setAction_id($value){
        $this->data['action_id'] = $value;
    }

    /**
     * @return mixed
     */
    public function getAction_id(){
        return $this->data['action_id'];
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
    public function setUsername($value){
        $this->data['username'] = $value;
    }

    /**
     * @return mixed
     */
    public function getUsername(){
        return $this->data['username'];
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
    public function setAction_name($value){
        $this->data['action_name'] = $value;
    }

    /**
     * @return mixed
     */
    public function getAction_name(){
        return $this->data['action_name'];
    }

    /**
     * @param $value
     */
    public function setAction_time($value){
        $this->data['action_time'] = $value;
    }

    /**
     * @return mixed
     */
    public function getAction_time(){
        return $this->data['action_time'];
    }
}