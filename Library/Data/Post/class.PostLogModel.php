<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:38
 */

namespace Data\Post;


use Core\Model;

class PostLogModel extends Model
{
    protected $table = 'post_log';

    /**
     * PostLogModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}