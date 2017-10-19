<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午2:25
 */

namespace Data\Member\Object;


use Core\DSXObject;

class MemberConnectObject extends DSXObject
{
    protected $fields = array(
        'id'=>'',
        'uid'=>'',
        'platform'=>'',
        'openid'=>'',
        'nickname'=>'',
        'sex'=>'',
        'city'=>'',
        'province'=>'',
        'country'=>'',
        'headimgurl'=>'',
        'dateline'=>''
    );

    private $id;
    private $uid;
    private $platform;
    private $openid;
    private $nickname;
    private $sex;
    private $city;
    private $province;
    private $country;
    private $headimgurl;
    private $dateline;

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
     * @return MemberConnectObject
     */
    public function setId($id)
    {
        $this->id = $id;
        $this->fields['id'] = $id;
        return $this;
    }

    /**
     * @param mixed $uid
     * @return MemberConnectObject
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        $this->fields['uid'] = $uid;
        return $this;
    }

    /**
     * @param mixed $platform
     * @return MemberConnectObject
     */
    public function setPlatform($platform)
    {
        $this->platform = $platform;
        $this->fields['platform'] = $platform;
        return $this;
    }

    /**
     * @param mixed $openid
     * @return MemberConnectObject
     */
    public function setOpenid($openid)
    {
        $this->openid = $openid;
        $this->fields['openid'] = $openid;
        return $this;
    }

    /**
     * @param mixed $nickname
     * @return MemberConnectObject
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
        $this->fields['nickname'] = $nickname;
        return $this;
    }

    /**
     * @param mixed $sex
     * @return MemberConnectObject
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
        $this->fields['sex'] = $sex;
        return $this;
    }

    /**
     * @param mixed $city
     * @return MemberConnectObject
     */
    public function setCity($city)
    {
        $this->city = $city;
        $this->fields['city'] = $city;
        return $this;
    }

    /**
     * @param mixed $province
     * @return MemberConnectObject
     */
    public function setProvince($province)
    {
        $this->province = $province;
        $this->fields['province'] = $province;
        return $this;
    }

    /**
     * @param mixed $country
     * @return MemberConnectObject
     */
    public function setCountry($country)
    {
        $this->country = $country;
        $this->fields['country'] = $country;
        return $this;
    }

    /**
     * @param mixed $headimgurl
     * @return MemberConnectObject
     */
    public function setHeadimgurl($headimgurl)
    {
        $this->headimgurl = $headimgurl;
        $this->fields['headimgurl'] = $headimgurl;
        return $this;
    }

    /**
     * @param mixed $dateline
     * @return MemberConnectObject
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
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * @return mixed
     */
    public function getOpenid()
    {
        return $this->openid;
    }

    /**
     * @return mixed
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @return mixed
     */
    public function getSex()
    {
        return $this->sex;
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
    public function getProvince()
    {
        return $this->province;
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
    public function getHeadimgurl()
    {
        return $this->headimgurl;
    }

    /**
     * @return mixed
     */
    public function getDateline()
    {
        return $this->dateline;
    }
}