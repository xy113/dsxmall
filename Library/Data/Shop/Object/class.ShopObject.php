<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 上午10:56
 */

namespace Data\Shop\Object;


use Core\DSXObject;

class ShopObject extends DSXObject
{
    protected $fields = array(
        'shop_id'=>'',
        'uid'=>'',
        'username'=>'',
        'shop_name'=>'',
        'shop_logo'=>'',
        'shop_image'=>'',
        'shop_type'=>'',
        'phone'=>'',
        'province'=>'',
        'city'=>'',
        'county'=>'',
        'street'=>'',
        'create_time'=>'',
        'update_time'=>'',
        'view_num'=>'',
        'collection_num'=>'',
        'subscribe_num'=>'',
        'lat'=>'',
        'lng'=>'',
        'total_sold'=>'',
        'main_source'=>'',
        'intro'=>'',
        'closed'=>'',
        'auth_status'=>'',
        'review_num_1'=>'',
        'review_num_2'=>'',
        'review_num_3'=>''
    );

    public $shop_id;
    public $uid;
    public $username;
    public $shop_name;
    public $shop_logo;
    public $shop_image;
    public $shop_type;
    public $phone;
    public $province;
    public $city;
    public $county;
    public $street;
    public $create_time;
    public $update_time;
    public $view_num;
    public $collection_num;
    public $subscribe_num;
    public $lat;
    public $lng;
    public $total_sold;
    public $main_source;
    public $intro;
    public $closed;
    public $auth_status;
    public $review_num_1;
    public $review_num_2;
    public $review_num_3;

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
     * @param mixed $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;
        $this->fields['username'] = $username;
        return $this;
    }

    /**
     * @param mixed $shop_name
     * @return $this
     */
    public function setShopName($shop_name)
    {
        $this->shop_name = $shop_name;
        $this->fields['shop_name'] = $shop_name;
        return $this;
    }

    /**
     * @param mixed $shop_logo
     * @return $this
     */
    public function setShopLogo($shop_logo)
    {
        $this->shop_logo = $shop_logo;
        $this->fields['shop_logo'] = $shop_logo;
        return $this;
    }

    /**
     * @param mixed $shop_image
     * @return $this
     */
    public function setShopImage($shop_image)
    {
        $this->shop_image = $shop_image;
        $this->fields['shop_image'] = $shop_image;
        return $this;
    }

    /**
     * @param mixed $shop_type
     * @return $this
     */
    public function setShopType($shop_type)
    {
        $this->shop_type = $shop_type;
        $this->fields['shop_type'] = $shop_type;
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
     * @param mixed $create_time
     * @return $this
     */
    public function setCreateTime($create_time)
    {
        $this->create_time = $create_time;
        $this->fields['create_time'] = $create_time;
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
     * @param mixed $view_num
     * @return $this
     */
    public function setViewNum($view_num)
    {
        $this->view_num = $view_num;
        $this->fields['view_num'] = $view_num;
        return $this;
    }

    /**
     * @param mixed $collection_num
     * @return $this
     */
    public function setCollectionNum($collection_num)
    {
        $this->collection_num = $collection_num;
        $this->fields['collection_num'] = $collection_num;
        return $this;
    }

    /**
     * @param mixed $subscribe_num
     * @return $this
     */
    public function setSubscribeNum($subscribe_num)
    {
        $this->subscribe_num = $subscribe_num;
        $this->fields['subscribe_num'] = $subscribe_num;
        return $this;
    }

    /**
     * @param mixed $lat
     * @return $this
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
        $this->fields['lat'] = $lat;
        return $this;
    }

    /**
     * @param mixed $lng
     * @return $this
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
        $this->fields['lng'] = $lng;
        return $this;
    }

    /**
     * @param mixed $total_sold
     * @return $this
     */
    public function setTotalSold($total_sold)
    {
        $this->total_sold = $total_sold;
        $this->fields['total_sold'] = $total_sold;
        return $this;
    }

    /**
     * @param mixed $main_source
     * @return $this
     */
    public function setMainSource($main_source)
    {
        $this->main_source = $main_source;
        $this->fields['main_source'] = $main_source;
        return $this;
    }

    /**
     * @param mixed $intro
     * @return $this
     */
    public function setIntro($intro)
    {
        $this->intro = $intro;
        $this->fields['intro'] = $intro;
        return $this;
    }

    /**
     * @param mixed $closed
     * @return $this
     */
    public function setClosed($closed)
    {
        $this->closed = $closed;
        $this->fields['closed'] = $closed;
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
     * @param mixed $review_num_1
     * @return $this
     */
    public function setReviewNum1($review_num_1)
    {
        $this->review_num_1 = $review_num_1;
        $this->fields['review_num_1'] = $review_num_1;
        return $this;
    }

    /**
     * @param mixed $review_num_2
     * @return $this
     */
    public function setReviewNum2($review_num_2)
    {
        $this->review_num_2 = $review_num_2;
        $this->fields['review_num_2'] = $review_num_2;
        return $this;
    }

    /**
     * @param mixed $review_num_3
     * @return $this
     */
    public function setReviewNum3($review_num_3)
    {
        $this->review_num_3 = $review_num_3;
        $this->fields['review_num_3'] = $review_num_3;
        return $this;
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
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getShopName()
    {
        return $this->shop_name;
    }

    /**
     * @return mixed
     */
    public function getShopLogo()
    {
        return $this->shop_logo;
    }

    /**
     * @return mixed
     */
    public function getShopImage()
    {
        return $this->shop_image;
    }

    /**
     * @return mixed
     */
    public function getShopType()
    {
        return $this->shop_type;
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
    public function getCreateTime()
    {
        return $this->create_time;
    }

    /**
     * @return mixed
     */
    public function getUpdateTime()
    {
        return $this->update_time;
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
    public function getCollectionNum()
    {
        return $this->collection_num;
    }

    /**
     * @return mixed
     */
    public function getSubscribeNum()
    {
        return $this->subscribe_num;
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
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @return mixed
     */
    public function getTotalSold()
    {
        return $this->total_sold;
    }

    /**
     * @return mixed
     */
    public function getMainSource()
    {
        return $this->main_source;
    }

    /**
     * @return mixed
     */
    public function getIntro()
    {
        return $this->intro;
    }

    /**
     * @return mixed
     */
    public function getClosed()
    {
        return $this->closed;
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
    public function getReviewNum1()
    {
        return $this->review_num_1;
    }

    /**
     * @return mixed
     */
    public function getReviewNum2()
    {
        return $this->review_num_2;
    }

    /**
     * @return mixed
     */
    public function getReviewNum3()
    {
        return $this->review_num_3;
    }
}