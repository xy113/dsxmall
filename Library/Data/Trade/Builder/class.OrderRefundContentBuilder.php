<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/12
 * Time: 上午11:15
 */

namespace Data\Trade\Builder;


use Core\Builder;

class OrderRefundContentBuilder extends Builder
{
    protected $data = array(
        'refund_id'=>'',
        'buyer_uid'=>'',
        'seller_uid'=>'',
        'shop_id'=>'',
        'order_id'=>'',
        'refund_no'=>'',
        'refund_type'=>'',
        'refund_status'=>'',
        'refund_reason'=>'',
        'refund_desc'=>'',
        'refund_fee'=>'',
        'refund_time'=>'',
        'seller_accepted'=>'',
        'seller_accept_type'=>'',
        'seller_accept_time'=>'',
        'seller_reply_text'=>''
    );

    /**
     * @param $value
     */
    public function setRefund_id($value){
        $this->data['refund_id'] = $value;
    }

    /**
     * @return mixed
     */
    public function getRefund_id(){
        return $this->data['refund_id'];
    }

    /**
     * @param $value
     */
    public function setBuyer_uid($value){
        $this->data['buyer_uid'] = $value;
    }

    /**
     * @return mixed
     */
    public function getBuyer_uid(){
        return $this->data['buyer_uid'];
    }

    /**
     * @param $value
     */
    public function setSeller_uid($value){
        $this->data['seller_uid'] = $value;
    }

    /**
     * @return mixed
     */
    public function getSeller_uid(){
        return $this->data['seller_uid'];
    }

    /**
     * @param $value
     */
    public function setShop_id($value){
        $this->data['shop_id'] = $value;
    }

    /**
     * @return mixed
     */
    public function getShop_id(){
        return $this->data['shop_id'];
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
    public function setRefund_no($value){
        $this->data['refund_no'] = $value;
    }

    /**
     * @return mixed
     */
    public function getRefund_no(){
        return $this->data['refund_no'];
    }

    /**
     * @param $value
     */
    public function setRefund_type($value){
        $this->data['refund_type'] = $value;
    }

    /**
     * @return mixed
     */
    public function getRefund_type(){
        return $this->data['refund_type'];
    }

    /**
     * @param $value
     */
    public function setRefund_status($value){
        $this->data['refund_status'] = $value;
    }

    /**
     * @return mixed
     */
    public function getRefund_status(){
        return $this->data['refund_status'];
    }

    /**
     * @param $value
     */
    public function setRefund_reason($value){
        $this->data['refund_reason'] = $value;
    }

    /**
     * @return mixed
     */
    public function getRefund_reason(){
        return $this->data['refund_reason'];
    }

    /**
     * @param $value
     */
    public function setRefund_desc($value){
        $this->data['refund_desc'] = $value;
    }

    /**
     * @return mixed
     */
    public function getRefund_desc(){
        return $this->data['refund_desc'];
    }

    /**
     * @param $value
     */
    public function setRefund_fee($value){
        $this->data['refund_fee'] = $value;
    }

    /**
     * @return mixed
     */
    public function getRefund_fee(){
        return $this->data['refund_fee'];
    }

    /**
     * @param $value
     */
    public function setRefund_time($value){
        $this->data['refund_time'] = $value;
    }

    /**
     * @return mixed
     */
    public function getRefund_time(){
        return $this->data['refund_time'];
    }

    /**
     * @param $value
     */
    public function setSeller_accepted($value){
        $this->data['seller_accepted'] = $value;
    }

    /**
     * @return mixed
     */
    public function getSeller_accepted(){
        return $this->data['seller_accepted'];
    }

    /**
     * @param $value
     */
    public function setSeller_accept_type($value){
        $this->data['seller_accept_type'] = $value;
    }

    /**
     * @return mixed
     */
    public function getSeller_accept_type(){
        return $this->data['seller_accept_type'];
    }

    /**
     * @param $value
     */
    public function setSeller_accept_time($value){
        $this->data['seller_accept_time'] = $value;
    }

    /**
     * @return mixed
     */
    public function getSeller_accept_time(){
        return $this->data['seller_accept_time'];
    }

    /**
     * @param $value
     */
    public function setSeller_reply_text($value){
        $this->data['seller_reply_text'] = $value;
    }

    /**
     * @return mixed
     */
    public function getSeller_reply_text(){
        return $this->data['seller_reply_text'];
    }
}