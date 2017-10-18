<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午3:14
 */

namespace Data\Common\Object;


use Core\DSXObject;

/**
 * Class AdObject
 * @package Data\Common\Object
 */
class AdObject extends DSXObject
{
    protected $fields = array(
        'id'=>'',
        'uid'=>'',
        'title'=>'',
        'type'=>'',
        'begin_time'=>'',
        'end_time'=>'',
        'data'=>'',
        'clicknum'=>'',
        'available'=>''
    );

    private $id;
    private $uid;
    private $title;
    private $type;
    private $begin_time;
    private $end_time;
    private $data;
    private $clicknum;
    private $available;

    /**
     * @param mixed $id
     * @return AdObject
     */
    public function setId($id)
    {
        $this->id = $id;
        $this->fields['id'] = $id;
        return $this;
    }

    /**
     * @param mixed $uid
     * @return AdObject
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        $this->fields['uid'] = $uid;
        return $this;
    }

    /**
     * @param mixed $title
     * @return AdObject
     */
    public function setTitle($title)
    {
        $this->title = $title;
        $this->fields['title'] = $title;
        return $this;
    }

    /**
     * @param mixed $type
     * @return AdObject
     */
    public function setType($type)
    {
        $this->type = $type;
        $this->fields['type'] = $type;
        return $this;
    }

    /**
     * @param mixed $begin_time
     * @return AdObject
     */
    public function setBeginTime($begin_time)
    {
        $this->begin_time = $begin_time;
        $this->fields['begin_time'] = $begin_time;
        return $this;
    }

    /**
     * @param mixed $end_time
     * @return AdObject
     */
    public function setEndTime($end_time)
    {
        $this->end_time = $end_time;
        $this->fields['end_time'] = $end_time;
        return $this;
    }

    /**
     * @param mixed $data
     * @return AdObject
     */
    public function setData($data)
    {
        $this->data = $data;
        $this->fields['data'] = $data;
        return $this;
    }

    /**
     * @param mixed $clicknum
     * @return AdObject
     */
    public function setClicknum($clicknum)
    {
        $this->clicknum = $clicknum;
        $this->fields['clicknum'] = $clicknum;
        return $this;
    }

    /**
     * @param mixed $available
     * @return AdObject
     */
    public function setAvailable($available)
    {
        $this->available = $available;
        $this->fields['available'] = $available;
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
    public function getTitle()
    {
        return $this->title;
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
    public function getBeginTime()
    {
        return $this->begin_time;
    }

    /**
     * @return mixed
     */
    public function getEndTime()
    {
        return $this->end_time;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getClicknum()
    {
        return $this->clicknum;
    }

    /**
     * @return mixed
     */
    public function getAvailable()
    {
        return $this->available;
    }
}