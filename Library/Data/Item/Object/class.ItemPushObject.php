<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 上午10:51
 */

namespace Data\Item\Object;


use Core\DSXObject;

class ItemPushObject extends DSXObject
{
    protected $fields = array(
        'push_id'=>'',
        'uid'=>'',
        'itemid'=>'',
        'groupid'=>'',
        'create_time'=>''
    );

    private $push_id;
    private $uid;
    private $itemid;
    private $groupid;
    private $create_time;

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
     * @param mixed $push_id
     * @return $this
     */
    public function setPushId($push_id)
    {
        $this->push_id = $push_id;
        $this->fields['push_id'] = $push_id;
        return $this;
    }

    /**
     * @param mixed $uid
     * @return $this
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        $this->fields['uid'] = $uid;
        return $this;
    }

    /**
     * @param mixed $itemid
     * @return $this
     */
    public function setItemid($itemid)
    {
        $this->itemid = $itemid;
        $this->fields['itemid'] = $itemid;
        return $this;
    }

    /**
     * @param mixed $groupid
     * @return $this
     */
    public function setGroupid($groupid)
    {
        $this->groupid = $groupid;
        $this->fields['groupid'] = $groupid;
        return $this;
    }

    /**
     * @param mixed $create_time
     * @return $this
     */
    public function setCreateTime($create_time)
    {
        $this->create_time = $create_time;
        $this->fields['create_time'] = $create_time;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPushId()
    {
        return $this->push_id;
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
    public function getItemid()
    {
        return $this->itemid;
    }

    /**
     * @return mixed
     */
    public function getGroupid()
    {
        return $this->groupid;
    }

    /**
     * @return mixed
     */
    public function getCreateTime()
    {
        return $this->create_time;
    }
}