<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午11:43
 */

namespace Model\Home;


use Data\Item\Builder\ItemContentBuilder;
use Data\Item\ItemModel;

class TestController extends BaseController
{
    /**
     *
     */
    public function index(){
        $model = new ItemModel();
        $itemlist = $model->limit(0, 10)->field('itemid,title')->select();
        print_array($itemlist);

        $content = new ItemContentBuilder(array('a'=>111));
        print_array($content->getData());
    }
}