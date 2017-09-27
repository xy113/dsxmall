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
    function __construct($name = 'item_desc')
    {
        parent::__construct($name);
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