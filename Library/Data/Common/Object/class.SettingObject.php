<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午4:29
 */

namespace Data\Common\Object;


use Core\DSXObject;

class SettingObject extends DSXObject
{
    protected $fields = array(
        'skey'=>'',
        'svalue'=>''
    );

    private $skey;
    private $svalue;

    /**
     * @param mixed $skey
     * @return SettingObject
     */
    public function setSkey($skey)
    {
        $this->skey = $skey;
        $this->fields['skey'] = $skey;
        return $this;
    }

    /**
     * @param mixed $svalue
     * @return SettingObject
     */
    public function setSvalue($svalue)
    {
        $this->svalue = $svalue;
        $this->fields['svalue'] = $svalue;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSkey()
    {
        return $this->skey;
    }

    /**
     * @return mixed
     */
    public function getSvalue()
    {
        return $this->svalue;
    }
}