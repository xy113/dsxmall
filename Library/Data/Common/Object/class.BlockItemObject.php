<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午3:32
 */

namespace Data\Common\Object;


use Core\DSXObject;

class BlockItemObject extends DSXObject
{
    protected $fields = array(
        'id'=>'',
        'block_id'=>'',
        'title'=>'',
        'subtitle'=>'',
        'image'=>'',
        'url'=>'',
        'field_1'=>'',
        'field_2'=>'',
        'field_3'=>'',
        'displayorder'=>''
    );

    private $id;
    private $block_id;
    private $title;
    private $subtitle;
    private $image;
    private $url;
    private $field_1;
    private $field_2;
    private $field_3;
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
     * @return BlockItemObject
     */
    public function setId($id)
    {
        $this->id = $id;
        $this->fields['id'] = $id;
        return $this;
    }

    /**
     * @param mixed $block_id
     * @return BlockItemObject
     */
    public function setBlockId($block_id)
    {
        $this->block_id = $block_id;
        $this->fields['block_id'] = $block_id;
        return $this;
    }

    /**
     * @param mixed $title
     * @return BlockItemObject
     */
    public function setTitle($title)
    {
        $this->title = $title;
        $this->fields['title'] = $title;
        return $this;
    }

    /**
     * @param mixed $subtitle
     * @return BlockItemObject
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
        $this->fields['subtitle'] = $subtitle;
        return $this;
    }

    /**
     * @param mixed $image
     * @return BlockItemObject
     */
    public function setImage($image)
    {
        $this->image = $image;
        $this->fields['image'] = $image;
        return $this;
    }

    /**
     * @param mixed $url
     * @return BlockItemObject
     */
    public function setUrl($url)
    {
        $this->url = $url;
        $this->fields['url'] = $url;
        return $this;
    }

    /**
     * @param mixed $field_1
     * @return BlockItemObject
     */
    public function setField1($field_1)
    {
        $this->field_1 = $field_1;
        $this->fields['field_1'] = $field_1;
        return $this;
    }

    /**
     * @param mixed $field_2
     * @return BlockItemObject
     */
    public function setField2($field_2)
    {
        $this->field_2 = $field_2;
        $this->fields['field_2'] = $field_2;
        return $this;
    }

    /**
     * @param mixed $field_3
     * @return BlockItemObject
     */
    public function setField3($field_3)
    {
        $this->field_3 = $field_3;
        $this->fields['field_3'] = $field_3;
        return $this;
    }

    /**
     * @param mixed $displayorder
     * @return BlockItemObject
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
    public function getBlockId()
    {
        return $this->block_id;
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
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
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
    public function getField1()
    {
        return $this->field_1;
    }

    /**
     * @return mixed
     */
    public function getField2()
    {
        return $this->field_2;
    }

    /**
     * @return mixed
     */
    public function getField3()
    {
        return $this->field_3;
    }

    /**
     * @return mixed
     */
    public function getDisplayorder()
    {
        return $this->displayorder;
    }
}