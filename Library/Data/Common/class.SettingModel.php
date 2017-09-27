<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:47
 */

namespace Data\Common;


use Core\Model;

class SettingModel extends Model
{
    protected $table = 'setting';

    /**
     * SettingModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}