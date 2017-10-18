<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午4:21
 */

namespace Data\Common\Object;


use Core\DSXObject;

class PageObject extends DSXObject
{
    protected $fields = array(
        'pageid'=>'',
        'type'=>'',
        'catid'=>'',
        'title'=>'',
        'alias'=>'',
        'image'=>'',
        'summary'=>'',
        'body'=>'',
        'template'=>'',
        'displayorder'=>'',
        'pubtime'=>'',
        'modified'=>''
    );

    private $pageid;
    private $type;
    private $catid;
    private $title;
    private $alias;
    private $image;
    private $summary;
    private $body;
    private $template;
    private $displayorder;
    private $pubtime;
    private $modified;

    /**
     * @param mixed $pageid
     * @return PageObject
     */
    public function setPageid($pageid)
    {
        $this->pageid = $pageid;
        $this->fields['pageid'] = $pageid;
        return $this;
    }

    /**
     * @param mixed $type
     * @return PageObject
     */
    public function setType($type)
    {
        $this->type = $type;
        $this->fields['type'] = $type;
        return $this;
    }

    /**
     * @param mixed $catid
     * @return PageObject
     */
    public function setCatid($catid)
    {
        $this->catid = $catid;
        $this->fields['catid'] = $catid;
        return $this;
    }

    /**
     * @param mixed $title
     * @return PageObject
     */
    public function setTitle($title)
    {
        $this->title = $title;
        $this->fields['title'] = $title;
        return $this;
    }

    /**
     * @param mixed $alias
     * @return PageObject
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
        $this->fields['alias'] = $alias;
        return $this;
    }

    /**
     * @param mixed $image
     * @return PageObject
     */
    public function setImage($image)
    {
        $this->image = $image;
        $this->fields['image'] = $image;
        return $this;
    }

    /**
     * @param mixed $summary
     * @return PageObject
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
        $this->fields['summary'] = $summary;
        return $this;
    }

    /**
     * @param mixed $body
     * @return PageObject
     */
    public function setBody($body)
    {
        $this->body = $body;
        $this->fields['body'] = $body;
        return $this;
    }

    /**
     * @param mixed $template
     * @return PageObject
     */
    public function setTemplate($template)
    {
        $this->template = $template;
        $this->fields['template'] = $template;
        return $this;
    }

    /**
     * @param mixed $displayorder
     * @return PageObject
     */
    public function setDisplayorder($displayorder)
    {
        $this->displayorder = $displayorder;
        $this->fields['displayorder'] = $displayorder;
        return $this;
    }

    /**
     * @param mixed $pubtime
     * @return PageObject
     */
    public function setPubtime($pubtime)
    {
        $this->pubtime = $pubtime;
        $this->fields['pubtime'] = $pubtime;
        return $this;
    }

    /**
     * @param mixed $modified
     * @return PageObject
     */
    public function setModified($modified)
    {
        $this->modified = $modified;
        $this->fields['modified'] = $modified;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPageid()
    {
        return $this->pageid;
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
    public function getCatid()
    {
        return $this->catid;
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
    public function getAlias()
    {
        return $this->alias;
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
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return mixed
     */
    public function getTemplate()
    {
        return $this->template;
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
    public function getPubtime()
    {
        return $this->pubtime;
    }

    /**
     * @return mixed
     */
    public function getModified()
    {
        return $this->modified;
    }
}