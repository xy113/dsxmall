<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:55
 */

namespace Data\Common;


use Core\Model;

class BlockItem extends Model
{
    protected $table = 'block_item';

    /**
     * BlockItem constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}