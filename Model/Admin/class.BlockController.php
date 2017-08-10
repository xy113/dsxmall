<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/9
 * Time: 下午5:30
 */
namespace Model\Admin;
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
     *
     */
    public function namelist(){
        global $_G,$_lang;

        if ($this->checkFormSubmit()){
            $ids = $_GET['ids'];
            if ($ids && is_array($ids)){
                $ids = implodeids($ids);
                if ($_GET['option'] == 'delete'){
                    block_delete_data(array('block_id'=>array('IN', $ids)));
                    block_delete_item(array('block_id'=>array('IN', $ids)));
                    $this->showSuccess('delete_succeed');
                }
            }else {
                $this->showError('no_select');
            }
        }else {
            $pagesize = 20;
            $totalnum = block_get_count(0);
            $pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
            $itemlist = block_get_list(0, $pagesize, ($_G['page']-1)*$pagesize);
            $pages = $this->showPages($_G['page'], $pagecount, $totalnum, null, true);

            $_G['title'] = $_lang['block_manage'];
            include template('block_list');
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
                block_update_data(array('block_id'=>$block_id), $block);
            }else {
                block_add_data($block);
            }
            $this->showAjaxReturn();
        }
    }

    /**
     * 获取板块信息
     */
    public function get_block(){
        $block_id = intval($_GET['block_id']);
        $block = block_get_data(array('block_id'=>$block_id));
        $this->showAjaxReturn($block);
    }

    /**
     * 内容管理
     */
    public function itemlist(){
        global $_G,$_lang;

        $block_id = intval($_GET['block_id']);
        if ($this->checkFormSubmit()) {
            $delete = $_GET['delete'];
            if ($delete && is_array($delete)) {
                $deleteids = implodeids($delete);
                block_delete_item(array('id'=>array('IN', $deleteids)));
            }
            $itemlist = $_GET['itemlist'];
            if ($itemlist && is_array($itemlist)){
                $displayorder = 0;
                foreach ($itemlist as $id=>$item){
                    if ($item['title'] && $item['url']){
                        $displayorder++;
                        $item['displayorder'] = $displayorder;
                        block_update_item(array('id'=>$id), $item);
                    }
                }
            }
            block_set_cache($block_id);
            $this->showSuccess('update_succeed');
        }else {

            $itemlist = block_get_item_list(array('block_id'=>$block_id));
            $_G['title'] = $_lang['block_item_manage'];
            include template('block_item_list');
        }
    }

    /**
     *
     */
    public function add_item(){
        global $_G,$_lang;

        $block_id = intval($_GET['block_id']);
        if ($this->checkFormSubmit()) {
            $item = $_GET['item'];
            if ($item['title'] && $item['url']){
                $item['block_id'] = $block_id;
                block_add_item($item);
                block_set_cache($block_id);
                $this->showSuccess('save_succeed', null, array(
                    array('text'=>'continue_add', 'url'=>curPageURL()),
                    array('text'=>'back_list', 'url'=>U('c=block&a=itemlist&block_id='.$block_id))
                ));
            }else {
                $this->showError('undefined_action');
            }
        }else {

            $_G['title'] = $_lang['block_item_manage'];
            include template('block_item_form');
        }
    }

    /**
     * 修改内容
     */
    public function edit_item(){
        global $_G,$_lang;

        $id = intval($_GET['id']);
        $block_id = intval($_GET['block_id']);
        if ($this->checkFormSubmit()) {
            $item = $_GET['item'];
            if ($item['title'] && $item['url']){
                block_update_item(array('id'=>$id), $item);
                block_set_cache($block_id);
                $this->showSuccess('save_succeed', null, array(
                    array('text'=>'reedit', 'url'=>curPageURL()),
                    array('text'=>'back_list', 'url'=>U('c=block&a=itemlist&block_id='.$block_id))
                ));
            }else {
                $this->showError('undefined_action');
            }
        }else {

            $item = block_get_item(array('id'=>$id));
            $_G['title'] = $_lang['block_item_manage'];
            include template('block_item_form');
        }
    }

    /**
     * 修改图片
     */
    public function set_item_image(){
        $id = intval($_GET['id']);
        $image = trim($_GET['image']);
        $block_id = intval($_GET['block_id']);
        block_update_item(array('id'=>$id), array('image'=>$image));
        block_set_cache($block_id);
        $this->showAjaxReturn();
    }
}