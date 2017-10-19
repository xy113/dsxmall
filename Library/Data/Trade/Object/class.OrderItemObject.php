<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午12:09
 */

namespace Data\Trade\Object;


use Core\DSXObject;

class OrderItemObject extends DSXObject
{
    protected $fields = array(
        'id'=>'',
        'uid'=>'',
        'order_id'=>'',
        'itemid'=>'',
        'title'=>'',
        'price'=>'',
        'promotion_price'=>'',
        'discount'=>'',
        'thumb'=>'',
        'image'=>'',
        'quantity'=>'',
        'sku_id'=>'',
        'sku_name'=>'',
        'promotion_fee'=>'',
        'shipping_fee'=>'',
        'total_fee'=>''
    );

    private $id;
    private $uid;
    private $order_id;
    private $itemid;
    private $title;
    private $price;
    private $promotion_price;
    private $discount;
    private $thumb;
    private $image;
    private $quantity;
    private $sku_id;
    private $sku_name;
    private $promotion_fee;
    private $shipping_fee;
    private $total_fee;

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
     * @param mixed $order_id
     * @return $this
     */
    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;
        $this->fields['order_id'] = $order_id;
        return $this;
    }

    /**
     * @param mixed $itemid
     * @return $this
     */
    public function setItemid($itemid)
    {
        $this->itemid = $itemid;
        $this->fields['itemid'] = $itemid;
        return $this;
    }

    /**
     * @param mixed $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        $this->fields['title'] = $title;
        return $this;
    }

    /**
     * @param mixed $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;
        $this->fields['price'] = $price;
        return $this;
    }

    /**
     * @param mixed $promotion_price
     * @return $this
     */
    public function setPromotionPrice($promotion_price)
    {
        $this->promotion_price = $promotion_price;
        $this->fields['promotion_price'] = $promotion_price;
        return $this;
    }

    /**
     * @param mixed $discount
     * @return $this
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
        $this->fields['discount'] = $discount;
        return $this;
    }

    /**
     * @param mixed $thumb
     * @return $this
     */
    public function setThumb($thumb)
    {
        $this->thumb = $thumb;
        $this->fields['thumb'] = $thumb;
        return $this;
    }

    /**
     * @param mixed $image
     * @return $this
     */
    public function setImage($image)
    {
        $this->image = $image;
        $this->fields['image'] = $image;
        return $this;
    }

    /**
     * @param mixed $quantity
     * @return $this
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        $this->fields['quantity'] = $quantity;
        return $this;
    }

    /**
     * @param mixed $sku_id
     * @return $this
     */
    public function setSkuId($sku_id)
    {
        $this->sku_id = $sku_id;
        $this->fields['sku_id'] = $sku_id;
        return $this;
    }

    /**
     * @param mixed $sku_name
     * @return $this
     */
    public function setSkuName($sku_name)
    {
        $this->sku_name = $sku_name;
        $this->fields['sku_name'] = $sku_name;
        return $this;
    }

    /**
     * @param mixed $promotion_fee
     * @return $this
     */
    public function setPromotionFee($promotion_fee)
    {
        $this->promotion_fee = $promotion_fee;
        $this->fields['promotion_fee'] = $promotion_fee;
        return $this;
    }

    /**
     * @param mixed $shipping_fee
     * @return $this
     */
    public function setShippingFee($shipping_fee)
    {
        $this->shipping_fee = $shipping_fee;
        $this->fields['shipping_fee'] = $shipping_fee;
        return $this;
    }

    /**
     * @param mixed $total_fee
     * @return $this
     */
    public function setTotalFee($total_fee)
    {
        $this->total_fee = $total_fee;
        $this->fields['total_fee'] = $total_fee;
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
    public function getOrderId()
    {
        return $this->order_id;
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
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getPromotionPrice()
    {
        return $this->promotion_price;
    }

    /**
     * @return mixed
     */
    public function getDiscount()
    {
        return $this->discount;
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
    public function getQuantity()
    {
        return $this->quantity;
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
    public function getPromotionFee()
    {
        return $this->promotion_fee;
    }

    /**
     * @return mixed
     */
    public function getShippingFee()
    {
        return $this->shipping_fee;
    }

    /**
     * @return mixed
     */
    public function getTotalFee()
    {
        return $this->total_fee;
    }
}