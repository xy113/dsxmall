<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午3:20
 */
namespace Data\Item\Builder;

use Core\Builder;

class ItemContentBuilder extends Builder
{
    protected $data = array(
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

//    public $itemid = 0;
//    public $uid = 0;
//    public $catid = 0;
//    public $shop_id = 0;
//    public $title = 0;

    /**
     * @param $value
     */
    public function setItemid($value){
        $this->data['itemid'] = $value;
    }

    /**
     * @return mixed
     */
    public function getItemid(){
        return $this->data['itemid'];
    }

    /**
     * @param $value
     */
    public function setUid($value){
        $this->data['uid'] = $value;
    }

    /**
     * @return mixed
     */
    public function getUid(){
        return $this->data['uid'];
    }

    /**
     * @param $value
     */
    public function setCatid($value){
        $this->data['catid'] = $value;
    }

    /**
     * @return mixed
     */
    public function getCatid(){
        return $this->data['catid'];
    }

    /**
     * @param $value
     */
    public function setShop_id($value){
        $this->data['shop_id'] = $value;
    }

    /**
     * @return mixed
     */
    public function getShop_id(){
        return $this->data['shop_id'];
    }

    /**
     * @param $value
     */
    public function setTitle($value){
        $this->data['title'] = $value;
    }

    /**
     * @return mixed
     */
    public function getTitle(){
        return $this->data['title'];
    }

    /**
     * @param $value
     */
    public function setSubtitle($value){
        $this->data['subtitle'] = $value;
    }

    /**
     * @return mixed
     */
    public function getSubtitle(){
        return $this->data['subtitle'];
    }

    /**
     * @param $value
     */
    public function setItem_sn($value){
        $this->data['item_sn'] = $value;
    }

    /**
     * @return mixed
     */
    public function getItem_sn(){
        return $this->data['item_sn'];
    }

    /**
     * @param $value
     */
    public function setImage($value){
        $this->data['image'] = $value;
    }

    /**
     *
     */
    public function getImage(){
        return $this->data['image'];
    }

    /**
     * @param $value
     */
    public function setThumb($value){
        $this->data['thumb'] = $value;
    }

    /**
     * @return mixed
     */
    public function getThumb(){
        return $this->data['thumb'];
    }

    /**
     * @param $value
     */
    public function setPrice($value){
        $this->data['price'] = $value;
    }

    /**
     * @return mixed
     */
    public function getPrice(){
        return $this->data['price'];
    }

    /**
     * @param $value
     */
    public function setOn_sale($value){
        $this->data['on_sale'] = $value;
    }

    /**
     * @return mixed
     */
    public function getOn_sale(){
        return $this->data['on_sale'];
    }

    /**
     * @param $value
     */
    public function setStock($value){
        $this->data['stock'] = $value;
    }

    /**
     * @return mixed
     */
    public function getStock(){
        return $this->data['stock'];
    }

    /**
     * @param $value
     */
    public function setSold($value){
        $this->data['sold'] = $value;
    }

    /**
     * @return mixed
     */
    public function getSold(){
        return $this->data['sold'];
    }

    /**
     * @param $value
     */
    public function setView_num($value){
        $this->data['view_num'] = $value;
    }

    /**
     * @return mixed
     */
    public function getView_num(){
        return $this->data['view_num'];
    }

    /**
     * @param $value
     */
    public function setCollection_num($value){
        $this->data['collection_num'] = $value;
    }

    /**
     * @return mixed
     */
    public function getCollection_num(){
        return $this->data['collection_num'];
    }

    /**
     * @param $value
     */
    public function setReview_num($value){
        $this->data['review_num'] = $value;
    }

    /**
     * @return mixed
     */
    public function getReview_num(){
        return $this->data['review_num'];
    }

    /**
     * @param $value
     */
    public function setCreate_time($value){
        $this->data['create_time'] = $value;
    }

    /**
     * @return mixed
     */
    public function getCreate_time(){
        return $this->data['create_time'];
    }

    /**
     * @param $value
     */
    public function setUpdate_time($value){
        $this->data['update_time'] = $value;
    }

    /**
     * @return mixed
     */
    public function getUpdate_time(){
        return $this->data['update_time'];
    }

    /**
     * @param $value
     */
    public function setShipping_fee($value){
        $this->data['shipping_fee'] = $value;
    }

    /**
     * @return mixed
     */
    public function getShipping_fee(){
        return $this->data['shipping_fee'];
    }
}