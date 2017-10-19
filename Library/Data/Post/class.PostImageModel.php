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
     * @return PostImageModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }
}