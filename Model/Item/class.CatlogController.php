<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/20
 * Time: 下午1:58
 */

namespace Model\Item;


use Data\Item\ItemCatlogModel;

class CatlogController extends BaseController
{
    /**
     * 产品分类
     */
    public function index(){
        global $_G,$_lang;

        $catlogList = ItemCatlogModel::getInstance()->getCatlogTree();
        $this->var['title'] = '产品分类';
        include view('catlog');
    }
}