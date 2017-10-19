<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:48
 */

namespace Data\Common;


use Core\Model;

class PageModel extends Model
{
    protected $table = 'page';

    /**
     * @return PageModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }
}