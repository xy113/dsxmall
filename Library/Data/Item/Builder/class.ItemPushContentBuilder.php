<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/13
 * Time: 下午4:38
 */

namespace Data\Item\Builder;


use Core\Builder;

class ItemPushContentBuilder extends Builder
{
    protected $data = array(
        'push_id'=>'',
        'uid'=>'',
        'itemid'=>'',
        'groupid'=>'',
        'create_time'=>''
    );

    /**
     * @param $value
     */
    public function setPush_id($value){
        $this->data['push_id'] = $value;
    }

    /**
     * @return mixed
     */
    public function getPush_id(){
        return $this->data['push_id'];
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
    public function setGroupid($value){
        $this->data['groupid'] = $value;
    }

    /**
     * @return mixed
     */
    public function getGroupid(){
        return $this->data['groupid'];
    }

    /**
     * @param $value
     */
    public function setCreate_time($value){
        $this->data['create_time'] = $value;
    }

    /**
     * @return mixed
     */
    public function getCreate_time(){
        return $this->data['create_time'];
    }
}