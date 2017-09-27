<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:52
 */

namespace Data\Common;


use Core\Model;

class DistrictModel extends Model
{
    protected $table = 'district';

    /**
     * DistrictModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}