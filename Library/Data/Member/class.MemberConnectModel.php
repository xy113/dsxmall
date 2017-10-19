<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:23
 */

namespace Data\Member;


use Core\Model;

class MemberConnectModel extends Model
{
    protected $table = 'member_connect';

    /**
     * @return MemberConnectModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }
}