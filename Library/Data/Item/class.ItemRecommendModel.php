<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/28
 * Time: 下午2:50
 */

namespace Data\Item;


use Core\Model;

class ItemRecommendModel extends Model
{
    protected $table = 'item_recommend';

    /**
     * @return ItemRecommendModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }

    /**
     * @param $itemid
     * @return bool|int|\mysqli_result|string
     */
    public function addItem($itemid){
        return $this->data(array('itemid'=>$itemid))->add(null, false, true);
    }
}