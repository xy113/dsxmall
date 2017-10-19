<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午12:05
 */

namespace Data\Trade\Object;


use Core\DSXObject;

class OrderClosedObject extends DSXObject
{
    protected $fields = array(
        'id'=>'',
        'uid'=>'',
        'order_id'=>'',
        'close_reason'=>'',
        'close_time'=>''
    );

    private $id;
    private $uid;
    private $order_id;
    private $close_reason;
    private $close_time;

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
     * @param mixed $close_reason
     * @return $this
     */
    public function setCloseReason($close_reason)
    {
        $this->close_reason = $close_reason;
        $this->fields['close_reason'] = $close_reason;
        return $this;
    }

    /**
     * @param mixed $close_time
     * @return $this
     */
    public function setCloseTime($close_time)
    {
        $this->close_time = $close_time;
        $this->fields['close_time'] = $close_time;
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
    public function getCloseReason()
    {
        return $this->close_reason;
    }

    /**
     * @return mixed
     */
    public function getCloseTime()
    {
        return $this->close_time;
    }
}