<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午4:29
 */

namespace Data\Item;


use Core\Model;
use Data\Item\Builder\ItemContentBuilder;

class ItemModel extends Model
{

    /**
     * ItemModel constructor.
     * @param string $name
     */
    function __construct($name = 'item')
    {
        parent::__construct($name);
    }

    /**
     * @param ItemContentBuilder $object
     * @return bool|int|\mysqli_result|string
     * @throws \Exception
     * @internal param ItemContentBuilder $item
     */
    public function insertObject(ItemContentBuilder $object){
        if (!$object->getUid()){
            throw new \Exception('Empty uid value');
        }
        if (!$object->getShop_id()){
            throw new \Exception('Empty shop_id value');
        }
        if (!$object->getCatid()){
            throw new \Exception('Empty catid value');
        }

        if (!$object->getItem_sn()){
            $object->setItem_sn($this->createSn());
        }
        /*
        if (!$object->getTitle()) {
            throw new \Exception('Empty title value');
        }*/
        if (!$object->getCreate_time()){
            $object->setCreate_time(time());
        }
        return $this->add($object->getBizContent(), true);
    }

    /**
     * @param $itemid
     * @param ItemContentBuilder $obejct
     */
    public function updateObject($itemid, ItemContentBuilder $obejct){
        $this->where(array('itemid'=>$itemid))->update($obejct->getBizContent());
    }

    /**
     * @param $itemid
     * @return ItemContentBuilder
     */
    public function deleteObject($itemid){
        if ($this->where(array('itemid'=>$itemid))->delete()){
            (new ItemImageModel())->where(array('itemid'=>$itemid))->delete();
            (new ItemDescModel())->where(array('itemid'=>$itemid))->delete();
        }
    }

    /**
     * @param $itemid
     * @return ItemContentBuilder
     */
    public function getObject($itemid){
        $data = $this->where(array('itemid'=>$itemid))->getOne();
        $object = new ItemContentBuilder($data);
        return $object;
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