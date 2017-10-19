<?php

use Core\DSXObject;

/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午1:40
 */

class WeixinMenuObject extends DSXObject
{
    protected $fields = array(
        'id'=>'',
        'fid'=>'',
        'name'=>'',
        'type'=>'',
        'key'=>'',
        'media_id'=>'',
        'url'=>'',
        'displayorder'=>''
    );

    private $id;
    private $fid;
    private $name;
    private $type;
    private $key;
    private $media_id;
    private $url;
    private $displayorder;

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
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        $this->fields['id'] = $id;
        return $this;
    }

    /**
     * @param mixed $fid
     * @return $this
     */
    public function setFid($fid)
    {
        $this->fid = $fid;
        $this->fields['fid'] = $fid;
        return $this;
    }

    /**
     * @param mixed $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        $this->fields['name'] = $name;
        return $this;
    }

    /**
     * @param mixed $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        $this->fields['type'] = $type;
        return $this;
    }

    /**
     * @param mixed $key
     * @return $this
     */
    public function setKey($key)
    {
        $this->key = $key;
        $this->fields['key'] = $key;
        return $this;
    }

    /**
     * @param mixed $media_id
     * @return $this
     */
    public function setMediaId($media_id)
    {
        $this->media_id = $media_id;
        $this->fields['media_id'] = $media_id;
        return $this;
    }

    /**
     * @param mixed $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;
        $this->fields['url'] = $url;
        return $this;
    }

    /**
     * @param mixed $displayorder
     * @return $this
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
    public function getFid()
    {
        return $this->fid;
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return mixed
     */
    public function getMediaId()
    {
        return $this->media_id;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getDisplayorder()
    {
        return $this->displayorder;
    }
}