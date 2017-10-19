<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 上午10:47
 */

namespace Data\Item\Object;


use Core\DSXObject;

class ItemImageObject extends DSXObject
{
    protected $fields = array(
        'id'=>'',
        'uid'=>'',
        'itemid'=>'',
        'thumb'=>'',
        'image'=>''
    );

    private $id;
    private $uid;
    private $itemid;
    private $thumb;
    private $image;

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
     * @param mixed $thumb
     * @return $this
     */
    public function setThumb($thumb)
    {
        $this->thumb = $thumb;
        $this->fields['thumb'] = $thumb;
        return $this;
    }

    /**
     * @param mixed $image
     * @return $this
     */
    public function setImage($image)
    {
        $this->image = $image;
        $this->fields['image'] = $image;
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
    public function getItemid()
    {
        return $this->itemid;
    }

    /**
     * @return mixed
     */
    public function getThumb()
    {
        return $this->thumb;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }


}