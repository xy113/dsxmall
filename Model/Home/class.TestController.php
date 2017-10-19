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
use Prophecy\Exception\Exception;

class TestController extends BaseController
{
    /**
     *
     */
    public function index(){
        $itemlist = M('item')->where(array('itemid'=>72))->getOne();
        print_array($itemlist);
        ItemModel::getInstance()->limit(0, 10)->select();
        $e = new \Exception('');

        try{

        }catch (\Exception $e){

        }
    }
}