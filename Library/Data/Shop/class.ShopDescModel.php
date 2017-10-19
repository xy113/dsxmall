<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午10:15
 */

namespace Data\Shop;


use Core\Model;

class ShopDescModel extends Model
{
    protected $table = 'shop_desc';

    /**
     * @return ShopDescModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }
}