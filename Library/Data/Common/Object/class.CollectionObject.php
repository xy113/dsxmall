<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午3:38
 */

namespace Data\Common\Object;


use Core\DSXObject;

class CollectionObject extends DSXObject
{
    protected $fields = array(
        'id'=>'',
        'uid'=>'',
        'dataid'=>'',
        'datatype'=>'',
        'title'=>'',
        'image'=>'',
        'create_time'=>''
    );

    private $id;
    private $uid;
    private $dataid;
    private $datatype;
    private $title;
    private $image;
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
     * @param mixed $id
     * @return CollectionObject
     */
    public function setId($id)
    {
        $this->id = $id;
        $this->fields['id'] = $id;
        return $this;
    }

    /**
     * @param mixed $uid
     * @return CollectionObject
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        $this->fields['uid'] = $uid;
        return $this;
    }

    /**
     * @param mixed $dataid
     * @return CollectionObject
     */
    public function setDataid($dataid)
    {
        $this->dataid = $dataid;
        $this->fields['dataid'] = $dataid;
        return $this;
    }

    /**
     * @param mixed $daratype
     * @return CollectionObject
     */
    public function setDatatype($datatype)
    {
        $this->datatype = $datatype;
        $this->fields['datatype'] = $datatype;
        return $this;
    }

    /**
     * @param mixed $title
     * @return CollectionObject
     */
    public function setTitle($title)
    {
        $this->title = $title;
        $this->fields['title'] = $title;
        return $this;
    }

    /**
     * @param mixed $image
     * @return CollectionObject
     */
    public function setImage($image)
    {
        $this->image = $image;
        $this->fields['image'] = $image;
        return $this;
    }

    /**
     * @param mixed $create_time
     * @return CollectionObject
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
    public function getDataid()
    {
        return $this->dataid;
    }

    /**
     * @return mixed
     */
    public function getDatatype()
    {
        return $this->datatype;
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
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return mixed
     */
    public function getCreateTime()
    {
        return $this->create_time;
    }
}