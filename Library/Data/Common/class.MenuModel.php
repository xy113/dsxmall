<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:49
 */

namespace Data\Common;


use Core\Model;

class MenuModel extends Model
{
    protected $table = 'menu';

    /**
     * MenuModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}