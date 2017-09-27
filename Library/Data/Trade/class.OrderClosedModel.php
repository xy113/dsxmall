<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:20
 */

namespace Data\Trade;


use Core\Model;

class OrderClosedModel extends Model
{
    protected $table = 'order_closed';

    /**
     * OrderClosedModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}