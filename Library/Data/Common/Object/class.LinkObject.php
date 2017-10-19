<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午4:02
 */

namespace Data\Common\Object;


use Core\DSXObject;

class LinkObject extends DSXObject
{
    protected $fields = array(
        'id'=>'',
        'catid'=>'',
        'type'=>'',
        'title'=>'',
        'url'=>'',
        'image'=>'',
        'displayorder'=>'',
        'description'=>''
    );

    private $id;
    private $catid;
    private $type;
    private $title;
    private $url;
    private $image;
    private $displayorder;
    private $description;

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
     * @return LinkObject
     */
    public function setId($id)
    {
        $this->id = $id;
        $this->fields['id'] = $id;
        return $this;
    }

    /**
     * @param mixed $catid
     * @return LinkObject
     */
    public function setCatid($catid)
    {
        $this->catid = $catid;
        $this->fields['catid'] = $catid;
        return $this;
    }

    /**
     * @param mixed $type
     * @return LinkObject
     */
    public function setType($type)
    {
        $this->type = $type;
        $this->fields['type'] = $type;
        return $this;
    }

    /**
     * @param mixed $title
     * @return LinkObject
     */
    public function setTitle($title)
    {
        $this->title = $title;
        $this->fields['title'] = $title;
        return $this;
    }

    /**
     * @param mixed $url
     * @return LinkObject
     */
    public function setUrl($url)
    {
        $this->url = $url;
        $this->fields['url'] = $url;
        return $this;
    }

    /**
     * @param mixed $image
     * @return LinkObject
     */
    public function setImage($image)
    {
        $this->image = $image;
        $this->fields['image'] = $image;
        return $this;
    }

    /**
     * @param mixed $displayorder
     * @return LinkObject
     */
    public function setDisplayorder($displayorder)
    {
        $this->displayorder = $displayorder;
        $this->fields['displayorder'] = $displayorder;
        return $this;
    }

    /**
     * @param mixed $description
     * @return LinkObject
     */
    public function setDescription($description)
    {
        $this->description = $description;
        $this->fields['description'] = $description;
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
    public function getCatid()
    {
        return $this->catid;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
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
    public function getUrl()
    {
        return $this->url;
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
    public function getDisplayorder()
    {
        return $this->displayorder;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }
}