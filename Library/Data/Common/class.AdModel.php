<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:51
 */

namespace Data\Common;


use Core\Model;

class AdModel extends Model
{
    protected $table = 'ad';

    /**
     * AdModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}