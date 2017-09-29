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
     * @param $key
     * @param $value
     */
    public function set($key, $value){
        $this->data[$key] = $value;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key){
        return $this->data[$key];
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