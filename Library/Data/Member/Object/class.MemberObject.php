<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午2:20
 */

namespace Data\Member\Object;


use Core\DSXObject;

class MemberObject extends DSXObject
{
    protected $fields = array(
        'uid'=>'',
        'gid'=>'',
        'adminid'=>'',
        'admincp'=>'',
        'username'=>'',
        'password'=>'',
        'email'=>'',
        'mobile'=>'',
        'status'=>'',
        'newpm'=>'',
        'emailstatus'=>'',
        'avatarstatus'=>'',
        'freeze'=>''
    );

    private $uid;
    private $gid;
    private $adminid;
    private $admincp;
    private $username;
    private $password;
    private $email;
    private $mobile;
    private $status;
    private $newpm;
    private $emailstatus;
    private $avatarstatus;
    private $freeze;

    /**
     * @param mixed $uid
     * @return MemberObject
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        $this->fields['uid'] = $uid;
        return $this;
    }

    /**
     * @param mixed $gid
     * @return MemberObject
     */
    public function setGid($gid)
    {
        $this->gid = $gid;
        $this->fields['gid'] = $gid;
        return $this;
    }

    /**
     * @param mixed $adminid
     * @return MemberObject
     */
    public function setAdminid($adminid)
    {
        $this->adminid = $adminid;
        $this->fields['adminid'] = $adminid;
        return $this;
    }

    /**
     * @param mixed $admincp
     * @return MemberObject
     */
    public function setAdmincp($admincp)
    {
        $this->admincp = $admincp;
        $this->fields['admincp'] = $admincp;
        return $this;
    }

    /**
     * @param mixed $username
     * @return MemberObject
     */
    public function setUsername($username)
    {
        $this->username = $username;
        $this->fields['username'] = $username;
        return $this;
    }

    /**
     * @param mixed $password
     * @return MemberObject
     */
    public function setPassword($password)
    {
        $this->password = $password;
        $this->fields['password'] = $password;
        return $this;
    }

    /**
     * @param mixed $email
     * @return MemberObject
     */
    public function setEmail($email)
    {
        $this->email = $email;
        $this->fields['email'] = $email;
        return $this;
    }

    /**
     * @param mixed $mobile
     * @return MemberObject
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
        $this->fields['mobile'] = $mobile;
        return $this;
    }

    /**
     * @param mixed $status
     * @return MemberObject
     */
    public function setStatus($status)
    {
        $this->status = $status;
        $this->fields['status'] = $status;
        return $this;
    }

    /**
     * @param mixed $newpm
     * @return MemberObject
     */
    public function setNewpm($newpm)
    {
        $this->newpm = $newpm;
        $this->fields['newpm'] = $newpm;
        return $this;
    }

    /**
     * @param mixed $emailstatus
     * @return MemberObject
     */
    public function setEmailstatus($emailstatus)
    {
        $this->emailstatus = $emailstatus;
        $this->fields['emailstatus'] = $emailstatus;
        return $this;
    }

    /**
     * @param mixed $avatarstatus
     * @return MemberObject
     */
    public function setAvatarstatus($avatarstatus)
    {
        $this->avatarstatus = $avatarstatus;
        $this->fields['avatarstatus'] = $avatarstatus;
        return $this;
    }

    /**
     * @param mixed $freeze
     * @return MemberObject
     */
    public function setFreeze($freeze)
    {
        $this->freeze = $freeze;
        $this->fields['freeze'] = $freeze;
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
    public function getGid()
    {
        return $this->gid;
    }

    /**
     * @return mixed
     */
    public function getAdminid()
    {
        return $this->adminid;
    }

    /**
     * @return mixed
     */
    public function getAdmincp()
    {
        return $this->admincp;
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
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getNewpm()
    {
        return $this->newpm;
    }

    /**
     * @return mixed
     */
    public function getEmailstatus()
    {
        return $this->emailstatus;
    }

    /**
     * @return mixed
     */
    public function getAvatarstatus()
    {
        return $this->avatarstatus;
    }

    /**
     * @return mixed
     */
    public function getFreeze()
    {
        return $this->freeze;
    }
}