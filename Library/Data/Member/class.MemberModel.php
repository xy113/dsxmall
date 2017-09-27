<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:21
 */

namespace Data\Member;


use Core\Model;

class MemberModel extends Model
{
    protected $table = 'member';

    /**
     * MemberModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}