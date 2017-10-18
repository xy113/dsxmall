<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 上午10:23
 */

namespace Data\Item\Object;


use Core\DSXObject;

class ItemObject extends DSXObject
{
    protected $fields = array(
        'itemid'=>'',//商品ID
        'uid'=>'',//用户ID
        'catid'=>'',
        'shop_id'=>'',
        'title'=>'',
        'subtitle'=>'',
        'item_sn'=>'',
        'thumb'=>'',
        'image'=>'',
        'price'=>'',
        'on_sale'=>'',
        'is_best'=>'',
        'stock'=>'',
        'sold'=>'',
        'view_num'=>'',
        'collection_num'=>'',
        'review_num'=>'',
        'create_time'=>'',
        'update_time'=>'',
        'shipping_fee'=>''
    );

    public $itemid;
    public $uid;
    public $catid;
    public $shop_id;
    public $title;
    public $subtitle;
    public $item_sn;
    public $thumb;
    public $image;
    public $price;
    public $on_sale;
    public $is_best;
    public $stock;
    public $sold;
    public $view_num;
    public $collection_num;
    public $review_num;
    public $create_time;
    public $update_time;
    public $shipping_fee;

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
     * @param mixed $catid
     * @return $this
     */
    public function setCatid($catid)
    {
        $this->catid = $catid;
        $this->fields['catid'] = $catid;
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
     * @param mixed $subtitle
     * @return $this
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
        $this->fields['subtitle'] = $subtitle;
        return $this;
    }

    /**
     * @param mixed $item_sn
     * @return $this
     */
    public function setItemSn($item_sn)
    {
        $this->item_sn = $item_sn;
        $this->fields['item_sn'] = $item_sn;
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
     * @param mixed $on_sale
     * @return $this
     */
    public function setOnSale($on_sale)
    {
        $this->on_sale = $on_sale;
        $this->fields['on_sale'] = $on_sale;
        return $this;
    }

    /**
     * @param mixed $is_best
     * @return $this
     */
    public function setIsBest($is_best)
    {
        $this->is_best = $is_best;
        $this->fields['is_best'] = $is_best;
        return $this;
    }

    /**
     * @param mixed $stock
     * @return $this
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
        $this->fields['stock'] = $stock;
        return $this;
    }

    /**
     * @param mixed $sold
     * @return $this
     */
    public function setSold($sold)
    {
        $this->sold = $sold;
        $this->fields['sold'] = $sold;
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
     * @param mixed $review_num
     * @return $this
     */
    public function setReviewNum($review_num)
    {
        $this->review_num = $review_num;
        $this->fields['review_num'] = $review_num;
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
     * @return mixed
     */
    public function getItemid()
    {
        return $this->itemid;
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
    public function getCatid()
    {
        return $this->catid;
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * @return mixed
     */
    public function getItemSn()
    {
        return $this->item_sn;
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
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getOnSale()
    {
        return $this->on_sale;
    }

    /**
     * @return mixed
     */
    public function getisBest()
    {
        return $this->is_best;
    }

    /**
     * @return mixed
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @return mixed
     */
    public function getSold()
    {
        return $this->sold;
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
    public function getReviewNum()
    {
        return $this->review_num;
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
    public function getShippingFee()
    {
        return $this->shipping_fee;
    }

}