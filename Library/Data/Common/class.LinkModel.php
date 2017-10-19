<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:50
 */

namespace Data\Common;


use Core\Model;

class LinkModel extends Model
{
    protected $table = 'link';

    /**
     * @return LinkModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }

    /**
     *
     */
    public function updateCache(){
        $categorylist = $this->where(array('type'=>'categry'))->select();
        cache('link_category', $categorylist);
        $itemlist = $this->where(array('type'=>'item'))->select();
        cache('link_item', $itemlist);
    }

    /**
     * @return bool|mixed
     */
    public function getCategoryCache(){
        $categorylist = cache('link_category');
        if (!is_array($categorylist)) {
            $this->updateCache();
            return $this->getCategoryCache();
        }else {
            return $categorylist;
        }
    }

    /**
     * @return bool|mixed
     */
    public function getItemCache(){
        $itemlist = cache('link_item');
        if (!is_array($itemlist)) {
            $this->updateCache();
            return $this->getItemCache();
        }else {
            return $itemlist;
        }
    }
}