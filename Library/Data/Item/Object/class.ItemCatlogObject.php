<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 上午10:37
 */

namespace Data\Item\Object;


use Core\DSXObject;

class ItemCatlogObject extends DSXObject
{
    protected $fields = array(
        'catid'=>'',
        'fid'=>'',
        'name'=>'',
        'identifer'=>'',
        'icon'=>'',
        'displayorder'=>'',
        'level'=>'',
        'enable'=>'',
        'available'=>'',
        'keywords'=>'',
        'description'=>''
    );

    private $catid;
    private $fid;
    private $name;
    private $identifer;
    private $icon;
    private $displayorder;
    private $level;
    private $enable;
    private $available;
    private $keywords;
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
     * @param mixed $catid
     * @return $this
     */
    public function setCatid($catid)
    {
        $this->catid = $catid;
        $this->fields['catid'] = $catid;
        return $this;
    }

    /**
     * @param mixed $fid
     * @return $this
     */
    public function setFid($fid)
    {
        $this->fid = $fid;
        $this->fields['fid'] = $fid;
        return $this;
    }

    /**
     * @param mixed $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        $this->fields['name'] = $name;
        return $this;
    }

    /**
     * @param mixed $identifer
     * @return $this
     */
    public function setIdentifer($identifer)
    {
        $this->identifer = $identifer;
        $this->fields['identifer'] = $identifer;
        return $this;
    }

    /**
     * @param mixed $icon
     * @return $this
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        $this->fields['icon'] = $icon;
        return $this;
    }

    /**
     * @param mixed $displayorder
     * @return $this
     */
    public function setDisplayorder($displayorder)
    {
        $this->displayorder = $displayorder;
        $this->fields['displayorder'] = $displayorder;
        return $this;
    }

    /**
     * @param mixed $level
     * @return $this
     */
    public function setLevel($level)
    {
        $this->level = $level;
        $this->fields['level'] = $level;
        return $this;
    }

    /**
     * @param mixed $enable
     * @return $this
     */
    public function setEnable($enable)
    {
        $this->enable = $enable;
        $this->fields['enable'] = $enable;
        return $this;
    }

    /**
     * @param mixed $available
     * @return $this
     */
    public function setAvailable($available)
    {
        $this->available = $available;
        $this->fields['available'] = $available;
        return $this;
    }

    /**
     * @param mixed $keywords
     * @return $this
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
        $this->fields['keywords'] = $keywords;
        return $this;
    }

    /**
     * @param mixed $description
     * @return $this
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
    public function getCatid()
    {
        return $this->catid;
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
    public function getIdentifer()
    {
        return $this->identifer;
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
    public function getDisplayorder()
    {
        return $this->displayorder;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @return mixed
     */
    public function getEnable()
    {
        return $this->enable;
    }

    /**
     * @return mixed
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * @return mixed
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

}