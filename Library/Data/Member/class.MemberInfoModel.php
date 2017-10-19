<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:25
 */

namespace Data\Member;


use Core\Model;

class MemberInfoModel extends Model
{
    protected $table = 'member_info';

    /**
     * @return MemberInfoModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }
}