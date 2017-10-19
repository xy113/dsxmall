<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午12:20
 */

namespace Data\Trade\Object;


use Core\DSXObject;

class OrderRefundObject extends DSXObject
{
    protected $fields = array(
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

    private $refund_id;
    private $buyer_uid;
    private $seller_uid;
    private $shop_id;
    private $order_id;
    private $refund_no;
    private $refund_type;
    private $refund_status;
    private $refund_reason;
    private $refund_desc;
    private $refund_fee;
    private $refund_time;
    private $seller_accepted;
    private $seller_accept_type;
    private $seller_accept_time;
    private $seller_reply_text;

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     * @return $this
     */
    public function setFields($fields)
    {
        if (is_array($fields)) {
            foreach ($fields as $name=>$value){
                if (isset($this->fields[$name])) {
                    $this->$name = $value;
                    $this->fields[$name] = $value;
                }
            }
        }
        return $this;
    }

    /**
     * @param mixed $refund_id
     * @return $this
     */
    public function setRefundId($refund_id)
    {
        $this->refund_id = $refund_id;
        $this->fields['refund_id'] = $refund_id;
        return $this;
    }

    /**
     * @param mixed $buyer_uid
     * @return $this
     */
    public function setBuyerUid($buyer_uid)
    {
        $this->buyer_uid = $buyer_uid;
        $this->fields['buyer_uid'] = $buyer_uid;
        return $this;
    }

    /**
     * @param mixed $seller_uid
     * @return $this
     */
    public function setSellerUid($seller_uid)
    {
        $this->seller_uid = $seller_uid;
        $this->fields['seller_uid'] = $seller_uid;
        return $this;
    }

    /**
     * @param mixed $shop_id
     * @return $this
     */
    public function setShopId($shop_id)
    {
        $this->shop_id = $shop_id;
        $this->fields['shop_id'] = $shop_id;
        return $this;
    }

    /**
     * @param mixed $order_id
     * @return $this
     */
    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;
        $this->fields['order_id'] = $order_id;
        return $this;
    }

    /**
     * @param mixed $refund_no
     * @return $this
     */
    public function setRefundNo($refund_no)
    {
        $this->refund_no = $refund_no;
        $this->fields['refund_no'] = $refund_no;
        return $this;
    }

    /**
     * @param mixed $refund_type
     * @return $this
     */
    public function setRefundType($refund_type)
    {
        $this->refund_type = $refund_type;
        $this->fields['refund_type'] = $refund_type;
        return $this;
    }

    /**
     * @param mixed $refund_status
     * @return $this;
     */
    public function setRefundStatus($refund_status)
    {
        $this->refund_status = $refund_status;
        $this->fields['refund_status'] = $refund_status;
        return $this;
    }

    /**
     * @param mixed $refund_reason
     * @return $this
     */
    public function setRefundReason($refund_reason)
    {
        $this->refund_reason = $refund_reason;
        $this->fields['refund_reason'] = $refund_reason;
        return $this;
    }

    /**
     * @param mixed $refund_desc
     * @return $this;
     */
    public function setRefundDesc($refund_desc)
    {
        $this->refund_desc = $refund_desc;
        $this->fields['refund_desc'] = $refund_desc;
        return $this;
    }

    /**
     * @param mixed $refund_fee
     * @return $this
     */
    public function setRefundFee($refund_fee)
    {
        $this->refund_fee = $refund_fee;
        $this->fields['refund_fee'] = $refund_fee;
        return $this;
    }

    /**
     * @param mixed $refund_time
     * @return $this
     */
    public function setRefundTime($refund_time)
    {
        $this->refund_time = $refund_time;
        $this->fields['refund_time'] = $refund_time;
        return $this;
    }

    /**
     * @param mixed $seller_accepted
     * @return $this
     */
    public function setSellerAccepted($seller_accepted)
    {
        $this->seller_accepted = $seller_accepted;
        $this->fields['seller_accepted'] = $seller_accepted;
        return $this;
    }

    /**
     * @param mixed $seller_accept_type
     * @return $this
     */
    public function setSellerAcceptType($seller_accept_type)
    {
        $this->seller_accept_type = $seller_accept_type;
        $this->fields['seller_accept_type'] = $seller_accept_type;
        return $this;
    }

    /**
     * @param mixed $seller_accept_time
     * @return $this
     */
    public function setSellerAcceptTime($seller_accept_time)
    {
        $this->seller_accept_time = $seller_accept_time;
        $this->fields['seller_accept_time'] = $seller_accept_time;
        return $this;
    }

    /**
     * @param mixed $seller_reply_text
     * @return $this
     */
    public function setSellerReplyText($seller_reply_text)
    {
        $this->seller_reply_text = $seller_reply_text;
        $this->fields['seller_reply_text'] = $seller_reply_text;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRefundId()
    {
        return $this->refund_id;
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
    public function getSellerUid()
    {
        return $this->seller_uid;
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
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * @return mixed
     */
    public function getRefundNo()
    {
        return $this->refund_no;
    }

    /**
     * @return mixed
     */
    public function getRefundType()
    {
        return $this->refund_type;
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
    public function getRefundReason()
    {
        return $this->refund_reason;
    }

    /**
     * @return mixed
     */
    public function getRefundDesc()
    {
        return $this->refund_desc;
    }

    /**
     * @return mixed
     */
    public function getRefundFee()
    {
        return $this->refund_fee;
    }

    /**
     * @return mixed
     */
    public function getRefundTime()
    {
        return $this->refund_time;
    }

    /**
     * @return mixed
     */
    public function getSellerAccepted()
    {
        return $this->seller_accepted;
    }

    /**
     * @return mixed
     */
    public function getSellerAcceptType()
    {
        return $this->seller_accept_type;
    }

    /**
     * @return mixed
     */
    public function getSellerAcceptTime()
    {
        return $this->seller_accept_time;
    }

    /**
     * @return mixed
     */
    public function getSellerReplyText()
    {
        return $this->seller_reply_text;
    }
}