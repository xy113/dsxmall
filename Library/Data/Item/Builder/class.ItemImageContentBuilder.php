<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午5:04
 */

namespace Data\Item\Builder;


use Core\Builder;

class ItemImageContentBuilder extends Builder
{
    protected $data = array(
        'id'=>'',
        'uid'=>'',
        'itemid'=>'',
        'thumb'=>'',
        'image'=>''
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
}