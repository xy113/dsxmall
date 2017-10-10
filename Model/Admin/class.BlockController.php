<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/9
 * Time: 下午5:30
 */
namespace Model\Admin;
use Data\Common\BlockItemModel;
use Data\Common\BlockModel;

class BlockController extends BaseController{
    function __construct()
    {
        parent::__construct();
        G('menu', 'block');
    }

    /**
     *
     */
    public function index(){
        $this->namelist();
    }

    /**
     * 板块列表
     */
    public function namelist(){
        global $_G,$_lang;

        $model = new BlockModel();
        if ($this->checkFormSubmit()){
            $blocks = $_GET['blocks'];
            if ($blocks) {
                $itemModel = new BlockItemModel();
                foreach ($blocks as $block_id){
                    $model->where(array('block_id'=>$block_id))->delete();
                    $itemModel->where(array('block_id'=>$block_id))->delete();
                }
            }
            $this->showAjaxReturn();
        }else {
            $pagesize  = 20;
            $totalnum  = $model->count();
            $pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
            $blocklist = $model->page($_G['page'], $pagesize)->order('block_id')->select();
            $pagination = $this->pagination($_G['page'], $pagecount, $totalnum, null, true);

            $_G['title'] = $_lang['block_manage'];
            include template('block/block_list');
        }
    }

    /**
     * 保存块内容
     */
    public function save_block(){
        if ($this->checkFormSubmit()) {
            $block = $_GET['block'];
            $block_id = intval($_GET['block_id']);
            if ($block_id) {
                (new BlockModel())->where(array('block_id'=>$block_id))->data($block)->save();
            }else {
                (new BlockModel())->data($block)->add();
            }
            $this->showAjaxReturn();
        }
    }

    /**
     * 获取板块信息
     */
    public function get_block(){
        $block_id = intval($_GET['block_id']);
        $block = (new BlockModel())->where(array('block_id'=>$block_id))->getOne();
        $this->showAjaxReturn($block);
    }

    /**
     * 内容管理
     */
    public function itemlist(){
        global $_G,$_lang;

        $model = new BlockItemModel();
        $block_id = intval($_GET['block_id']);
        if ($this->checkFormSubmit()) {
            $eventType = trim($_GET['eventType']);
            if ($eventType === 'delete'){
                $delete = $_GET['delete'];
                if ($delete && is_array($delete)) {
                    foreach ($delete as $id){
                        $model->where(array('id'=>$id))->delete();
                    }
                }
            }

            if ($eventType === 'update'){
                $itemlist = $_GET['itemlist'];
                if ($itemlist && is_array($itemlist)){
                    $displayorder = 0;
                    foreach ($itemlist as $id=>$item){
                        if ($item['title'] && $item['url']){
                            $displayorder++;
                            $item['displayorder'] = $displayorder;
                            $model->where(array('id'=>$id))->data($item)->save();
                        }
                    }
                }
            }

            (new BlockModel())->setCache($block_id);
            $this->showAjaxReturn();
        }else {

            $itemlist = $model->where(array('block_id'=>$block_id))->order('displayorder ASC,id ASC')->select();
            $_G['title'] = $_lang['block_item_manage'];
            include template('block/block_item_list');
        }
    }

    /**
     * 添加内容项
     */
    public function add_item(){
        global $_G,$_lang;

        $block_id = intval($_GET['block_id']);
        if ($this->checkFormSubmit()) {
            $item = $_GET['item'];
            if ($item['title'] && $item['url']){
                $item['block_id'] = $block_id;
                (new BlockItemModel())->data($item)->add();
                (new BlockModel())->setCache($block_id);
                $this->showSuccess('save_succeed', null, array(
                    array('text'=>'continue_add', 'url'=>curPageURL()),
                    array('text'=>'back_list', 'url'=>U('c=block&a=itemlist&block_id='.$block_id))
                ));
            }else {
                $this->showError('undefined_action');
            }
        }else {

            $_G['title'] = $_lang['block_item_manage'];
            include template('block/block_item_form');
        }
    }

    /**
     * 修改内容
     */
    public function edit_item(){
        global $_G,$_lang;

        $id = intval($_GET['id']);
        $block_id = intval($_GET['block_id']);
        $model = new BlockItemModel();

        if ($this->checkFormSubmit()) {
            $item = $_GET['item'];
            if ($item['title'] && $item['url']){
                $model->where(array('id'=>$id))->data($item)->save();
                (new BlockModel())->setCache($block_id);
                $this->showSuccess('save_succeed', null, array(
                    array('text'=>'reedit', 'url'=>curPageURL()),
                    array('text'=>'back_list', 'url'=>U('c=block&a=itemlist&block_id='.$block_id))
                ));
            }else {
                $this->showError('undefined_action');
            }
        }else {

            $item = $model->where(array('id'=>$id))->getOne();
            $_G['title'] = $_lang['block_item_manage'];
            include template('block/block_item_form');
        }
    }

    /**
     * 修改图片
     */
    public function set_item_image(){
        $id = intval($_GET['id']);
        $image = trim($_GET['image']);
        $block_id = intval($_GET['block_id']);
        (new BlockItemModel())->where(array('id'=>$id))->data(array('image'=>$image))->save();
        (new BlockModel())->setCache($block_id);
        $this->showAjaxReturn();
    }
}