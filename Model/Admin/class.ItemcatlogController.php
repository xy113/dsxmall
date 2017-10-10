<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/9
 * Time: 下午4:58
 */

namespace Model\Admin;


use Core\Pinyin;
use Data\Item\ItemCatlogModel;
use Data\Item\ItemModel;

class ItemcatlogController extends BaseController
{
    /**
     *
     */
    public function index(){
        $this->itemlist();
    }

    /**
     *
     */
    public function itemlist(){
        global $_G,$_lang;

        if ($this->checkFormSubmit()) {
            $catloglist = $_GET['catloglist'];
            if ($catloglist && is_array($catloglist)){
                $catlogModel = new ItemCatlogModel();
                foreach ($catloglist as $catid=>$catlog){
                    if ($catlog['name']) {
                        $catlogModel->where(array('catid'=>$catid))->data($catlog)->save();
                    }
                }
                $catlogModel->updateCache();
            }
            $this->showSuccess('update_succeed');
        }else {

            $catloglist = $this->getCatlogList();
            include template('item/catlog_list');
        }
    }

    /**
     * 添加分类
     */
    public function add(){
        global $_G,$_lang;

        if ($this->checkFormSubmit()){
            $catlog = $_GET['catlog'];
            if ($catlog['name']) {
                $pinyin = new Pinyin();
                $catlog['identifer'] = $pinyin->getPinyin($catlog['name']);

                $catlogModel = new ItemCatlogModel();
                $catlogModel->data($catlog)->add();
                $catlogModel->updateCache();
                $this->showSuccess('save_succeed', null, array(
                    array('text'=>'continue_add', 'url'=>curPageURL()),
                    array('text'=>'back_list', 'url'=>U('c=postcatlog&a=index'))
                ));
            }else {
                $this->showError('invalid_parameter');
            }
        }else {

            $catloglist = $this->getCatlogList();
            include template('item/catlog_form');
        }
    }

    /**
     * 编辑分类
     */
    public function edit(){
        global $_G, $_lang;

        $catid = intval($_GET['catid']);
        $catlogModel = new ItemCatlogModel();

        if ($this->checkFormSubmit()){
            $catlog = $_GET['catlog'];
            if ($catlog['name']) {
                $pinyin = new Pinyin();
                $catlog['identifer'] = $pinyin->getPinyin($catlog['name']);

                $catlogModel->where(array('catid'=>$catid))->data($catlog)->save();
                $catlogModel->updateCache();
                $this->showSuccess('update_succeed', null, array(
                    array('text'=>'reedit', 'url'=>curPageURL()),
                    array('text'=>'back_list', 'url'=>U('c=postcatlog&a=index'))
                ));
            }else {
                $this->showError('invalid_parameter');
            }
        }else {

            $catlog = $catlogModel->where(array('catid'=>$catid))->getOne();
            $catloglist = $this->getCatlogList();

            include template('item/catlog_form');
        }
    }

    /**
     * 删除分类
     */
    public function delete(){
        global $_G, $_lang;

        $catid = intval($_GET['catid']);
        $catlogModel = new ItemCatlogModel();
        if ($this->checkFormSubmit()){
            $moveto = intval($_GET['moveto']);
            $deleteChilds = intval($_GET['deleteChilds']);

            if (!$deleteChilds && !$moveto){
                $this->showError('invalid_parameter');
            }

            $childIds = $catlogModel->getAllChildIds($catid);
            if ($catlogModel->where(array('catid'=>$catid))->delete()){
                if ($deleteChilds) {
                    foreach ($childIds as $catid){
                        $catlogModel->where(array('catid'=>$catid))->delete();
                    }
                    $itemModel = new ItemModel();
                    $itemlist = $itemModel->where(array('catid'=>array('IN', implodeids($childIds))))->select();
                    foreach ($itemlist as $item){
                        $itemModel->deleteAllData($item['itemid']);
                    }
                }else {
                    foreach ($catlogModel->where(array('fid'=>$catid))->select() as $catlog){
                        $catlogModel->where(array('catid'=>$catlog['catid']))->data(array('fid'=>$moveto))->save();
                    }
                    $itemModel = new ItemModel();
                    $itemModel->where(array('catid'=>$catid))->data(array('catid'=>$moveto))->save();
                }
                $catlogModel->updateCache();
            }
            $this->showSuccess('delete_succeed', null, array(
                array('text'=>'back_list', 'url'=>U('c=postcatlog&a=index'))
            ));
        }else {

            $catlog = $catlogModel->where(array('catid'=>$catid))->getOne();
            $catloglist = $this->getCatlogList();
            include template('item/catlog_delete');
        }
    }

    /**
     * 合并分类
     */
    public function merge(){
        global $_G, $_lang;

        if ($this->checkFormSubmit()){
            $target = intval($_GET['target']);
            $source = $_GET['source'];
            if (is_array($source)) {
                $itemModel = new ItemModel();
                $catlogModel = new ItemCatlogModel();
                foreach ($source as $catid){
                    if ($catid != $target){
                        $itemModel->where(array('catid'=>$catid))->data(array('catid'=>$target))->save();
                        $catlogModel->where(array('catid'=>$catid))->delete();
                    }
                }
                $catlogModel->updateCache();
            }
            $this->showSuccess('update_succeed', null, array(
                array('text'=>'back_list', 'url'=>U('c=postcatlog&a=index'))
            ));
        }else {

            $catloglist = $this->getCatlogList();
            include template('item/catlog_merge');
        }
    }

    /**
     *
     */
    public function seticon(){
        $catid = intval($_GET['catid']);
        $icon = htmlspecialchars($_GET['icon']);
        if ($catid && $icon){
            (new ItemCatlogModel())->where(array('catid'=>$catid))->data(array('icon'=>$icon))->save();
        }
        $this->showAjaxReturn();
    }

    /**
     * @return array
     */
    private function getCatlogList(){
        $catlogModel = new ItemCatlogModel();
        $catloglist = array();
        foreach ($catlogModel->order('displayorder ASC,catid ASC')->select() as $catlog){
            $catloglist[$catlog['fid']][$catlog['catid']] = $catlog;
        }
        return $catloglist;
    }
}