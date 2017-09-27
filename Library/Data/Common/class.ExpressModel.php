<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:54
 */

namespace Data\Common;


use Core\Model;

class ExpressModel extends Model
{
    protected $table = 'express';

    /**
     * ExpressModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}