<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:28
 */

namespace Data\Member;


use Core\Model;

class MemberStatModel extends Model
{
    protected $table = 'member_stat';

    /**
     * MemberStatModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}