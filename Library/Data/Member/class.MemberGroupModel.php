<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:26
 */

namespace Data\Member;


use Core\Model;

class MemberGroupModel extends Model
{
    protected $table = 'member_group';

    /**
     * MemberGroupModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}