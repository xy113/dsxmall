<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午4:29
 */

namespace Data\Item;


use Core\Model;
use Data\Item\Object\ItemObject;

class ItemModel extends Model
{

    protected $table = 'item';

    /**
     * 单例
     * @return ItemModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }

    /**
     * @param ItemObject $object
     * @return bool|int|\mysqli_result|string
     * @throws \Exception
     */
    public function addObject(ItemObject $object){
        if (!$object->getUid()) {
            throw new \Exception('Empty uid value');
        }

        if (!$object->getCatid()) {
            throw new \Exception('Empty catid value');
        }

        if (!$object->getShopId()) {
            throw new \Exception('Empty shop_id value');
        }

        if (!$object->getTitle()) {
            throw new \Exception('Empty title value');
        }

        if (!$object->getItemSn()) {
            //throw new \Exception('Empty item_sn value');
            $object->setItemSn($this->createSn());
        }

        if (!$object->getThumb()) {
            throw new \Exception('Empty thumb value');
        }

        if (!$object->getImage()) {
            throw new \Exception('Empty image value');
        }

        if (!$object->getPrice()){
            throw new \Exception('Empty price value');
        }

        if (!$object->getCreateTime()) {
            $object->setCreateTime(time());
        }
        return $this->data($object->getBizContent())->add();
    }


    /**
     * @param ItemObject $object
     * @return bool|int
     */
    public function updateObject(ItemObject $object){
        if (!$object->getUpdateTime()) {
            $object->setUpdateTime(time());
        }
        return $this->data($object->getBizContent())->save();
    }

    /**
     * @return ItemObject
     */
    public function getObject(){
        $data = $this->getOne();
        return new ItemObject($data);
    }

    /**
     * @param $itemid
     */
    public function deleteAllData($itemid){
        $condition = array('itemid'=>$itemid);
        $this->where($condition)->delete();
        (new ItemDescModel())->where($condition)->delete();
        (new ItemImageModel())->where($condition)->delete();
        (new ItemRecommendModel())->where($condition)->delete();
    }

    /**
     * @param $itemid
     * @param $num
     * @param int $type
     * @return bool|int
     */
    public function updateView_num($itemid, $num=1, $type=1){
        if ($type) {
            return $this->where(array('itemid'=>$itemid))->update("`view_num`=`view_num`+$num");
        }else {
            return $this->where(array('itemid'=>$itemid))->update("`view_num`=`view_num`-$num");
        }
    }

    /**
     * @param $itemid
     * @param $sold
     * @param int $type
     * @return bool|int
     */
    public function updateSold($itemid, $sold=1, $type=1){
        if ($type) {
            return $this->where(array('itemid'=>$itemid))->update("`sold`=`sold`+$sold");
        }else {
            return $this->where(array('itemid'=>$itemid))->update("`sold`=`sold`-$sold");
        }
    }

    /**
     * @param $itemid
     * @param int $num
     * @param int $type
     * @return bool|int
     */
    public function updateCollection_num($itemid, $num=1, $type=1){
        if ($type) {
            return $this->where(array('itemid'=>$itemid))->update("`collection_num`=`collection_num`+$num");
        }else {
            return $this->where(array('itemid'=>$itemid))->update("`collection_num`=`collection_num`-$num");
        }
    }

    /**
     * @param $itemid
     * @param int $num
     * @param int $type
     * @return bool|int
     */
    public function updateReview_num($itemid, $num=1, $type=1){
        if ($type) {
            return $this->where(array('itemid'=>$itemid))->update("`review_num`=`review_num`+$num");
        }else {
            return $this->where(array('itemid'=>$itemid))->update("`review_num`=`review_num`-$num");
        }
    }

    /**
     * @return array
     */
    public function selectNew(){
        return $this->order('itemid', 'DESC')->select();
    }

    /**
     * @return array
     */
    public function selectHot(){
        return $this->order('sold', 'DESC')->select();
    }

    /**
     * 生成商品序列表
     * @return string
     */
    public function createSn(){
        return time().rand(100,999).rand(100,999);
    }
}