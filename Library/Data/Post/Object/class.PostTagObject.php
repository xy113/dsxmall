<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午2:17
 */

namespace Data\Post\Object;


use Core\DSXObject;

class PostTagObject extends DSXObject
{
    protected $fields = array(
        'tag_id'=>'',
        'tag_name'=>'',
        'tag_num'=>''
    );

    private $tag_id;
    private $tag_name;
    private $tag_num;

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
     * @param mixed $tag_id
     * @return PostTagObject
     */
    public function setTagId($tag_id)
    {
        $this->tag_id = $tag_id;
        $this->fields['tag_id'] = $tag_id;
        return $this;
    }

    /**
     * @param mixed $tag_name
     * @return PostTagObject
     */
    public function setTagName($tag_name)
    {
        $this->tag_name = $tag_name;
        $this->fields['tag_name'] = $tag_name;
        return $this;
    }

    /**
     * @param mixed $tag_num
     * @return PostTagObject
     */
    public function setTagNum($tag_num)
    {
        $this->tag_num = $tag_num;
        $this->fields['tag_num'] = $tag_num;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTagId()
    {
        return $this->tag_id;
    }

    /**
     * @return mixed
     */
    public function getTagName()
    {
        return $this->tag_name;
    }

    /**
     * @return mixed
     */
    public function getTagNum()
    {
        return $this->tag_num;
    }
}