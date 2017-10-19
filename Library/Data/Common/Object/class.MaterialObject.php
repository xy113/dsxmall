<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午4:07
 */

namespace Data\Common\Object;


use Core\DSXObject;

class MaterialObject extends DSXObject
{
    protected $fields = array(
        'id'=>'',
        'uid'=>'',
        'albumid'=>'',
        'name'=>'',
        'path'=>'',
        'thumb'=>'',
        'width'=>'',
        'height'=>'',
        'type'=>'',
        'extension'=>'',
        'size'=>'',
        'dateline'=>'',
        'viewnum'=>''
    );

    private $id;
    private $uid;
    private $albumid;
    private $name;
    private $path;
    private $thumb;
    private $width;
    private $height;
    private $type;
    private $extension;
    private $size;
    private $dateline;
    private $viewnum;

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
     * @return MaterialObject
     */
    public function setId($id)
    {
        $this->id = $id;
        $this->fields['id'] = $id;
        return $this;
    }

    /**
     * @param mixed $uid
     * @return MaterialObject
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        $this->fields['uid'] = $uid;
        return $this;
    }

    /**
     * @param mixed $albumid
     * @return MaterialObject
     */
    public function setAlbumid($albumid)
    {
        $this->albumid = $albumid;
        $this->fields['albumid'] = $albumid;
        return $this;
    }

    /**
     * @param mixed $name
     * @return MaterialObject
     */
    public function setName($name)
    {
        $this->name = $name;
        $this->fields['name'] = $name;
        return $this;
    }

    /**
     * @param mixed $path
     * @return MaterialObject
     */
    public function setPath($path)
    {
        $this->path = $path;
        $this->fields['path'] = $path;
        return $this;
    }

    /**
     * @param mixed $thumb
     * @return MaterialObject
     */
    public function setThumb($thumb)
    {
        $this->thumb = $thumb;
        $this->fields['thumb'] = $thumb;
        return $this;
    }

    /**
     * @param mixed $width
     * @return MaterialObject
     */
    public function setWidth($width)
    {
        $this->width = $width;
        $this->fields['width'] = $width;
        return $this;
    }

    /**
     * @param mixed $height
     * @return MaterialObject
     */
    public function setHeight($height)
    {
        $this->height = $height;
        $this->fields['height'] = $height;
        return $this;
    }

    /**
     * @param mixed $type
     * @return MaterialObject
     */
    public function setType($type)
    {
        $this->type = $type;
        $this->fields['type'] = $type;
        return $this;
    }

    /**
     * @param mixed $extension
     * @return MaterialObject
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
        $this->fields['extension'] = $extension;
        return $this;
    }

    /**
     * @param mixed $size
     * @return MaterialObject
     */
    public function setSize($size)
    {
        $this->size = $size;
        $this->fields['size'] = $size;
        return $this;
    }

    /**
     * @param mixed $dateline
     * @return MaterialObject
     */
    public function setDateline($dateline)
    {
        $this->dateline = $dateline;
        $this->fields['dateline'] = $dateline;
        return $this;
    }

    /**
     * @param mixed $viewnum
     * @return MaterialObject
     */
    public function setViewnum($viewnum)
    {
        $this->viewnum = $viewnum;
        $this->fields['viewnum'] = $viewnum;
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
    public function getAlbumid()
    {
        return $this->albumid;
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
    public function getPath()
    {
        return $this->path;
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
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
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
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return mixed
     */
    public function getDateline()
    {
        return $this->dateline;
    }

    /**
     * @return mixed
     */
    public function getViewnum()
    {
        return $this->viewnum;
    }
}