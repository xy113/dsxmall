<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午1:57
 */

namespace Data\Post\Object;


use Core\DSXObject;

class PostCatlogObject extends DSXObject
{
    protected $fields = array(
        'catid'=>'',
        'fid'=>'',
        'name'=>'',
        'identifer'=>'',
        'icon'=>'',
        'level'=>'',
        'enable'=>'',
        'available'=>'',
        'displayorder'=>'',
        'keywords'=>'',
        'description'=>'',
        'template_index'=>'',
        'template_list'=>'',
        'template_detail'=>''
    );

    private $catid;
    private $fid;
    private $name;
    private $identifer;
    private $icon;
    private $level;
    private $enable;
    private $available;
    private $displayorder;
    private $keywords;
    private $description;
    private $template_index;
    private $template_list;
    private $template_detail;

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
     * @return PostCatlogObject
     */
    public function setCatid($catid)
    {
        $this->catid = $catid;
        $this->fields['catid'] = $catid;
        return $this;
    }

    /**
     * @param mixed $fid
     * @return PostCatlogObject
     */
    public function setFid($fid)
    {
        $this->fid = $fid;
        $this->fields['fid'] = $fid;
        return $this;
    }

    /**
     * @param mixed $name
     * @return PostCatlogObject
     */
    public function setName($name)
    {
        $this->name = $name;
        $this->fields['name'] = $name;
        return $this;
    }

    /**
     * @param mixed $identifer
     * @return PostCatlogObject
     */
    public function setIdentifer($identifer)
    {
        $this->identifer = $identifer;
        $this->fields['identifer'] = $identifer;
        return $this;
    }

    /**
     * @param mixed $icon
     * @return PostCatlogObject
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        $this->fields['icon'] = $icon;
        return $this;
    }

    /**
     * @param mixed $level
     * @return PostCatlogObject
     */
    public function setLevel($level)
    {
        $this->level = $level;
        $this->fields['level'] = $level;
        return $this;
    }

    /**
     * @param mixed $enable
     * @return PostCatlogObject
     */
    public function setEnable($enable)
    {
        $this->enable = $enable;
        $this->fields['enable'] = $enable;
        return $this;
    }

    /**
     * @param mixed $available
     * @return PostCatlogObject
     */
    public function setAvailable($available)
    {
        $this->available = $available;
        $this->fields['available'] = $available;
        return $this;
    }

    /**
     * @param mixed $displayorder
     * @return PostCatlogObject
     */
    public function setDisplayorder($displayorder)
    {
        $this->displayorder = $displayorder;
        $this->fields['displayorder'] = $displayorder;
        return $this;
    }

    /**
     * @param mixed $keywords
     * @return PostCatlogObject
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
        $this->fields['keywords'] = $keywords;
        return $this;
    }

    /**
     * @param mixed $description
     * @return PostCatlogObject
     */
    public function setDescription($description)
    {
        $this->description = $description;
        $this->fields['description'] = $description;
        return $this;
    }

    /**
     * @param mixed $template_index
     * @return PostCatlogObject
     */
    public function setTemplateIndex($template_index)
    {
        $this->template_index = $template_index;
        $this->fields['template_index'] = $template_index;
        return $this;
    }

    /**
     * @param mixed $template_list
     * @return PostCatlogObject
     */
    public function setTemplateList($template_list)
    {
        $this->template_list = $template_list;
        $this->fields['template_list'] = $template_list;
        return $this;
    }

    /**
     * @param mixed $template_detail
     * @return PostCatlogObject
     */
    public function setTemplateDetail($template_detail)
    {
        $this->template_detail = $template_detail;
        $this->fields['template_detail'] = $template_detail;
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
    public function getDisplayorder()
    {
        return $this->displayorder;
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

    /**
     * @return mixed
     */
    public function getTemplateIndex()
    {
        return $this->template_index;
    }

    /**
     * @return mixed
     */
    public function getTemplateList()
    {
        return $this->template_list;
    }

    /**
     * @return mixed
     */
    public function getTemplateDetail()
    {
        return $this->template_detail;
    }
}