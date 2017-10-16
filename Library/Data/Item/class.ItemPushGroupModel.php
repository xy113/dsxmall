<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/13
 * Time: 下午4:35
 */

namespace Data\Item;


use Core\Model;

class ItemPushGroupModel extends Model
{
    protected $table = 'item_push_group';

    /**
     * @return bool|mixed
     */
    public function setCache(){
        $datalist = $this->select();
        return cache('item_push_groups', $datalist);
    }

    /**
     * @return bool|mixed
     */
    public function getCache(){
        $datalist = cache('item_push_groups');
        if (is_array($datalist)) {
            return $datalist;
        }else{
            $this->setCache();
            return $this->getCache();
        }
    }
}