<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:36
 */

namespace Data\Post;


use Core\Model;

class PostImageModel extends Model
{
    protected $table = 'post_image';

    /**
     * PostImageModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}