<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午2:14
 */

namespace Data\Post\Object;


use Core\DSXObject;

class PostMediaObject extends DSXObject
{
    protected $fields = array(
        'id'=>'',
        'aid'=>'',
        'uid'=>'',
        'image'=>'',
        'source'=>'',
        'original_url'=>''
    );

    private $id;
    private $aid;
    private $uid;
    private $image;
    private $source;
    private $original_url;

    /**
     * @param mixed $id
     * @return PostMediaObject
     */
    public function setId($id)
    {
        $this->id = $id;
        $this->fields['id'] = $id;
        return $this;
    }

    /**
     * @param mixed $aid
     * @return PostMediaObject
     */
    public function setAid($aid)
    {
        $this->aid = $aid;
        $this->fields['aid'] = $aid;
        return $this;
    }

    /**
     * @param mixed $uid
     * @return PostMediaObject
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        $this->fields['uid'] = $uid;
        return $this;
    }

    /**
     * @param mixed $image
     * @return PostMediaObject
     */
    public function setImage($image)
    {
        $this->image = $image;
        $this->fields['image'] = $image;
        return $this;
    }

    /**
     * @param mixed $source
     * @return PostMediaObject
     */
    public function setSource($source)
    {
        $this->source = $source;
        $this->fields['source'] = $source;
        return $this;
    }

    /**
     * @param mixed $original_url
     * @return PostMediaObject
     */
    public function setOriginalUrl($original_url)
    {
        $this->original_url = $original_url;
        $this->fields['original_url'] = $original_url;
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
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return mixed
     */
    public function getOriginalUrl()
    {
        return $this->original_url;
    }
}