<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 上午9:14
 */

namespace Core;


abstract class DSXObject
{
    protected $fields = array();

    /**
     * DSXObject constructor.
     * @param array $data
     */
    function __construct($data = array())
    {
        if ($data) $this->setFields($data);
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
        if (isset($this->fields[$name])) {
            $this->$name = $value;
            $this->fields[$name] = $value;
        }
        return $this;
    }

    /**
     * @param $name
     * @return bool
     */
    public function __get($name)
    {
        // TODO: Implement __get() method.
        if (isset($this->fields[$name])) {
            return $this->$name;
        }else {
            return false;
        }
    }

    /**
     * @param $name
     * @param $value
     * @return DSXObject
     */
    public function set($name, $value){
        return $this->__set($name, $value);
    }

    /**
     * @param $name
     * @return bool
     */
    public function get($name){
        return $this->__get($name);
    }

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
     * 清空字段
     * @return $this
     */
    public function emptyFields(){
        $this->fields = array();
        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function initWithData(array $data) {
        $this->fields = $data;
        return $this;
    }

    /**
     * @return array
     */
    public function getBizContent(){
        $content = array();
        foreach ($this->fields as $name=>$value){
            if ($name !== '' && $value !== '') {
                $content[$name] = $value;
            }
        }
        return $content;
    }
}