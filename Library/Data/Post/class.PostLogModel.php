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
     * @return PostLogModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }
}