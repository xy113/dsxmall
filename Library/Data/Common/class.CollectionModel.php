<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:57
 */

namespace Data\Common;


use Core\Model;

class CollectionModel extends Model
{
    protected $table = 'collection';

    /**
     * @return CollectionModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }
}