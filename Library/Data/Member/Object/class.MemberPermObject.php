<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午2:51
 */

namespace Data\Member\Object;


use Core\DSXObject;

class MemberPermObject extends DSXObject
{
    protected $fields = array(
        'uid'=>'',
        'perm'=>''
    );

    private $uid;
    private $perm;

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
     * @param mixed $uid
     * @return MemberPermObject
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        $this->fields['uid'] = $uid;
        return $this;
    }

    /**
     * @param mixed $perm
     * @return MemberPermObject
     */
    public function setPerm($perm)
    {
        $this->perm = $perm;
        $this->fields['perm'] = $perm;
        return $this;
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
    public function getPerm()
    {
        return $this->perm;
    }
}