<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/13
 * Time: 下午12:11
 */

namespace Data\Common;


use Core\Model;

class AlbumModel extends Model
{
    protected $table = 'album';

    /**
     * @return AlbumModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }
}