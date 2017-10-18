<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午4:16
 */

namespace Data\Common\Object;


use Core\DSXObject;

class MenuObject extends DSXObject
{
    protected $fields = array(
        'id'=>'',
        'menuid'=>'',
        'fid'=>'',
        'name'=>'',
        'url'=>'',
        'type'=>'',
        'icon'=>'',
        'target'=>'',
        'displayorder'=>'',
        'available'=>''
    );

    private $id;
    private $menuid;
    private $fid;
    private $name;
    private $url;
    private $type;
    private $icon;
    private $target;
    private $displayorder;
    private $available;

    /**
     * @param mixed $id
     * @return MenuObject
     */
    public function setId($id)
    {
        $this->id = $id;
        $this->fields['id'] = $id;
        return $this;
    }

    /**
     * @param mixed $menuid
     * @return MenuObject
     */
    public function setMenuid($menuid)
    {
        $this->menuid = $menuid;
        $this->fields['menuid'] = $menuid;
        return $this;
    }

    /**
     * @param mixed $fid
     * @return MenuObject
     */
    public function setFid($fid)
    {
        $this->fid = $fid;
        $this->fields['fid'] = $fid;
        return $this;
    }

    /**
     * @param mixed $name
     * @return MenuObject
     */
    public function setName($name)
    {
        $this->name = $name;
        $this->fields['name'] = $name;
        return $this;
    }

    /**
     * @param mixed $url
     * @return MenuObject
     */
    public function setUrl($url)
    {
        $this->url = $url;
        $this->fields['url'] = $url;
        return $this;
    }

    /**
     * @param mixed $type
     * @return MenuObject
     */
    public function setType($type)
    {
        $this->type = $type;
        $this->fields['type'] = $type;
        return $this;
    }

    /**
     * @param mixed $icon
     * @return MenuObject
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        $this->fields['icon'] = $icon;
        return $this;
    }

    /**
     * @param mixed $target
     * @return MenuObject
     */
    public function setTarget($target)
    {
        $this->target = $target;
        $this->fields['target'] = $target;
        return $this;
    }

    /**
     * @param mixed $displayorder
     * @return MenuObject
     */
    public function setDisplayorder($displayorder)
    {
        $this->displayorder = $displayorder;
        $this->fields['displayorder'] = $displayorder;
        return $this;
    }

    /**
     * @param mixed $available
     * @return MenuObject
     */
    public function setAvailable($available)
    {
        $this->available = $available;
        $this->fields['available'] = $available;
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
    public function getMenuid()
    {
        return $this->menuid;
    }

    /**
     * @return mixed
     */
    public function getFid()
    {
        return $this->fid;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @return mixed
     */
    public function getTarget()
    {
        return $this->target;
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
    public function getAvailable()
    {
        return $this->available;
    }
}