<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:50
 */

namespace Data\Common;


use Core\Model;

class LinkModel extends Model
{
    protected $table = 'link';

    /**
     * LinkModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}