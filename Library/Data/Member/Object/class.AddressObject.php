<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 上午9:40
 */

namespace Data\Member\Object;


use Core\DSXObject;

class AddressObject extends DSXObject
{
    //表字段
    protected $fields = array(
        'address_id'=>'',
        'uid'=>'',
        'consignee'=>'',
        'phone'=>'',
        'province'=>'',
        'city'=>'',
        'county'=>'',
        'street'=>'',
        'postcode'=>'',
        'isdefault'=>''
    );

    public $address_id;
    //地址ID
    public $uid;
    //用户ID
    public $consignee;
    //收货人姓名
    public $phone;
    //联系电话
    public $province;
    //所在省份
    public $city;
    //所在城市
    public $county;
    //区县
    public $street;
    //街道地址
    public $postcode;
    //邮政编码
    public $isdefault;
    //默认地址

    /**
     * @param mixed $address_id
     * @return $this
     */
    public function setAddressId($address_id)
    {
        $this->address_id = $address_id;
        $this->fields['address_id'] = $address_id;
        return $this;
    }

    /**
     * @param mixed $uid
     * @return $this
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        $this->fields['uid'] = $uid;
        return $this;
    }

    /**
     * @param mixed $consignee
     * @return $this
     */
    public function setConsignee($consignee)
    {
        $this->consignee = $consignee;
        $this->fields['consignee'] = $consignee;
        return $this;
    }

    /**
     * @param mixed $phone
     * @return $this
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        $this->fields['phone'] = $phone;
        return $this;
    }

    /**
     * @param mixed $province
     * @return $this
     */
    public function setProvince($province)
    {
        $this->province = $province;
        $this->fields['province'] = $province;
        return $this;
    }

    /**
     * @param mixed $city
     * @return $this
     */
    public function setCity($city)
    {
        $this->city = $city;
        $this->fields['city'] = $city;
        return $this;
    }

    /**
     * @param mixed $county
     * @return $this
     */
    public function setCounty($county)
    {
        $this->county = $county;
        $this->fields['county'] = $county;
        return $this;
    }

    /**
     * @param mixed $street
     * @return $this
     */
    public function setStreet($street)
    {
        $this->street = $street;
        $this->fields['street'] = $street;
        return $this;
    }

    /**
     * @param mixed $postcode
     * @return $this
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
        $this->fields['postcode'] = $postcode;
        return $this;
    }

    /**
     * @param mixed $isdefault
     * @return $this
     */
    public function setIsdefault($isdefault)
    {
        $this->isdefault = $isdefault;
        $this->fields['isdefault'] = $isdefault;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddressId()
    {
        return $this->address_id;
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
    public function getConsignee()
    {
        return $this->consignee;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
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
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @return mixed
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * @return mixed
     */
    public function getIsdefault()
    {
        return $this->isdefault;
    }

}