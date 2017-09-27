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
     * OrderRefundModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}