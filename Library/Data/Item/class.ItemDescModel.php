<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午4:52
 */

namespace Data\Item;


use Core\Model;
use Data\Item\Builder\ItemDescContentBuilder;

class ItemDescModel extends Model
{
    protected $table = 'item_desc';

    /**
     * @return ItemDescModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }

    /**
     * @param ItemDescContentBuilder $object
     * @return bool|int|\mysqli_result|string
     * @throws \Exception
     */
    public function insertObject(ItemDescContentBuilder $object){
        if (!$object->getUid()) {
            throw new \Exception('Empty uid value');
        }
        if (!$object->getItemid()) {
            throw new \Exception('Empty itemid value');
        }
        if (!$object->getContent()){
            throw new \Exception('Empty content value');
        }
        if (!$object->getUpdate_time()){
            $object->setUpdate_time(time());
        }
        return $this->add($object->getData(), true);
    }
}