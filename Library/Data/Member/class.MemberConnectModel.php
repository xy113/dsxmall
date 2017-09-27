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
     * MemberConnectModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}