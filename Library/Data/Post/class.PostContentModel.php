<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:35
 */

namespace Data\Post;


use Core\Model;

class PostContentModel extends Model
{
    protected $table = 'member_content';

    /**
     * PostContentModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}