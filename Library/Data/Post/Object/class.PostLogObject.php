<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午2:12
 */

namespace Data\Post\Object;


use Core\DSXObject;

class PostLogObject extends DSXObject
{
    protected $fields = array(
        'aid'=>'',
        'uid'=>'',
        'modified'=>''
    );

    private $aid;
    private $uid;
    private $modified;

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
     * @param mixed $aid
     * @return PostLogObject
     */
    public function setAid($aid)
    {
        $this->aid = $aid;
        $this->fields['aid'] = $aid;
        return $this;
    }

    /**
     * @param mixed $uid
     * @return PostLogObject
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        $this->fields['uid'] = $uid;
        return $this;
    }

    /**
     * @param mixed $modified
     * @return PostLogObject
     */
    public function setModified($modified)
    {
        $this->modified = $modified;
        $this->fields['modified'] = $modified;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAid()
    {
        return $this->aid;
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
    public function getModified()
    {
        return $this->modified;
    }
}