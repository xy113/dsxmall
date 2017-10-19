<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:28
 */

namespace Data\Member;


use Core\Model;

class MemberStatusModel extends Model
{
    protected $table = 'member_status';

    /**
     * @return MemberStatusModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }
}