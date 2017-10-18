<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午2:37
 */

namespace Data\Member\Object;


use Core\DSXObject;

class MemberInfoObject extends DSXObject
{
    protected $fields = array(
        'uid'=>'',
        'usersex'=>'',
        'birthday'=>'',
        'blood'=>'',
        'star'=>'',
        'qq'=>'',
        'weixin'=>'',
        'country'=>'',
        'province'=>'',
        'city'=>'',
        'county'=>'',
        'town'=>'',
        'street'=>'',
        'introduction'=>'',
        'tags'=>'',
        'modified'=>'',
        'locked'=>''
    );

    private $uid;
    private $usersex;
    private $birthday;
    private $blood;
    private $star;
    private $qq;
    private $weixin;
    private $country;
    private $province;
    private $city;
    private $county;
    private $town;
    private $street;
    private $introduction;
    private $tags;
    private $modified;
    private  $locked;

    /**
     * @param mixed $uid
     * @return MemberInfoObject
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        $this->fields['uid'] = $uid;
        return $this;
    }

    /**
     * @param mixed $usersex
     * @return MemberInfoObject
     */
    public function setUsersex($usersex)
    {
        $this->usersex = $usersex;
        $this->fields['usersex'] = $usersex;
        return $this;
    }

    /**
     * @param mixed $birthday
     * @return MemberInfoObject
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
        $this->fields['birthday'] = $birthday;
        return $this;
    }

    /**
     * @param mixed $blood
     * @return MemberInfoObject
     */
    public function setBlood($blood)
    {
        $this->blood = $blood;
        $this->fields['blood'] = $blood;
        return $this;
    }

    /**
     * @param mixed $star
     * @return MemberInfoObject
     */
    public function setStar($star)
    {
        $this->star = $star;
        $this->fields['star'] = $star;
        return $this;
    }

    /**
     * @param mixed $qq
     * @return MemberInfoObject
     */
    public function setQq($qq)
    {
        $this->qq = $qq;
        $this->fields['qq'] = $qq;
        return $this;
    }

    /**
     * @param mixed $weixin
     * @return MemberInfoObject
     */
    public function setWeixin($weixin)
    {
        $this->weixin = $weixin;
        $this->fields['weixin'] = $weixin;
        return $this;
    }

    /**
     * @param mixed $country
     * @return MemberInfoObject
     */
    public function setCountry($country)
    {
        $this->country = $country;
        $this->fields['country'] = $country;
        return $this;
    }

    /**
     * @param mixed $province
     * @return MemberInfoObject
     */
    public function setProvince($province)
    {
        $this->province = $province;
        $this->fields['province'] = $province;
        return $this;
    }

    /**
     * @param mixed $city
     * @return MemberInfoObject
     */
    public function setCity($city)
    {
        $this->city = $city;
        $this->fields['city'] = $city;
        return $this;
    }

    /**
     * @param mixed $county
     * @return MemberInfoObject
     */
    public function setCounty($county)
    {
        $this->county = $county;
        $this->fields['county'] = $county;
        return $this;
    }

    /**
     * @param mixed $town
     * @return MemberInfoObject
     */
    public function setTown($town)
    {
        $this->town = $town;
        $this->fields['town'] = $town;
        return $this;
    }

    /**
     * @param mixed $street
     * @return MemberInfoObject
     */
    public function setStreet($street)
    {
        $this->street = $street;
        $this->fields['street'] = $street;
        return $this;
    }

    /**
     * @param mixed $introduction
     * @return MemberInfoObject
     */
    public function setIntroduction($introduction)
    {
        $this->introduction = $introduction;
        $this->fields['introduction'] = $introduction;
        return $this;
    }

    /**
     * @param mixed $tags
     * @return MemberInfoObject
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
        $this->fields['tags'] = $tags;
        return $this;
    }

    /**
     * @param mixed $modified
     * @return MemberInfoObject
     */
    public function setModified($modified)
    {
        $this->modified = $modified;
        $this->fields['modified'] = $modified;
        return $this;
    }

    /**
     * @param mixed $locked
     * @return MemberInfoObject
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;
        $this->fields['locked'] = $locked;
        return $this;
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
    public function getUsersex()
    {
        return $this->usersex;
    }

    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @return mixed
     */
    public function getBlood()
    {
        return $this->blood;
    }

    /**
     * @return mixed
     */
    public function getStar()
    {
        return $this->star;
    }

    /**
     * @return mixed
     */
    public function getQq()
    {
        return $this->qq;
    }

    /**
     * @return mixed
     */
    public function getWeixin()
    {
        return $this->weixin;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return mixed
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return mixed
     */
    public function getCounty()
    {
        return $this->county;
    }

    /**
     * @return mixed
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @return mixed
     */
    public function getIntroduction()
    {
        return $this->introduction;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return mixed
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @return mixed
     */
    public function getLocked()
    {
        return $this->locked;
    }
}