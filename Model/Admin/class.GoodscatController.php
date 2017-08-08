<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/2
 * Time: 下午2:08
 */
namespace Model\Admin;
class GoodscatController extends BaseController{
    /**
     * GoodscatController constructor.
     */
    function __construct()
    {
        parent::__construct();
        $_GET['menu'] = 'goodscat';
    }

    public function index(){
        $this->itemlist();
    }

    /**
     * 分类列表
     */
    public function itemlist(){
        global $_G,$_lang;

        if ($this->checkFormSubmit()){
            $delete = $_GET['delete'];
            if ($delete && is_array($delete)){
                $deleteids = implodeids($delete);
                goods_delete_cat(array('catid'=>array('IN', $deleteids)));
            }

            $itemlist = $_GET['itemlist'];
            if ($itemlist && is_array($itemlist)) {
                $pinyin = new \Core\Pinyin();
                foreach ($itemlist as $catid=>$item){
                    if ($item['name']){
                        if (!$item['identifer']){
                            $item['identifer'] = $pinyin->getPinyin($item['name']);
                        }
                        if ($catid > 0){
                            goods_update_cat(array('catid'=>$catid), $item);
                        }else {
                            goods_add_cat($item);
                        }
                    }
                }
            }
            goods_update_cat_cache();
            $this->showSuccess('update_succeed');
        }else {

            $itemlist = goods_get_cat_list(0);
            if ($itemlist) {
                $datalist = array();
                foreach ($itemlist as $item){
                    $datalist[$item['fid']][$item['catid']] = $item;
                }
                $itemlist = $datalist;
                unset($datalist, $item);
            }
            $_G['title'] = L('goods_cat_manage');
            include template('goods_cat_list');
        }
    }

    /**
     * 修改分类
     */
    public function edit(){
        global $_G,$_lang;
        $catid = intval($_GET['catid']);
        if ($this->checkFormSubmit()){
            $category = $_GET['category'];
            if ($category && is_array($category)){
                if (!$category['identifer']) {
                    $pinyin = new \Core\Pinyin();
                    $category['identifer'] = $pinyin->getPinyin($category['name']);
                }
                goods_update_cat(array('catid'=>$catid), $category);
                goods_update_cat_cache();
                $this->showSuccess('update_succeed');
            }
        }else {

            $category = goods_get_cat(array('catid'=>$catid));
            $itemlist = goods_get_cat_list(0);
            if ($itemlist) {
                $datalist = array();
                foreach ($itemlist as $item){
                    $datalist[$item['fid']][$item['catid']] = $item;
                }
                $itemlist = $datalist;
                unset($datalist, $item);
            }

            $_G['title'] = L('goods_cat_manage');
            include template('goods_cat_form');
        }
    }

    /**
     * 合并文章分类
     */
    public function merge(){
        global $_G,$_lang;
        $_GET['menu'] = 'merge_article';

        if ($this->checkFormSubmit()){
            $source = $_GET['source'];
            $target = intval($_GET['target']);
            if ($source && is_array($source)){
                foreach ($source as $k=>$v){
                    if ($v == $target){
                        unset($source[$k]);
                    }
                }
            }
            $source = $source ? implodeids($source) : 0;
            post_update_item(array('catid'=>array('IN', $source)), array('catid'=>$target));
            post_delete_category(array('catid'=>array('IN', $source)));
            post_update_category_cache();
            $this->showSuccess('update_succeed');

        }else {
            $categoryoptions = post_get_category_options(0,0,1);
            include template('post_cat_merge');
        }
    }

    /**
     * 设置图标
     */
    public function setimage(){
        $catid = intval($_GET['catid']);
        $image = htmlspecialchars($_GET['image']);
        goods_update_cat(array('catid'=>$catid), array('image'=>$image));
        goods_update_cat_cache();
        $this->showAjaxReturn();
    }
}