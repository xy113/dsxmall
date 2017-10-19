<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午10:19
 */

namespace Data\Member;


use Core\Model;

class ScanLoginModel extends Model
{
    protected $table = 'scan_login';

    /**
     * @return ScanLoginModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }
}