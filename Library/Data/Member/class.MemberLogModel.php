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
     * MemberLogModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}