<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午4:53
 */

namespace Data\Item\Builder;


use Core\Builder;

class ItemDescContentBuilder extends Builder
{
    protected $data = array(
        'id'=>'',
        'uid'=>'',
        'itemid'=>'',
        'content'=>'',
        'update_time'=>''
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
    public function setContent($value){
        $this->data['content'] = $value;
    }

    /**
     * @return mixed
     */
    public function getContent(){
        return $this->data['content'];
    }

    /**
     * @param $value
     */
    public function setUpdate_time($value){
        $this->data['update_time'] = $value;
    }

    /**
     * @return mixed
     */
    public function getUpdate_time(){
        return $this->data['update_time'];
    }
}