<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:56
 */

namespace Data\Common;


use Core\Model;

class BlockModel extends Model
{
    protected $table = 'block';

    /**
     * BlockModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}