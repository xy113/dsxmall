<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:10
 */

namespace Data\Shop;


use Core\Model;

class ShopInfoModel extends Model
{
    protected $table = 'shop_info';

    /**
     * ShopInfoModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}