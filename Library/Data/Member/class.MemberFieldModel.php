<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:24
 */

namespace Data\Member;


use Core\Model;

class MemberFieldModel extends Model
{
    protected $table = 'member_field';

    /**
     * @return MemberFieldModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }
}