<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午10:16
 */

namespace Data\Shop;


use Core\Model;

class ShopRecordModel extends Model
{
    protected $table = 'shop_record';

    /**
     * @return ShopRecordModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }
}