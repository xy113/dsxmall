<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/11
 * Time: 下午5:36
 */

namespace Data\Common;


use Core\Model;

class ApnsTokenModel extends Model
{
    protected $table = 'apns_token';

    /**
     * @return ApnsTokenModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }
}