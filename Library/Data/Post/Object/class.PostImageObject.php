<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午2:08
 */

namespace Data\Post\Object;


use Core\DSXObject;

class PostImageObject extends DSXObject
{
    protected $fields = array(
        'aid'=>'',
        'uid'=>'',
        'thumb'=>'',
        'image'=>'',
        'isremote'=>'',
        'description'=>'',
        'displayorder'=>''
    );

    private $aid;
    private $uid;
    private $thumb;
    private $image;
    private $isremote;
    private $description;
    private $displayorder;

    /**
     * @param mixed $aid
     * @return PostImageObject
     */
    public function setAid($aid)
    {
        $this->aid = $aid;
        $this->fields['aid'] = $aid;
        return $this;
    }

    /**
     * @param mixed $uid
     * @return PostImageObject
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        $this->fields['uid'] = $uid;
        return $this;
    }

    /**
     * @param mixed $thumb
     * @return PostImageObject
     */
    public function setThumb($thumb)
    {
        $this->thumb = $thumb;
        $this->fields['thumb'] = $thumb;
        return $this;
    }

    /**
     * @param mixed $image
     * @return PostImageObject
     */
    public function setImage($image)
    {
        $this->image = $image;
        $this->fields['image'] = $image;
        return $this;
    }

    /**
     * @param mixed $isremote
     * @return PostImageObject
     */
    public function setIsremote($isremote)
    {
        $this->isremote = $isremote;
        $this->fields['isremote'] = $isremote;
        return $this;
    }

    /**
     * @param mixed $description
     * @return PostImageObject
     */
    public function setDescription($description)
    {
        $this->description = $description;
        $this->fields['description'] = $description;
        return $this;
    }

    /**
     * @param mixed $displayorder
     * @return PostImageObject
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

    /**
     * @return mixed
     */
    public function getIsremote()
    {
        return $this->isremote;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getDisplayorder()
    {
        return $this->displayorder;
    }
}