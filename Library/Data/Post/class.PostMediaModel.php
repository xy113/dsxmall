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
     * @return PostMediaModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }
}