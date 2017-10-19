<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:44
 */

namespace Data\Common;


use Core\Model;

class MaterialModel extends Model
{
    protected $table = 'material';

    /**
     * @return MaterialModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }
}