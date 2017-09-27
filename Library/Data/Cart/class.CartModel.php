<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:59
 */

namespace Data\Cart;


use Core\Model;

class CartModel extends Model
{
    protected $table = 'cart';

    /**
     * CartModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}