<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午3:44
 */

namespace Data\Common\Object;


use Core\DSXObject;

class DistrictObject extends DSXObject
{
    protected $fields = array(
        'id'=>'',
        'fid'=>'',
        'name'=>'',
        'level'=>'',
        'usetype'=>'',
        'displayorder'=>'',
        'zone_code'=>'',
        'lng'=>'',
        'lat'=>'',
        'pinyin'=>'',
        'letter'=>'',
        'citycode'=>'',
        'zipcode'=>''
    );

    private $id;
    private $fid;
    private $name;
    private $level;
    private $usetype;
    private $displayorder;
    private $zone_code;
    private $lng;
    private $lat;
    private $pinyin;
    private $letter;
    private $citycode;
    private $zipcode;

    /**
     * @param mixed $id
     * @return DistrictObject
     */
    public function setId($id)
    {
        $this->id = $id;
        $this->fields['id'] = $id;
        return $this;
    }

    /**
     * @param mixed $fid
     * @return DistrictObject
     */
    public function setFid($fid)
    {
        $this->fid = $fid;
        $this->fields['fid'] = $fid;
        return $this;
    }

    /**
     * @param mixed $name
     * @return DistrictObject
     */
    public function setName($name)
    {
        $this->name = $name;
        $this->fields['name'] = $name;
        return $this;
    }

    /**
     * @param mixed $level
     * @return DistrictObject
     */
    public function setLevel($level)
    {
        $this->level = $level;
        $this->fields['level'] = $level;
        return $this;
    }

    /**
     * @param mixed $usetype
     * @return DistrictObject
     */
    public function setUsetype($usetype)
    {
        $this->usetype = $usetype;
        $this->fields['usetype'] = $usetype;
        return $this;
    }

    /**
     * @param mixed $displayorder
     * @return DistrictObject
     */
    public function setDisplayorder($displayorder)
    {
        $this->displayorder = $displayorder;
        $this->fields['displayorder'] = $displayorder;
        return $this;
    }

    /**
     * @param mixed $zone_code
     * @return DistrictObject
     */
    public function setZoneCode($zone_code)
    {
        $this->zone_code = $zone_code;
        $this->fields['zone_code'] = $zone_code;
        return $this;
    }

    /**
     * @param mixed $lng
     * @return DistrictObject
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
        $this->fields['lng'] = $lng;
        return $this;
    }

    /**
     * @param mixed $lat
     * @return DistrictObject
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
        $this->fields['lat'] = $lat;
        return $this;
    }

    /**
     * @param mixed $pinyin
     * @return DistrictObject
     */
    public function setPinyin($pinyin)
    {
        $this->pinyin = $pinyin;
        $this->fields['pinyin'] = $pinyin;
        return $this;
    }

    /**
     * @param mixed $letter
     * @return DistrictObject
     */
    public function setLetter($letter)
    {
        $this->letter = $letter;
        $this->fields['letter'] = $letter;
        return $this;
    }

    /**
     * @param mixed $citycode
     * @return DistrictObject
     */
    public function setCitycode($citycode)
    {
        $this->citycode = $citycode;
        $this->fields['citycode'] = $citycode;
        return $this;
    }

    /**
     * @param mixed $zipcode
     * @return DistrictObject
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
        $this->fields['zipcode'] = $zipcode;
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
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @return mixed
     */
    public function getUsetype()
    {
        return $this->usetype;
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
    public function getZoneCode()
    {
        return $this->zone_code;
    }

    /**
     * @return mixed
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @return mixed
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @return mixed
     */
    public function getPinyin()
    {
        return $this->pinyin;
    }

    /**
     * @return mixed
     */
    public function getLetter()
    {
        return $this->letter;
    }

    /**
     * @return mixed
     */
    public function getCitycode()
    {
        return $this->citycode;
    }

    /**
     * @return mixed
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }
}