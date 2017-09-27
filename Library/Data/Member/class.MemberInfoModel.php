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
     * MemberInfoModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}