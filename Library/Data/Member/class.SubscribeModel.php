<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午10:18
 */

namespace Data\Member;


use Core\Model;

class SubscribeModel extends Model
{
    protected $table = 'subscribe';

    /**
     * @return SubscribeModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }
}