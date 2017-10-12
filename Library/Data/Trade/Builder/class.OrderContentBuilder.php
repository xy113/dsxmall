<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/12
 * Time: 上午10:01
 */

namespace Data\Trade\Builder;


use Core\Builder;

class OrderContentBuilder extends Builder
{
    protected $data = array(
        'order_id'=>'',
        'buyer_uid'=>'',
        'buyer_name'=>'',
        'seller_uid'=>'',
        'seller_name'=>'',
        'shop_id'=>'',
        'shop_name'=>'',
        'order_no'=>'',
        'order_fee'=>'',
        'shipping_fee'=>'',
        'total_fee'=>'',
        'pay_type'=>'',
        'pay_status'=>'',
        'pay_time'=>'',
        'shipping_type'=>'',
        'shipping_status'=>'',
        'shipping_time'=>'',
        'receive_status'=>'',
        'review_status'=>'',
        'refund_status'=>'',
        'create_time'=>'',
        'deal_time'=>'',
        'trade_no'=>'',
        'remark'=>'',
        'consignee'=>'',
        'phone'=>'',
        'address'=>'',
        'is_commited'=>'',
        'is_accepted'=>'',
        'is_closed'=>'',
        'is_deleted'=>''
    );

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

    public function setBuyer_uid($value){
        $this->data['buyer_uid'] = $value;
    }

    public function getBuyer_uid(){
        return $this->data['buyer_uid'];
    }

    public function setBuyer_name($value){
        $this->data['buyer_name'] = $value;
    }

    public function getBuyer_name(){
        return $this->data['buyer_name'];
    }

    public function setSeller_uid($value){
        $this->data['seller_uid'] = $value;
    }

    public function getSeller_uid(){
        return $this->data['seller_uid'];
    }

    public function setSeller_name($value){
        $this->data['seller_name'] = $value;
    }

    public function getSeller_name(){
        return $this->data['seller_name'];
    }

    public function setShop_id($value){
        $this->data['shop_id'] = $value;
    }

    public function getShop_id(){
        return $this->data['shop_id'];
    }

    public function setShop_name($value){
        $this->data['shop_name'] = $value;
    }

    public function getShop_name(){
        return $this->data['shop_name'];
    }

    public function setOrder_no($value){
        $this->data['order_no'] = $value;
    }

    public function getOrder_no(){
        return $this->data['order_no'];
    }

    public function setOrder_fee($value){
        $this->data['order_fee'] = $value;
    }

    public function getOrder_fee(){
        return $this->data['order_fee'];
    }

    public function setShipping_fee($value){
        $this->data['shipping_fee'] = $value;
    }

    public function getShipping_fee(){
        return $this->data['shipping_fee'];
    }

    public function setTotal_fee($value){
        $this->data['total_fee'] = $value;
    }

    public function getTotal_fee(){
        return $this->data['total_fee'];
    }

    public function setPay_type($value){
        $this->data['pay_type'] = $value;
    }

    public function getPay_type(){
        return $this->data['pay_type'];
    }

    public function setPay_status($value){
        $this->data['pay_status'] = $value;
    }

    public function getPay_status(){
        return $this->data['pay_status'];
    }

    public function setPay_time($value){
        $this->data['pay_time'] = $value;
    }

    public function getPay_time(){
        return $this->data['pay_time'];
    }

    public function setShipping_type($value){
        $this->data['shipping_type'] = $value;
    }

    public function getShipping_type(){
        return $this->data['shipping_type'];
    }

    public function setShipping_status($value){
        $this->data['shipping_status'] = $value;
    }

    public function getShipping_status(){
        return $this->data['shipping_status'];
    }

    public function setShipping_time($value){
        $this->data['shipping_time'] = $value;
    }

    public function getShipping_time(){
        return $this->data['shipping_time'];
    }

    public function setReceive_status($value){
        $this->data['receive_status'] = $value;
    }

    public function getReceive_status(){
        return $this->data['receive_status'];
    }

    public function setReview_status($value){
        $this->data['review_status'] = $value;
    }

    public function getReview_status(){
        return $this->data['review_status'];
    }

    public function setRefund_status($value){
        $this->data['refund_status'] = $value;
    }

    public function getRefund_status(){
        return $this->data['refund_status'];
    }

    public function setCreate_time($value){
        $this->data['create_time'] = $value;
    }

    public function getCreate_time(){
        return $this->data['create_time'];
    }

    /**
     * @param $value
     */
    public function setDeal_time($value){
        $this->data['deal_time'] = $value;
    }

    /**
     * @return mixed
     */
    public function getDeal_time(){
        return $this->data['deal_time'];
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
    public function setRemark($value){
        $this->data['remark'] = $value;
    }

    /**
     * @return mixed
     */
    public function getRemark(){
        return $this->data['remark'];
    }

    /**
     * @param $value
     */
    public function setConsignee($value){
        $this->data['consignee'] = $value;
    }

    /**
     * @return mixed
     */
    public function getConsignee(){
        return $this->data['consignee'];
    }

    /**
     * @param $value
     */
    public function setPhone($value){
        $this->data['phone'] = $value;
    }

    /**
     * @return mixed
     */
    public function getPhone(){
        return $this->data['phone'];
    }

    /**
     * @param $value
     */
    public function setAddress($value){
        $this->data['address'] = $value;
    }

    /**
     * @return mixed
     */
    public function getAddress(){
        return $this->data['address'];
    }

    /**
     * @param $value
     */
    public function setIs_commited($value){
        $this->data['is_commited'] = $value;
    }

    /**
     * @return mixed
     */
    public function getIs_commited(){
        return $this->data['is_commited'];
    }

    /**
     * @param $value
     */
    public function setIs_accepted($value){
        $this->data['is_accepted'] = $value;
    }

    /**
     * @return mixed
     */
    public function getIs_accepted(){
        return $this->data['is_accepted'];
    }

    /**
     * @param $value
     */
    public function setIs_closed($value){
        $this->data['is_closed'] = $value;
    }

    /**
     * @return mixed
     */
    public function getIs_closed(){
        return $this->data['is_closed'];
    }

    /**
     * @param $value
     */
    public function setIs_deleted($value){
        $this->data['is_deleted'] = $value;
    }

    /**
     * @return mixed
     */
    public function getIs_deleted(){
        return $this->data['is_deleted'];
    }

    /**
     * 生成订单号
     * @param $uid
     * @param string $type
     * @return string
     */
    public function createNo($uid, $type='6'){
        return $type.time().substr($uid, -5);
    }
}