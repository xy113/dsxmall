<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:18
 */

namespace Data\Trade;


use Core\Model;

class OrderRefundModel extends Model
{
    protected $table = 'order_refund';

    /**
     * @return OrderRefundModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }
}