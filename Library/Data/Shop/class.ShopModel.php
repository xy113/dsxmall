<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:06
 */

namespace Data\Shop;


use Core\Model;
use Data\Shop\Builder\ShopContentBuilder;

class ShopModel extends Model
{
    protected $table = 'shop';

    /**
     * @return ShopModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }

    /**
     * @param ShopContentBuilder $object
     * @return bool|int|\mysqli_result|string
     * @throws \Exception
     */
    public function insertObject(ShopContentBuilder $object){

        if (!$object->getUid()){
            throw new \Exception('Empty uid value');
        }

        if (!$object->getUsername()){
            throw new \Exception('Empty username value');
        }

        if (!$object->getShop_name()){
            throw new \Exception('Empty shop_name value');
        }

        if (!$object->getCreate_time()){
            $object->setCreate_time(time());
        }

        return $this->add($object->getBizContent(), true);
    }

    /**
     * @param $shop_id
     * @return ShopContentBuilder
     */
    public function getObject($shop_id){
        $data = $this->where(array('shop_id'=>$shop_id))->getOne();
        $object = new ShopContentBuilder($data);
        return $object;
    }

    /**
     * @param $shop_id
     */
    public function deleteObject($shop_id){
        if ($this->where(array('shop_id'=>$shop_id))->delete()){
            (new ShopDescModel())->where(array('shop_id'=>$shop_id))->delete();
            (new ShopAuthModel())->where(array('shop_id'=>$shop_id))->delete();
            (new ShopRecordModel())->where(array('shop_id'=>$shop_id))->delete();
        }
    }

    /**
     * @param $shop_id
     * @param int $num
     * @param int $type
     * @return bool|int
     */
    public function updateView_num($shop_id, $num=1, $type=1){
        if ($type) {
            return $this->where(array('shop_id'=>$shop_id))->update("`view_num`=`view_num`+$num");
        }else {
            return $this->where(array('shop_id'=>$shop_id))->update("`view_num`=`view_num`-$num");
        }
    }

    /**
     * @param $shop_id
     * @param int $sold
     * @param int $type
     * @return bool|int
     */
    public function updateTotalSold($shop_id, $sold=1, $type=1){
        if ($type) {
            return $this->where(array('shop_id'=>$shop_id))->update("`total_sold`=`total_sold`+$sold");
        }else {
            return $this->where(array('shop_id'=>$shop_id))->update("`total_sold`=`total_sold`-$sold");
        }
    }

    /**
     * @param $shop_id
     * @param int $num
     * @param int $type
     * @return bool|int
     */
    public function updateCollection_num($shop_id, $num=1, $type=1){
        if ($type) {
            return $this->where(array('shop_id'=>$shop_id))->update("`collection_num`=`collection_num`+$num");
        }else {
            return $this->where(array('shop_id'=>$shop_id))->update("`collection_num`=`collection_num`-$num");
        }
    }

    /**
     * @param $shop_id
     * @param int $num
     * @param int $type
     * @return bool|int
     */
    public function updateSubscribe_num($shop_id, $num=1, $type=1){
        if ($type) {
            return $this->where(array('shop_id'=>$shop_id))->update("`subscribe_num`=`subscribe_num`+$num");
        }else {
            return $this->where(array('shop_id'=>$shop_id))->update("`subscribe_num`=`subscribe_num`-$num");
        }
    }
}