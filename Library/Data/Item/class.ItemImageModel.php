<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午5:03
 */

namespace Data\Item;


use Core\Model;
use Data\Item\Builder\ItemImageContentBuilder;

class ItemImageModel extends Model
{

    protected $table = 'item_image';
    /**
     * 单例
     * @return ItemImageModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }

    /**
     * @param ItemImageContentBuilder $object
     * @return bool|int|\mysqli_result|string
     * @throws \Exception
     */
    public function insertObject(ItemImageContentBuilder $object){
        if (!$object->getUid()){
            throw new \Exception('Empty uid value');
        }

        if (!$object->getItemid()){
            throw new \Exception('Empty itemid value');
        }

        if (!$object->getThumb()) {
            throw new \Exception('Empty thumb value');
        }

        if (!$object->getImage()){
            throw new \Exception('Empty image value');
        }
        return $this->add($object->getData(), true);
    }
}