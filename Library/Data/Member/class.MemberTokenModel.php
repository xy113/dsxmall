<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:30
 */

namespace Data\Member;


use Core\Model;

class MemberTokenModel extends Model
{
    protected $table = 'member_token';

    /**
     * @return MemberTokenModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }
}