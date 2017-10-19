<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:51
 */

namespace Data\Common;


use Core\Model;

class AdModel extends Model
{
    protected $table = 'ad';

    /**
     * @return AdModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }
}