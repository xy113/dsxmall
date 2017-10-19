<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 上午11:31
 */

namespace Data\Shop\Object;


use Core\DSXObject;

class ShopAuthObject extends DSXObject
{
    protected $fields = array(
        'id'=>'',
        'uid'=>'',
        'shop_id'=>'',
        'owner_id'=>'',
        'owner_name'=>'',
        'id_card_pic_1'=>'',
        'id_card_pic_2'=>'',
        'id_card_pic_3'=>'',
        'license_no'=>'',
        'license_pic'=>'',
        'other_card_pic'=>'',
        'business_scope'=>'',
        'auth_status'=>'',
        'auth_time'=>'',
        'update_time'=>''
    );

    public $id;
    public $uid;
    public $shop_id;
    public $owner_id;
    public $owner_name;
    public $id_card_pic_1;
    public $id_card_pic_2;
    public $id_card_pic_3;
    public $license_no;
    public $license_pic;
    public $other_card_pic;
    public $business_scope;
    public $auth_status;
    public $auth_time;
    public $update_time;

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
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        $this->fields['id'] = $id;
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
     * @param mixed $shop_id
     * @return $this
     */
    public function setShopId($shop_id)
    {
        $this->shop_id = $shop_id;
        $this->fields['shop_id'] = $shop_id;
        return $this;
    }

    /**
     * @param mixed $owner_id
     * @return $this
     */
    public function setOwnerId($owner_id)
    {
        $this->owner_id = $owner_id;
        $this->fields['owner_id'] = $owner_id;
        return $this;
    }

    /**
     * @param mixed $owner_name
     * @return $this
     */
    public function setOwnerName($owner_name)
    {
        $this->owner_name = $owner_name;
        $this->fields['owner_name'] = $owner_name;
        return $this;
    }

    /**
     * @param mixed $id_card_pic_1
     * @return $this
     */
    public function setIdCardPic1($id_card_pic_1)
    {
        $this->id_card_pic_1 = $id_card_pic_1;
        $this->fields['id_card_pic_1'] = $id_card_pic_1;
        return $this;
    }

    /**
     * @param mixed $id_card_pic_2
     * @return $this
     */
    public function setIdCardPic2($id_card_pic_2)
    {
        $this->id_card_pic_2 = $id_card_pic_2;
        $this->fields['id_card_pic_2'] = $id_card_pic_2;
        return $this;
    }

    /**
     * @param mixed $id_card_pic_3
     * @return $this
     */
    public function setIdCardPic3($id_card_pic_3)
    {
        $this->id_card_pic_3 = $id_card_pic_3;
        $this->fields['id_card_pic_3'] = $id_card_pic_3;
        return $this;
    }

    /**
     * @param mixed $license_no
     * @return $this
     */
    public function setLicenseNo($license_no)
    {
        $this->license_no = $license_no;
        $this->fields['license_no'] = $license_no;
        return $this;
    }

    /**
     * @param mixed $license_pic
     * @return $this
     */
    public function setLicensePic($license_pic)
    {
        $this->license_pic = $license_pic;
        $this->fields['license_pic'] = $license_pic;
        return $this;
    }

    /**
     * @param mixed $other_card_pic
     * @return $this
     */
    public function setOtherCardPic($other_card_pic)
    {
        $this->other_card_pic = $other_card_pic;
        $this->fields['other_card_pic'] = $other_card_pic;
        return $this;
    }

    /**
     * @param mixed $business_scope
     * @return $this
     */
    public function setBusinessScope($business_scope)
    {
        $this->business_scope = $business_scope;
        $this->fields['business_scope'] = $business_scope;
        return $this;
    }

    /**
     * @param mixed $auth_status
     * @return $this
     */
    public function setAuthStatus($auth_status)
    {
        $this->auth_status = $auth_status;
        $this->fields['auth_status'] = $auth_status;
        return $this;
    }

    /**
     * @param mixed $auth_time
     * @return $this
     */
    public function setAuthTime($auth_time)
    {
        $this->auth_time = $auth_time;
        $this->fields['auth_time'] = $auth_time;
        return $this;
    }

    /**
     * @param mixed $update_time
     * @return $this
     */
    public function setUpdateTime($update_time)
    {
        $this->update_time = $update_time;
        $this->fields['update_time'] = $update_time;
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
    public function getShopId()
    {
        return $this->shop_id;
    }

    /**
     * @return mixed
     */
    public function getOwnerId()
    {
        return $this->owner_id;
    }

    /**
     * @return mixed
     */
    public function getOwnerName()
    {
        return $this->owner_name;
    }

    /**
     * @return mixed
     */
    public function getIdCardPic1()
    {
        return $this->id_card_pic_1;
    }

    /**
     * @return mixed
     */
    public function getIdCardPic2()
    {
        return $this->id_card_pic_2;
    }

    /**
     * @return mixed
     */
    public function getIdCardPic3()
    {
        return $this->id_card_pic_3;
    }

    /**
     * @return mixed
     */
    public function getLicenseNo()
    {
        return $this->license_no;
    }

    /**
     * @return mixed
     */
    public function getLicensePic()
    {
        return $this->license_pic;
    }

    /**
     * @return mixed
     */
    public function getOtherCardPic()
    {
        return $this->other_card_pic;
    }

    /**
     * @return mixed
     */
    public function getBusinessScope()
    {
        return $this->business_scope;
    }

    /**
     * @return mixed
     */
    public function getAuthStatus()
    {
        return $this->auth_status;
    }

    /**
     * @return mixed
     */
    public function getAuthTime()
    {
        return $this->auth_time;
    }

    /**
     * @return mixed
     */
    public function getUpdateTime()
    {
        return $this->update_time;
    }
}