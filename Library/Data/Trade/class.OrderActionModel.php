<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:19
 */

namespace Data\Trade;


use Core\Model;

class OrderActionModel extends Model
{
    protected $table = 'order_action';

    /**
     * OrderActionModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}