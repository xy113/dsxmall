<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:29
 */

namespace Data\Member;


use Core\Model;

class MemberLogModel extends Model
{
    protected $table = 'member_log';

    /**
     * @return MemberLogModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }
}