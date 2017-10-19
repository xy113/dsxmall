<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午10:01
 */

namespace Data\Weixin;


use Core\Model;

class WeixinMenuModel extends Model
{
    protected $table = 'weixin_menu';

    /**
     * @return WeixinMenuModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }
}