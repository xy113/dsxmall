<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午11:10
 */

namespace Data\Shop\Builder;


use Core\Builder;

class ShopRecordContentBuilder extends Builder
{
    protected $data = array(
        'shop_id'=>'',
        'visit_num'=>'',
        'order_num'=>'',
        'turnovers'=>'',
        'datestamp'=>''
    );

    public function setShop_id($value){
        $this->data['shop_id'] = $value;
    }

    public function getShop_id(){
        return $this->data['shop_id'];
    }

    public function setVisit_num($value){
        $this->data['visit_num'] = $value;
    }

    public function getVisit_num(){
        return $this->data['visit_num'];
    }

    public function setOrder_num($value){
        $this->data['order_num'] = $value;
    }

    public function getOrder_num(){
        return $this->data['order_num'];
    }

    public function setTurnovers($value){
        $this->data['turnovers'] = $value;
    }

    public function getTurnovers(){
        $this->data['turnovers'] = 0;
    }

    public function setDatestamp($value){
        $this->data['datestamp'] = $value;
    }

    public function getDatestamp(){
        return $this->data['datestamp'];
    }
}