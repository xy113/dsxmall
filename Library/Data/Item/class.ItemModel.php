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
     * @param ItemContentBuilder $item
     * @return bool|int|\mysqli_result|string
     * @throws \Exception
     */
    public function insertObject(ItemContentBuilder $item){
        if (!$item->getUid()){
            throw new \Exception('Empty uid value');
        }
        if (!$item->getShop_id()){
            throw new \Exception('Empty shop_id value');
        }
        if (!$item->getCatid()){
            throw new \Exception('Empty catid value');
        }
        /*
        if (!$item->getTitle()) {
            throw new \Exception('Empty title value');
        }*/
        if (!$item->getCreate_time()){
            $item->setCreate_time(time());
        }
        return $this->add($item->getData(), true);
    }

    /**
     * @param $itemid
     * @return $this
     */
    public function deleteObject($itemid){
        return $this->where(array('itemid'=>$itemid));
    }

    /**
     * @param $itemid
     * @return array|null
     */
    public function getObject($itemid){
        $data = $this->where(array('itemid'=>$itemid))->getOne();
        return $data ? $data : array();
    }
}