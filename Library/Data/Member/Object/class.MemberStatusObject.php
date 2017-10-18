<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午2:58
 */

namespace Data\Member\Object;


use Core\DSXObject;

class MemberStatusObject extends DSXObject
{
    protected $fields = array(
        'uid'=>'',
        'regdate'=>'',
        'regip'=>'',
        'lastvisit'=>'',
        'lastvisitip'=>'',
        'lastactive'=>''
    );

    private $uid;
    private $regdate;
    private $regip;
    private $lastvisit;
    private $lastvisitip;
    private $lastactive;

    /**
     * @param mixed $uid
     * @return MemberStatusObject
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        $this->fields['uid'] = $uid;
        return $this;
    }

    /**
     * @param mixed $regdate
     * @return MemberStatusObject
     */
    public function setRegdate($regdate)
    {
        $this->regdate = $regdate;
        $this->fields['regdate'] = $regdate;
        return $this;
    }

    /**
     * @param mixed $regip
     * @return MemberStatusObject
     */
    public function setRegip($regip)
    {
        $this->regip = $regip;
        $this->fields['regip'] = $regip;
        return $this;
    }

    /**
     * @param mixed $lastvisit
     * @return MemberStatusObject
     */
    public function setLastvisit($lastvisit)
    {
        $this->lastvisit = $lastvisit;
        $this->fields['lastvisit'] = $lastvisit;
        return $this;
    }

    /**
     * @param mixed $lastvisitip
     * @return MemberStatusObject
     */
    public function setLastvisitip($lastvisitip)
    {
        $this->lastvisitip = $lastvisitip;
        $this->fields['lastvisitip'] = $lastvisitip;
        return $this;
    }

    /**
     * @param mixed $lastactive
     * @return MemberStatusObject
     */
    public function setLastactive($lastactive)
    {
        $this->lastactive = $lastactive;
        $this->fields['lastactive'] = $lastactive;
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
    public function getRegdate()
    {
        return $this->regdate;
    }

    /**
     * @return mixed
     */
    public function getRegip()
    {
        return $this->regip;
    }

    /**
     * @return mixed
     */
    public function getLastvisit()
    {
        return $this->lastvisit;
    }

    /**
     * @return mixed
     */
    public function getLastvisitip()
    {
        return $this->lastvisitip;
    }

    /**
     * @return mixed
     */
    public function getLastactive()
    {
        return $this->lastactive;
    }
}