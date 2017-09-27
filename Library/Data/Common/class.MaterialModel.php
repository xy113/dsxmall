<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:44
 */

namespace Data\Common;


use Core\Model;

class MaterialModel extends Model
{
    protected $table = 'material';

    /**
     * MaterialModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}