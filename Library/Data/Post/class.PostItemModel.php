<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:34
 */

namespace Data\Post;


use Core\Model;
use Data\Post\Object\PostItemObject;

class PostItemModel extends Model
{
    protected $table = 'post_item';

    /**
     * @return PostItemModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }

    /**
     * @param PostItemObject $object
     * @return bool|int|\mysqli_result|string
     * @throws \Exception
     */
    public function addObject(PostItemObject $object){
        if (!$object->getUid()) {
            throw new \Exception('Empty uid value');
        }

        if (!$object->getUsername()) {
            throw new \Exception('Empty username value');
        }

        if (!$object->getCatid()) {
            throw new \Exception('Empty catid value');
        }

        if (!$object->getAuthor()) {
            $object->setAuthor($object->getUsername());
        }

        if (!$object->getType()) {
            $object->setType('article');
        }

        if (!$object->getTitle()) {
            throw new \Exception('Empty title value');
        }

        if (!$object->getPubtime()) {
            $object->setPubtime(time());
        }
        return $this->data($object->getBizContent())->add();
    }

    /**
     * @param PostItemObject $object
     * @return bool|int
     */
    public function updateObject(PostItemObject $object){
        if (!$object->getModified()) {
            $object->setModified(time());
        }
        return $this->data($object->getBizContent())->save();
    }

    /**
     * @return PostItemObject
     */
    public function getObject(){
        $data = $this->getOne();
        return new PostItemObject($data);
    }

    /**
     * @param $aid
     */
    public function deleteAllData($aid){
        if ($this->where(array('aid'=>$aid))->delete()){
            PostContentModel::getInstance()->where(array('aid'=>$aid))->delete();
            PostImageModel::getInstance()->where(array('aid'=>$aid))->delete();
            PostMediaModel::getInstance()->where(array('aid'=>$aid))->delete();
            PostLogModel::getInstance()->where(array('aid'=>$aid))->delete();
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