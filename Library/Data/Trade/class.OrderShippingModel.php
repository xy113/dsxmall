<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:16
 */

namespace Data\Trade;


use Core\Model;

class OrderShippingModel extends Model
{
    protected $table = 'order_shipping';

    /**
     * OrderShippingModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}