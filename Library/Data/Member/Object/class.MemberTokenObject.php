<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午3:04
 */

namespace Data\Member\Object;


use Core\DSXObject;

class MemberTokenObject extends DSXObject
{
    protected $fields = array(
        'uid'=>'',
        'token'=>'',
        'expire_time'=>''
    );

    private $uid;
    private $token;
    private $expire_time;

    /**
     * @param mixed $uid
     * @return MemberTokenObject
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        $this->fields['uid'] = $uid;
        return $this;
    }

    /**
     * @param mixed $token
     * @return MemberTokenObject
     */
    public function setToken($token)
    {
        $this->token = $token;
        $this->fields['token'] = $token;
        return $this;
    }

    /**
     * @param mixed $expire_time
     * @return MemberTokenObject
     */
    public function setExpireTime($expire_time)
    {
        $this->expire_time = $expire_time;
        $this->fields['expire_time'] = $expire_time;
        return $this;
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
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return mixed
     */
    public function getExpireTime()
    {
        return $this->expire_time;
    }
}