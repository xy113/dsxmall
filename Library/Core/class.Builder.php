<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午3:51
 */

namespace Core;


abstract class Builder
{
    protected $data;
    /*public function set($key, $value);
    public function get($key);
    public function setData(array $data);
    public function getData();*/

    /**
     * Builder constructor.
     * @param array $data
     */
    function __construct($data = array())
    {
        if ($data) {
            $this->data = $data;
        }
    }

    /**
     * @param $name
     * @param $value
     */
    function __set($name, $value)
    {
        // TODO: Implement __set() method.
        if (isset($this->data[$name])) {
            $this->data[$name] = $value;
        }
    }

    /**
     * @param $name
     * @return bool|mixed
     */
    function __get($name)
    {
        // TODO: Implement __get() method.
        if (isset($this->data[$name])){
            return $this->data[$name];
        }else {
            return false;
        }
    }

    /**
     * @param $name
     * @param $value
     */
    public function set($name, $value){
        $this->__set($name, $value);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function get($name){
        return $this->__get($name);
    }

    /**
     * @param array $data
     */
    public function setData(array $data){
        /*
        if (empty($this->data)){
            $this->data = $data;
        }else {
            foreach ($data as $key=>$value){
                if (isset($this->data[$key])){
                    $this->data[$key] = $value;
                }
            }
        }
        */
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getData(){
        return $this->data;
    }

    /**
     * 清除数据
     */
    public function clearData(){
        $this->data = array();
    }

    /**
     * @return array
     */
    public function getBizContent(){
        $content = array();
        foreach ($this->data as $key=>$value){
            if ($key == '' || $value == ''){
                continue;
            }else {
                $content[$key] = $value;
            }
        }
        return $content;
    }
}