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
     * MemberTokenModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}