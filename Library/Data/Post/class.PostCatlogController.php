<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:37
 */

namespace Data\Post;


use Core\Model;

class PostCatlogController extends Model
{
    protected $table = 'post_catlog';

    /**
     * PostCatlogController constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}