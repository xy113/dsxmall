<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午2:05
 */

namespace Data\Post\Object;


use Core\DSXObject;

class PostContentObject extends DSXObject
{
    protected $fields = array(
        'aid'=>'',
        'uid'=>'',
        'content'=>'',
        'pageorder'=>''
    );

    private $aid;
    private $uid;
    private $content;
    private $pageorder;

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
     * @param mixed $aid
     * @return PostContentObject
     */
    public function setAid($aid)
    {
        $this->aid = $aid;
        $this->fields['aid'] = $aid;
        return $this;
    }

    /**
     * @param mixed $uid
     * @return PostContentObject
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        $this->fields['uid'] = $uid;
        return $this;
    }

    /**
     * @param mixed $content
     * @return PostContentObject
     */
    public function setContent($content)
    {
        $this->content = $content;
        $this->fields['content'] = $content;
        return $this;
    }

    /**
     * @param mixed $pageorder
     * @return PostContentObject
     */
    public function setPageorder($pageorder)
    {
        $this->pageorder = $pageorder;
        $this->fields['pageorder'] = $pageorder;
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
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return mixed
     */
    public function getPageorder()
    {
        return $this->pageorder;
    }
}