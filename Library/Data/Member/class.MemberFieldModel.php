<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:24
 */

namespace Data\Member;


use Core\Model;

class MemberFieldModel extends Model
{
    protected $table = 'member_field';

    /**
     * MemberFieldModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}