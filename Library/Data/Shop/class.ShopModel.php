<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:06
 */

namespace Data\Shop;


use Core\Model;

class ShopModel extends Model
{
    protected $table = 'shop';

    /**
     * ShopModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}