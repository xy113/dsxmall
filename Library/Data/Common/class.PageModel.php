<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:48
 */

namespace Data\Common;


use Core\Model;

class PageModel extends Model
{
    protected $table = 'page';

    /**
     * PageModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}