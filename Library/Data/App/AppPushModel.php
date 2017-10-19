<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午10:01
 */

namespace Data\App;


use Core\Model;

class AppPushModel extends Model
{
    protected $table = 'app_push';

    /**
     * @return AppPushModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }
}