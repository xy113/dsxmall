<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午12:01
 */

namespace Data\Trade\Object;


use Core\DSXObject;

class OrderActionObject extends DSXObject
{
    protected $fields = array(
        'action_id'=>'',
        'uid'=>'',
        'username'=>'',
        'order_id'=>'',
        'action_name'=>'',
        'action_time'=>''
    );

    private $action_id;
    private $uid;
    private $username;
    private $order_id;
    private $action_name;
    private $action_time;

    /**
     * @param mixed $action_id
     * @return $this
     */
    public function setActionId($action_id)
    {
        $this->action_id = $action_id;
        $this->fields['action_id'] = $action_id;
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
     * @param mixed $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;
        $this->fields['username'] = $username;
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
     * @param mixed $action_name
     * @return $this
     */
    public function setActionName($action_name)
    {
        $this->action_name = $action_name;
        $this->fields['action_name'] = $action_name;
        return $this;
    }

    /**
     * @param mixed $action_time
     * @return $this
     */
    public function setActionTime($action_time)
    {
        $this->action_time = $action_time;
        $this->fields['action_time'] = $action_time;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getActionId()
    {
        return $this->action_id;
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
    public function getUsername()
    {
        return $this->username;
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
    public function getActionName()
    {
        return $this->action_name;
    }

    /**
     * @return mixed
     */
    public function getActionTime()
    {
        return $this->action_time;
    }
}