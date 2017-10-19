<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:52
 */

namespace Data\Common;


use Core\Model;

class DistrictModel extends Model
{
    protected $table = 'district';

    /**
     * @return DistrictModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }
}