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
     * @return ShopAuthModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }
}