<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午3:55
 */

namespace Data\Common\Object;


use Core\DSXObject;

class ExpressObject extends DSXObject
{
    protected $fields = array(
        'id'=>'',
        'name'=>'',
        'code'=>'',
        'regular'=>'',
        'displayorder'=>''
    );

    private $id;
    private $name;
    private $code;
    private $regular;
    private $displayorder;

    /**
     * @param mixed $id
     * @return ExpressObject
     */
    public function setId($id)
    {
        $this->id = $id;
        $this->fields['id'] = $id;
        return $this;
    }

    /**
     * @param mixed $name
     * @return ExpressObject
     */
    public function setName($name)
    {
        $this->name = $name;
        $this->fields['name'] = $name;
        return $this;
    }

    /**
     * @param mixed $code
     * @return ExpressObject
     */
    public function setCode($code)
    {
        $this->code = $code;
        $this->fields['code'] = $code;
        return $this;
    }

    /**
     * @param mixed $regular
     * @return ExpressObject
     */
    public function setRegular($regular)
    {
        $this->regular = $regular;
        $this->fields['regular'] = $regular;
        return $this;
    }

    /**
     * @param mixed $displayorder
     * @return ExpressObject
     */
    public function setDisplayorder($displayorder)
    {
        $this->displayorder = $displayorder;
        $this->fields['displayorder'] = $displayorder;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getRegular()
    {
        return $this->regular;
    }

    /**
     * @return mixed
     */
    public function getDisplayorder()
    {
        return $this->displayorder;
    }
}