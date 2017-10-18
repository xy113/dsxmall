<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午12:29
 */

namespace Data\Trade\Object;


use Core\DSXObject;

class OrderShippingObject extends DSXObject
{
    protected $fields = array(
        'id'=>'',
        'uid'=>'',
        'order_id'=>'',
        'shipping_type'=>'',
        'express_id'=>'',
        'express_name'=>'',
        'express_no'=>'',
        'shipping_time'=>''
    );

    private $id;
    private $uid;
    private $order_id;
    private $shipping_type;
    private $express_id;
    private $express_name;
    private $express_no;
    private $shipping_time;

    /**
     * @param mixed $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        $this->fields['id'] = $id;
        return $this;
    }

    /**
     * @param mixed $uid
     * @return $this
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        $this->fields['uid'] = $uid;
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
     * @param mixed $shipping_type
     * @return $this
     */
    public function setShippingType($shipping_type)
    {
        $this->shipping_type = $shipping_type;
        $this->fields['shipping_type'] = $shipping_type;
        return $this;
    }

    /**
     * @param mixed $express_id
     * @return $this
     */
    public function setExpressId($express_id)
    {
        $this->express_id = $express_id;
        $this->fields['express_id'] = $express_id;
        return $this;
    }

    /**
     * @param mixed $express_name
     * @return $this
     */
    public function setExpressName($express_name)
    {
        $this->express_name = $express_name;
        $this->fields['express_name'] = $express_name;
        return $this;
    }

    /**
     * @param mixed $express_no
     * @return $this
     */
    public function setExpressNo($express_no)
    {
        $this->express_no = $express_no;
        $this->fields['express_no'] = $express_no;
        return $this;
    }

    /**
     * @param mixed $shipping_time
     * @return $this
     */
    public function setShippingTime($shipping_time)
    {
        $this->shipping_time = $shipping_time;
        $this->fields['shipping_time'] = $shipping_time;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUid()
    {
        return $this->uid;
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
    public function getShippingType()
    {
        return $this->shipping_type;
    }

    /**
     * @return mixed
     */
    public function getExpressId()
    {
        return $this->express_id;
    }

    /**
     * @return mixed
     */
    public function getExpressName()
    {
        return $this->express_name;
    }

    /**
     * @return mixed
     */
    public function getExpressNo()
    {
        return $this->express_no;
    }

    /**
     * @return mixed
     */
    public function getShippingTime()
    {
        return $this->shipping_time;
    }
}