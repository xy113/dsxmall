<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午2:34
 */

namespace Data\Member\Object;


use Core\DSXObject;

class MemberGroupObject extends DSXObject
{
    protected $fields = array(
        'gid'=>'',
        'title'=>'',
        'type'=>'',
        'creditslower'=>'',
        'creditshigher'=>'',
        'perm'=>''
    );

    private $gid;
    private $title;
    private $type;
    private $creditslower;
    private $creditshigher;

    /**
     * @param mixed $gid
     * @return MemberGroupObject
     */
    public function setGid($gid)
    {
        $this->gid = $gid;
        $this->fields['gid'] = $gid;
        return $this;
    }

    /**
     * @param mixed $title
     * @return MemberGroupObject
     */
    public function setTitle($title)
    {
        $this->title = $title;
        $this->fields['title'] = $title;
        return $this;
    }

    /**
     * @param mixed $type
     * @return MemberGroupObject
     */
    public function setType($type)
    {
        $this->type = $type;
        $this->fields['type'] = $type;
        return $this;
    }

    /**
     * @param mixed $creditslower
     * @return MemberGroupObject
     */
    public function setCreditslower($creditslower)
    {
        $this->creditslower = $creditslower;
        $this->fields['creditslower'] = $creditslower;
        return $this;
    }

    /**
     * @param mixed $creditshigher
     * @return MemberGroupObject
     */
    public function setCreditshigher($creditshigher)
    {
        $this->creditshigher = $creditshigher;
        $this->fields['creditshigher'] = $creditshigher;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGid()
    {
        return $this->gid;
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getCreditslower()
    {
        return $this->creditslower;
    }

    /**
     * @return mixed
     */
    public function getCreditshigher()
    {
        return $this->creditshigher;
    }
}