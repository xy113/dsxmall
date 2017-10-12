<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/11
 * Time: 下午5:54
 */

namespace Data\Trade\Builder;


use Core\Builder;

class TradeContentBuilder extends Builder
{
    protected $data = array(
        'trade_id'=>'',
        'payer_uid'=>'',
        'payer_name'=>'',
        'payee_uid'=>'',
        'payee_name'=>'',
        'pay_type'=>'',
        'pay_status'=>'',
        'trade_no'=>'',
        'trade_name'=>'',
        'trade_desc'=>'',
        'trade_fee'=>'',
        'trade_type'=>'',
        'trade_time'=>'',
        'out_trade_no'=>''
    );

    /**
     * @param $value
     */
    public function setTrade_id($value){
        $this->data['trade_id'] = $value;
    }

    /**
     * @return mixed
     */
    public function getTrade_id(){
        return $this->data['trade_id'];
    }

    /**
     * @param $value
     */
    public function setPayer_uid($value){
        $this->data['payer_uid'] = $value;
    }

    /**
     * @return mixed
     */
    public function getPayer_uid(){
        return $this->data['payer_uid'];
    }

    /**
     * @param $value
     */
    public function setPayer_name($value){
        $this->data['payer_name'] = $value;
    }

    /**
     * @return mixed
     */
    public function getPayer_name(){
        return $this->data['payer_name'];
    }

    /**
     * @param $value
     */
    public function setPayee_uid($value){
        $this->data['payee_uid'] = $value;
    }

    /**
     * @return mixed
     */
    public function getPayee_uid(){
        return $this->data['payee_uid'];
    }

    /**
     * @param $value
     */
    public function setPayee_name($value){
        $this->data['payee_name'] = $value;
    }

    /**
     * @return mixed
     */
    public function getPayee_name(){
        return $this->data['payee_name'];
    }

    /**
     * @param $value
     */
    public function setPay_type($value){
        $this->data['pay_type'] = $value;
    }

    /**
     * @return mixed
     */
    public function getPay_type(){
        return $this->data['pay_type'];
    }

    /**
     * @param $value
     */
    public function setPay_status($value){
        $this->data['pay_status'] = $value;
    }

    /**
     * @return mixed
     */
    public function getPay_status(){
        return $this->data['pay_status'];
    }

    /**
     * @param $value
     */
    public function setTrade_no($value){
        $this->data['trade_no'] = $value;
    }

    /**
     * @return mixed
     */
    public function getTrade_no(){
        return $this->data['trade_no'];
    }

    /**
     * @param $value
     */
    public function setTrade_name($value){
        $this->data['trade_name'] = $value;
    }

    /**
     * @return mixed
     */
    public function getTrade_name(){
        return $this->data['trade_name'];
    }

    /**
     * @param $value
     */
    public function setTrade_desc($value){
        $this->data['trade_desc'] = $value;
    }

    /**
     * @return mixed
     */
    public function getTrade_desc(){
        return $this->data['trade_desc'];
    }

    /**
     * @param $value
     */
    public function setTrade_fee($value){
        $this->data['trade_fee'] = $value;
    }

    /**
     * @return mixed
     */
    public function getTrade_fee(){
        return $this->data['trade_fee'];
    }

    /**
     * @param $value
     */
    public function setTrade_type($value){
        $this->data['trade_type'] = $value;
    }

    /**
     * @return mixed
     */
    public function getTrade_type(){
        return $this->data['trade_type'];
    }

    /**
     * @param $value
     */
    public function setTrade_time($value){
        $this->data['trade_time'] = $value;
    }

    /**
     * @return mixed
     */
    public function getTrade_time(){
        return $this->data['trade_time'];
    }

    /**
     * @param $value
     */
    public function setOut_trade_no($value){
        $this->data['out_trade_no'] = $value;
    }

    /**
     * @return mixed
     */
    public function getOut_trade_no(){
        return $this->data['out_trade_no'];
    }
}