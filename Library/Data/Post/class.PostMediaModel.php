<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:39
 */

namespace Data\Post;


use Core\Model;

class PostMediaModel extends Model
{
    protected $table = 'post_media';

    /**
     * PostMediaModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}