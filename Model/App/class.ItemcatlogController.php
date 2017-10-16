<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/16
 * Time: 上午10:50
 */

namespace Model\App;


use Data\Item\ItemCatlogModel;

class ItemcatlogController extends BaseController
{
    /**
     * 目录分了
     */
    public function index(){
        global $_G,$_lang;

        $catloglist = (new ItemCatlogModel())->getCatlogTree();
        include view('item_catlog');
    }
}