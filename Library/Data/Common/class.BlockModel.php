<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:56
 */

namespace Data\Common;


use Core\Model;

class BlockModel extends Model
{
    protected $table = 'block';

    /**
     * @return BlockModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }

    /**
     * @param $block_id
     * @return bool|mixed
     */
    public function setCache($block_id){
        $itemlist = (new BlockItemModel())->where(array('block_id'=>$block_id))->order('displayorder ASC,id ASC')->select();
        return cache('block_items_'.$block_id, $itemlist);
    }

    /**
     * @param $block_id
     * @return bool|mixed
     */
    public function getCache($block_id){
        $cache = cache('block_items_'.$block_id);
        if (is_array($cache)) {
            return $cache;
        }else {
            $this->setCache($block_id);
            return $this->getCache($block_id);
        }
    }
}