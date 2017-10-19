<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午4:32
 */

namespace Data\Common\Object;


use Core\DSXObject;

class VerifyObject extends DSXObject
{
    protected $fields = array(
        'id'=>'',
        'seccode'=>'',
        'phone'=>'',
        'email'=>'',
        'dateline'=>'',
        'used'=>''
    );

    private $id;
    private $secode;
    private $phone;
    private $email;
    private $dateline;
    private $used;

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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return VerifyObject
     */
    public function setId($id)
    {
        $this->id = $id;
        $this->fields['id'] = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSecode()
    {
        return $this->secode;
    }

    /**
     * @param mixed $secode
     * @return VerifyObject
     */
    public function setSecode($secode)
    {
        $this->secode = $secode;
        $this->fields['seccode'] = $secode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     * @return VerifyObject
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        $this->fields['phone'] = $phone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return VerifyObject
     */
    public function setEmail($email)
    {
        $this->email = $email;
        $this->fields['email'] = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateline()
    {
        return $this->dateline;
    }

    /**
     * @param mixed $dateline
     * @return VerifyObject
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
    public function getUsed()
    {
        return $this->used;
    }

    /**
     * @param mixed $used
     * @return VerifyObject
     */
    public function setUsed($used)
    {
        $this->used = $used;
        $this->fields['used'] = $used;
        return $this;
    }


}