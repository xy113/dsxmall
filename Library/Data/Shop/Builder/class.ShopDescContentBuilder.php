<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午10:50
 */

namespace Data\Shop\Builder;


use Core\Builder;

class ShopDescContentBuilder extends Builder
{
    protected $data = array(
        'uid'=>'',
        'shop_id'=>'',
        'content'=>'',
        'update_time'=>''
    );

    public function setUid($value){
        $this->data['uid'] = $value;
    }

    public function getUid(){
        return $this->data['uid'];
    }

    public function setShop_id($value){
        $this->data['shop_id'] = $value;
    }

    public function getShop_id(){
        return $this->data['shop_id'];
    }

    public function setContent($value){
        $this->data['content'] = $value;
    }

    public function getContent(){
        return $this->data['content'];
    }

    public function setUpdate_time($value){
        $this->data['update_time'] = $value;
    }

    public function getUpdate_time(){
        return $this->data['update_time'];
    }
}