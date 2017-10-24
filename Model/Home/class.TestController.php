<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午11:43
 */

namespace Model\Home;


use Core\DB_Mysqli;
use Data\Item\ItemModel;
use Data\Post\PostItemModel;
use Prophecy\Exception\Exception;

class TestController extends BaseController
{
    /**
     *
     */
    public function index(){
        $object = PostItemModel::getInstance()->where(array('aid'=>10336))->getObject();
    }
}