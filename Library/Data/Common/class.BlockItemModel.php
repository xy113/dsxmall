<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:55
 */

namespace Data\Common;


use Core\Model;

class BlockItemModel extends Model
{
    protected $table = 'block_item';

    /**
     * @return BlockItemModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }
}