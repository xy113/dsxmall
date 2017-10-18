<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午3:22
 */

namespace Data\Common\Object;


use Core\DSXObject;

class AlbumObject extends DSXObject
{
    protected $fields = array(
        'albumid'=>'',
        'uid'=>'',
        'title'=>'',
        'cover'=>'',
        'password'=>'',
        'is_open'=>'',
        'view_num'=>'',
        'dateline'=>''
    );

    private $albumid;
    private $uid;
    private $title;
    private $cover;
    private $password;
    private $is_open;
    private $view_num;
    private $dateline;

    /**
     * @param mixed $albumid
     * @return AlbumObject
     */
    public function setAlbumid($albumid)
    {
        $this->albumid = $albumid;
        $this->fields['albumid'] = $albumid;
        return $this;
    }

    /**
     * @param mixed $uid
     * @return AlbumObject
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        $this->fields['uid'] = $uid;
        return $this;
    }

    /**
     * @param mixed $title
     * @return AlbumObject
     */
    public function setTitle($title)
    {
        $this->title = $title;
        $this->fields['title'] = $title;
        return $this;
    }

    /**
     * @param mixed $cover
     * @return AlbumObject
     */
    public function setCover($cover)
    {
        $this->cover = $cover;
        $this->fields['cover'] = $cover;
        return $this;
    }

    /**
     * @param mixed $password
     * @return AlbumObject
     */
    public function setPassword($password)
    {
        $this->password = $password;
        $this->fields['password'] = $password;
        return $this;
    }

    /**
     * @param mixed $is_open
     * @return AlbumObject
     */
    public function setIsOpen($is_open)
    {
        $this->is_open = $is_open;
        $this->fields['is_open'] = $is_open;
        return $this;
    }

    /**
     * @param mixed $view_num
     * @return AlbumObject
     */
    public function setViewNum($view_num)
    {
        $this->view_num = $view_num;
        $this->fields['view_num'] = $view_num;
        return $this;
    }

    /**
     * @param mixed $dateline
     * @return AlbumObject
     */
    public function setDateline($dateline)
    {
        $this->dateline = $dateline;
        $this->fields['dateline'] = $dateline;
        return $this;
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
    public function getUid()
    {
        return $this->uid;
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
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getisOpen()
    {
        return $this->is_open;
    }

    /**
     * @return mixed
     */
    public function getViewNum()
    {
        return $this->view_num;
    }

    /**
     * @return mixed
     */
    public function getDateline()
    {
        return $this->dateline;
    }
}