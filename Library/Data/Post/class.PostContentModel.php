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
    protected $table = 'post_content';

    /**
     * @return PostContentModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }
}