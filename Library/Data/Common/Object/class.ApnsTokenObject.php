<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午3:26
 */

namespace Data\Common\Object;


use Core\DSXObject;

class ApnsTokenObject extends DSXObject
{
    protected $fields = array(
        'id'=>'',
        'uid'=>'',
        'device_token'=>'',
        'available'=>''
    );

    private $id;
    private $uid;
    private $device_token;
    private $available;

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
     * @return ApnsTokenObject
     */
    public function setId($id)
    {
        $this->id = $id;
        $this->fields['id'] = $id;
        return $this;
    }

    /**
     * @param mixed $uid
     * @return ApnsTokenObject
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        $this->fields['uid'] = $uid;
        return $this;
    }

    /**
     * @param mixed $device_token
     * @return ApnsTokenObject
     */
    public function setDeviceToken($device_token)
    {
        $this->device_token = $device_token;
        $this->fields['device_token'] = $device_token;
        return $this;
    }

    /**
     * @param mixed $available
     * @return ApnsTokenObject
     */
    public function setAvailable($available)
    {
        $this->available = $available;
        $this->fields['available'] = $available;
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
    public function getDeviceToken()
    {
        return $this->device_token;
    }

    /**
     * @return mixed
     */
    public function getAvailable()
    {
        return $this->available;
    }
}