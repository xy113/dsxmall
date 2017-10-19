<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午2:47
 */

namespace Data\Member\Object;


use Core\DSXObject;

class MemberLogObject extends DSXObject
{
    protected $fields = array(
        'id'=>'',
        'uid'=>'',
        'ip'=>'',
        'operate'=>'',
        'dateline'=>''
    );

    private $id;
    private $uid;
    private $ip;
    private $operate;
    private $dateline;

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
     * @return MemberLogObject
     */
    public function setId($id)
    {
        $this->id = $id;
        $this->fields['id'] = $id;
        return $this;
    }

    /**
     * @param mixed $uid
     * @return MemberLogObject
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        $this->fields['uid'] = $uid;
        return $this;
    }

    /**
     * @param mixed $ip
     * @return MemberLogObject
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
        $this->fields['ip'] = $ip;
        return $this;
    }

    /**
     * @param mixed $operate
     * @return MemberLogObject
     */
    public function setOperate($operate)
    {
        $this->operate = $operate;
        $this->fields['operate'] = $operate;
        return $this;
    }

    /**
     * @param mixed $dateline
     * @return MemberLogObject
     */
    public function setDateline($dateline)
    {
        $this->dateline = $dateline;
        $this->fields['dateline'] = $dateline;
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
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @return mixed
     */
    public function getOperate()
    {
        return $this->operate;
    }

    /**
     * @return mixed
     */
    public function getDateline()
    {
        return $this->dateline;
    }
}