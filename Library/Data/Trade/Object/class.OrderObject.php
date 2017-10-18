<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 上午11:46
 */

namespace Data\Trade\Object;


use Core\DSXObject;

class OrderObject extends DSXObject
{
    protected $fields = array(
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

    private $order_id;
    private $buyer_uid;
    private $buyer_name;
    private $seller_uid;
    private $seller_name;
    private $shop_id;
    private $shop_name;
    private $order_no;
    private $order_fee;
    private $shipping_fee;
    private $total_fee;
    private $pay_type;
    private $pay_status;
    private $pay_time;
    private $shipping_type;
    private $shipping_status;
    private $shipping_time;
    private $receive_status;
    private $review_status;
    private $refund_status;
    private $create_time;
    private $deal_time;
    private $trade_no;
    private $remark;
    private $consignee;
    private $phone;
    private $address;
    private $is_commited;
    private $is_accepted;
    private $is_closed;
    private $is_deleted;

    /**
     * @param mixed $order_id
     */
    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;
        $this->fields['order_id'] = $order_id;
    }

    /**
     * @param mixed $buyer_uid
     */
    public function setBuyerUid($buyer_uid)
    {
        $this->buyer_uid = $buyer_uid;
        $this->fields['buyer_uid'] = $buyer_uid;
    }

    /**
     * @param mixed $buyer_name
     */
    public function setBuyerName($buyer_name)
    {
        $this->buyer_name = $buyer_name;
        $this->fields['buyer_name'] = $buyer_name;
    }

    /**
     * @param mixed $seller_uid
     */
    public function setSellerUid($seller_uid)
    {
        $this->seller_uid = $seller_uid;
        $this->fields['seller_uid'] = $seller_uid;
    }

    /**
     * @param mixed $seller_name
     */
    public function setSellerName($seller_name)
    {
        $this->seller_name = $seller_name;
        $this->fields['seller_name'] = $seller_name;
    }

    /**
     * @param mixed $shop_id
     */
    public function setShopId($shop_id)
    {
        $this->shop_id = $shop_id;
        $this->fields['shop_id'] = $shop_id;
    }

    /**
     * @param mixed $shop_name
     */
    public function setShopName($shop_name)
    {
        $this->shop_name = $shop_name;
        $this->fields['shop_name'] = $shop_name;
    }

    /**
     * @param mixed $order_no
     */
    public function setOrderNo($order_no)
    {
        $this->order_no = $order_no;
        $this->fields['order_no'] = $order_no;
    }

    /**
     * @param mixed $order_fee
     */
    public function setOrderFee($order_fee)
    {
        $this->order_fee = $order_fee;
        $this->fields['order_fee'] = $order_fee;
    }

    /**
     * @param mixed $shipping_fee
     */
    public function setShippingFee($shipping_fee)
    {
        $this->shipping_fee = $shipping_fee;
        $this->fields['shipping_fee'] = $shipping_fee;
    }

    /**
     * @param mixed $total_fee
     */
    public function setTotalFee($total_fee)
    {
        $this->total_fee = $total_fee;
        $this->fields['total_fee'] = $total_fee;
    }

    /**
     * @param mixed $pay_type
     */
    public function setPayType($pay_type)
    {
        $this->pay_type = $pay_type;
        $this->fields['pay_type'] = $pay_type;
    }

    /**
     * @param mixed $pay_status
     */
    public function setPayStatus($pay_status)
    {
        $this->pay_status = $pay_status;
        $this->fields['pay_status'] = $pay_status;
    }

    /**
     * @param mixed $pay_time
     */
    public function setPayTime($pay_time)
    {
        $this->pay_time = $pay_time;
        $this->fields['pay_time'] = $pay_time;
    }

    /**
     * @param mixed $shipping_type
     */
    public function setShippingType($shipping_type)
    {
        $this->shipping_type = $shipping_type;
        $this->fields['shipping_type'] = $shipping_type;
    }

    /**
     * @param mixed $shipping_status
     */
    public function setShippingStatus($shipping_status)
    {
        $this->shipping_status = $shipping_status;
        $this->fields['shipping_status'] = $shipping_status;
    }

    /**
     * @param mixed $shipping_time
     */
    public function setShippingTime($shipping_time)
    {
        $this->shipping_time = $shipping_time;
        $this->fields['shipping_time'] = $shipping_time;
    }

    /**
     * @param mixed $receive_status
     */
    public function setReceiveStatus($receive_status)
    {
        $this->receive_status = $receive_status;
        $this->fields['receive_status'] = $receive_status;
    }

    /**
     * @param mixed $review_status
     */
    public function setReviewStatus($review_status)
    {
        $this->review_status = $review_status;
        $this->fields['review_status'] = $review_status;
    }

    /**
     * @param mixed $refund_status
     */
    public function setRefundStatus($refund_status)
    {
        $this->refund_status = $refund_status;
        $this->fields['refund_status'] = $refund_status;
    }

    /**
     * @param mixed $create_time
     */
    public function setCreateTime($create_time)
    {
        $this->create_time = $create_time;
        $this->fields['create_time'] = $create_time;
    }

    /**
     * @param mixed $deal_time
     */
    public function setDealTime($deal_time)
    {
        $this->deal_time = $deal_time;
        $this->fields['deal_time'] = $deal_time;
    }

    /**
     * @param mixed $trade_no
     */
    public function setTradeNo($trade_no)
    {
        $this->trade_no = $trade_no;
        $this->fields['trade_no'] = $trade_no;
    }

    /**
     * @param mixed $remark
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;
        $this->fields['remark'] = $remark;
    }

    /**
     * @param mixed $consignee
     */
    public function setConsignee($consignee)
    {
        $this->consignee = $consignee;
        $this->fields['consignee'] = $consignee;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        $this->fields['phone'] = $phone;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
        $this->fields['address'] = $address;
    }

    /**
     * @param mixed $is_commited
     */
    public function setIsCommited($is_commited)
    {
        $this->is_commited = $is_commited;
        $this->fields['is_commited'] = $is_commited;
    }

    /**
     * @param mixed $is_accepted
     */
    public function setIsAccepted($is_accepted)
    {
        $this->is_accepted = $is_accepted;
        $this->fields['is_accepted'] = $is_accepted;
    }

    /**
     * @param mixed $is_closed
     */
    public function setIsClosed($is_closed)
    {
        $this->is_closed = $is_closed;
        $this->fields['is_closed'] = $is_closed;
    }

    /**
     * @param mixed $is_deleted
     */
    public function setIsDeleted($is_deleted)
    {
        $this->is_deleted = $is_deleted;
        $this->fields['is_deleted'] = $is_deleted;
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * @return mixed
     */
    public function getBuyerUid()
    {
        return $this->buyer_uid;
    }

    /**
     * @return mixed
     */
    public function getBuyerName()
    {
        return $this->buyer_name;
    }

    /**
     * @return mixed
     */
    public function getSellerUid()
    {
        return $this->seller_uid;
    }

    /**
     * @return mixed
     */
    public function getSellerName()
    {
        return $this->seller_name;
    }

    /**
     * @return mixed
     */
    public function getShopId()
    {
        return $this->shop_id;
    }

    /**
     * @return mixed
     */
    public function getShopName()
    {
        return $this->shop_name;
    }

    /**
     * @return mixed
     */
    public function getOrderNo()
    {
        return $this->order_no;
    }

    /**
     * @return mixed
     */
    public function getOrderFee()
    {
        return $this->order_fee;
    }

    /**
     * @return mixed
     */
    public function getShippingFee()
    {
        return $this->shipping_fee;
    }

    /**
     * @return mixed
     */
    public function getTotalFee()
    {
        return $this->total_fee;
    }

    /**
     * @return mixed
     */
    public function getPayType()
    {
        return $this->pay_type;
    }

    /**
     * @return mixed
     */
    public function getPayStatus()
    {
        return $this->pay_status;
    }

    /**
     * @return mixed
     */
    public function getPayTime()
    {
        return $this->pay_time;
    }

    /**
     * @return mixed
     */
    public function getShippingType()
    {
        return $this->shipping_type;
    }

    /**
     * @return mixed
     */
    public function getShippingStatus()
    {
        return $this->shipping_status;
    }

    /**
     * @return mixed
     */
    public function getShippingTime()
    {
        return $this->shipping_time;
    }

    /**
     * @return mixed
     */
    public function getReceiveStatus()
    {
        return $this->receive_status;
    }

    /**
     * @return mixed
     */
    public function getReviewStatus()
    {
        return $this->review_status;
    }

    /**
     * @return mixed
     */
    public function getRefundStatus()
    {
        return $this->refund_status;
    }

    /**
     * @return mixed
     */
    public function getCreateTime()
    {
        return $this->create_time;
    }

    /**
     * @return mixed
     */
    public function getDealTime()
    {
        return $this->deal_time;
    }

    /**
     * @return mixed
     */
    public function getTradeNo()
    {
        return $this->trade_no;
    }

    /**
     * @return mixed
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * @return mixed
     */
    public function getConsignee()
    {
        return $this->consignee;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return mixed
     */
    public function getisCommited()
    {
        return $this->is_commited;
    }

    /**
     * @return mixed
     */
    public function getisAccepted()
    {
        return $this->is_accepted;
    }

    /**
     * @return mixed
     */
    public function getisClosed()
    {
        return $this->is_closed;
    }

    /**
     * @return mixed
     */
    public function getisDeleted()
    {
        return $this->is_deleted;
    }
}