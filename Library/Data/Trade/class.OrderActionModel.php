<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:19
 */

namespace Data\Trade;


use Core\Model;
use Data\Trade\Object\OrderActionObject;

class OrderActionModel extends Model
{
    protected $table = 'order_action';

    /**
     * @return OrderActionModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }

    /**
     * @param OrderActionObject $object
     * @return bool|int|\mysqli_result|string
     */
    public function addObject(OrderActionObject $object) {
        return $this->data($object->getBizContent())->add();
    }
}