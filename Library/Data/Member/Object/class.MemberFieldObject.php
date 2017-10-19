<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午2:31
 */

namespace Data\Member\Object;


use Core\DSXObject;

class MemberFieldObject extends DSXObject
{
    protected $fields = array(
        'field_id'=>'',
        'uid'=>'',
        'field'=>'',
        'value'=>''
    );

    private $field_id;
    private $uid;
    private $field;
    private $value;

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
     * @param mixed $field_id
     * @return MemberFieldObject
     */
    public function setFieldId($field_id)
    {
        $this->field_id = $field_id;
        $this->fields['field_id'] = $field_id;
        return $this;
    }

    /**
     * @param mixed $uid
     * @return MemberFieldObject
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        $this->fields['uid'] = $uid;
        return $this;
    }

    /**
     * @param mixed $field
     * @return MemberFieldObject
     */
    public function setField($field)
    {
        $this->field = $field;
        $this->fields['field'] = $field;
        return $this;
    }

    /**
     * @param mixed $value
     * @return MemberFieldObject
     */
    public function setValue($value)
    {
        $this->value = $value;
        $this->fields['value'] = $value;
        return $this;
    }
}