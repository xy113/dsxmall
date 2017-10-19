<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/13
 * Time: 下午4:34
 */

namespace Data\Item;


use Core\Model;

class ItemPushModel extends Model
{
    protected $table = 'item_push';

    /**
     * @return ItemPushModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }
}