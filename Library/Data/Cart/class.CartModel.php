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
     * @return CartModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }
}