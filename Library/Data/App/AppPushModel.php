<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午10:01
 */

namespace Data\App;


use Core\Model;

class AppPushModel extends Model
{
    protected $table = 'app_push';

    /**
     * AppPushModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}