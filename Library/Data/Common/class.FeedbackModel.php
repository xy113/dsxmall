<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:53
 */

namespace Data\Common;


use Core\Model;

class FeedbackModel extends Model
{
    protected $table = 'feedback';

    /**
     * @return FeedbackModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }
}