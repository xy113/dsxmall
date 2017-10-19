<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:15
 */

namespace Data\Trade;


use Core\Model;

class OrderItemModel extends Model
{
    protected $table = 'order_item';

    /**
     * @return OrderItemModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }
}