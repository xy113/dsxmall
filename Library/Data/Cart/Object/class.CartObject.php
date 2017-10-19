<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午3:07
 */

namespace Data\Cart\Object;


use Core\DSXObject;

class CartObject extends DSXObject
{
    protected $fields = array(
        'id'=>'',
        'uid'=>'',
        'shop_id'=>'',
        'shop_name'=>'',
        'itemid'=>'',
        'title'=>'',
        'quantity'=>'',
        'price'=>'',
        'thumb'=>'',
        'image'=>'',
        'sku_id'=>'',
        'sku_name'=>'',
        'create_time'=>''
    );

    private $id;
    private $uid;
    private $shop_id;
    private $shop_name;
    private $itemid;
    private $title;
    private $quantity;
    private $price;
    private $thumb;
    private $image;
    private $sku_id;
    private $sku_name;
    private $create_time;

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
     * @return CartObject
     */
    public function setId($id)
    {
        $this->id = $id;
        $this->fields['id'] = $id;
        return $this;
    }

    /**
     * @param mixed $uid
     * @return CartObject
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        $this->fields['uid'] = $uid;
        return $this;
    }

    /**
     * @param mixed $shop_id
     * @return CartObject
     */
    public function setShopId($shop_id)
    {
        $this->shop_id = $shop_id;
        $this->fields['shop_id'] = $shop_id;
        return $this;
    }

    /**
     * @param mixed $shop_name
     * @return CartObject
     */
    public function setShopName($shop_name)
    {
        $this->shop_name = $shop_name;
        $this->fields['shop_name'] = $shop_name;
        return $this;
    }

    /**
     * @param mixed $itemid
     * @return CartObject
     */
    public function setItemid($itemid)
    {
        $this->itemid = $itemid;
        $this->fields['itemid'] = $itemid;
        return $this;
    }

    /**
     * @param mixed $title
     * @return CartObject
     */
    public function setTitle($title)
    {
        $this->title = $title;
        $this->fields['title'] = $title;
        return $this;
    }

    /**
     * @param mixed $quantity
     * @return CartObject
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        $this->fields['quantity'] = $quantity;
        return $this;
    }

    /**
     * @param mixed $price
     * @return CartObject
     */
    public function setPrice($price)
    {
        $this->price = $price;
        $this->fields['price'] = $price;
        return $this;
    }

    /**
     * @param mixed $thumb
     * @return CartObject
     */
    public function setThumb($thumb)
    {
        $this->thumb = $thumb;
        $this->fields['thumb'] = $thumb;
        return $this;
    }

    /**
     * @param mixed $image
     * @return CartObject
     */
    public function setImage($image)
    {
        $this->image = $image;
        $this->fields['image'] = $image;
        return $this;
    }

    /**
     * @param mixed $sku_id
     * @return CartObject
     */
    public function setSkuId($sku_id)
    {
        $this->sku_id = $sku_id;
        $this->fields['sku_id'] = $sku_id;
        return $this;
    }

    /**
     * @param mixed $sku_name
     * @return CartObject
     */
    public function setSkuName($sku_name)
    {
        $this->sku_name = $sku_name;
        $this->fields['shop_name'] = $sku_name;
        return $this;
    }

    /**
     * @param mixed $create_time
     * @return CartObject
     */
    public function setCreateTime($create_time)
    {
        $this->create_time = $create_time;
        $this->fields['create_time'] = $create_time;
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
    public function getShopName()
    {
        return $this->shop_name;
    }

    /**
     * @return mixed
     */
    public function getItemid()
    {
        return $this->itemid;
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
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
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
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return mixed
     */
    public function getSkuId()
    {
        return $this->sku_id;
    }

    /**
     * @return mixed
     */
    public function getSkuName()
    {
        return $this->sku_name;
    }

    /**
     * @return mixed
     */
    public function getCreateTime()
    {
        return $this->create_time;
    }
}