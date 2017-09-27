<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午5:20
 */

namespace Data\Item;


use Core\Model;
use Data\Item\Builder\ItemCatlogContentBuilder;

class ItemCatlogModel extends Model
{
    /**
     * ItemCatlogController constructor.
     * @param string $name
     */
    function __construct($name = 'item_catlog')
    {
        parent::__construct($name);
    }

    /**
     * @param ItemCatlogContentBuilder $object
     * @return bool|int|\mysqli_result|string
     * @throws \Exception
     */
    public function insertObject(ItemCatlogContentBuilder $object){
        if (!$object->getName()){
            throw new \Exception('Empty name value');
        }
        return $this->add($object->getData(), true);
    }
}