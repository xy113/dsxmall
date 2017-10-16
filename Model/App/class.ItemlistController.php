<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/14
 * Time: 上午9:36
 */

namespace Model\App;


use Data\Common\BlockModel;
use Data\Item\ItemCatlogModel;
use Data\Item\ItemModel;

class ItemlistController extends BaseController
{
    /**
     *
     */
    public function index(){
        global $_G,$_lang;

        $condition = array('on_sale'=>1);
        $catid = intval($_GET['catid']);
        if ($catid) {
            $condition['catid'] = $catid;
            $catlog = (new ItemCatlogModel())->where(array('catid'=>$catid))->getOne();
            $this->var['title'] = $catlog['name'];
        }else {
            $this->var['新品上架'];
        }

        $itemModel = new ItemModel();
        $itemlist = $itemModel->where($condition)->limit(0, 50)->order('sold DESC,itemid ASC')->select();

        $blockModel = new BlockModel();
        $slide_list = $blockModel->getCache(4);

        include template('itemlist');
    }
}