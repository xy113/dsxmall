<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:09
 */

namespace Data\Shop;


use Core\Model;

class ShopAuthModel extends Model
{
    protected $table = 'shop_auth';

    /**
     * ShopAuthModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}