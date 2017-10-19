<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:58
 */

namespace Data\Common;


use Core\Model;

class VerifyModel extends Model
{
    protected $table = 'verify';

    /**
     * @return VerifyModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }
}