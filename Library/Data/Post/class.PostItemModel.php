<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:34
 */

namespace Data\Post;


use Core\Model;

class PostItemModel extends Model
{
    protected $table = 'post_item';

    /**
     * PostItemModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }

    /**
     * @param $aid
     */
    public function deleteAllData($aid){
        if ($this->where(array('aid'=>$aid))->delete()){
            (new PostContentModel())->where(array('aid'=>$aid))->delete();
            (new PostImageModel())->where(array('aid'=>$aid))->delete();
            (new PostMediaModel())->where(array('aid'=>$aid))->delete();
            (new PostLogModel())->where(array('aid'=>$aid))->delete();
        }
    }

    /**
     * @param $aid
     * @param int $num
     * @param int $type
     * @return bool|int
     */
    public function updateView_num($aid, $num=1, $type=1){
        if ($type) {
            return $this->where(array('aid'=>$aid))->update("`view_num`=`view_num`+$num");
        }else {
            return $this->where(array('aid'=>$aid))->update("`view_num`=`view_num`-$num");
        }
    }
}