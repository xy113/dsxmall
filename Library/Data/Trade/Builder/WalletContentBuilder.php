<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/28
 * Time: 下午2:19
 */

namespace Data\Trade\Builder;


use Core\Builder;

class WalletContentBuilder extends Builder
{
    protected $data = array(
        'uid'=>'',
        'balance'=>'',
        'total_income'=>'',
        'total_cost'=>''
    );

    public function setUid($value){
        $this->data['uid'] = $value;
    }

    public function getUid(){
        return $this->data['uid'];
    }

    public function setBalance($value){
        $this->data['balance'] = $value;
    }

    public function getBalance(){
        return $this->data['balance'];
    }

    public function setTotal_income($value){
        $this->data['total_income'] = $value;
    }

    public function getTotal_income(){
        return $this->data['total_income'];
    }

    public function setTotal_cost($value){
        $this->data['total_cost'] = $value;
    }

    public function getTotal_cost(){
        return $this->data['total_cost'];
    }
}