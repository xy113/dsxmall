<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:54
 */

namespace Data\Common;


use Core\Model;

class ExpressModel extends Model
{
    protected $table = 'express';

    /**
     * @return ExpressModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }
}