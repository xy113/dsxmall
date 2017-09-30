<?php
namespace Model\Admin;
use Data\Common\PageModel;

class PageController extends BaseController{
	public function index(){
		$this->itemlist();
	}

    /**
     *
     */
    public function itemlist(){
		global $_G, $_lang;

		$model = new PageModel();
		if ($this->checkFormSubmit()){
			//删除页面
			$delete = $_GET['delete'];
			if (!empty($delete) && is_array($delete)){
			    foreach ($delete as $pageid){
			        $model->where(array('pageid'=>$pageid))->delete();
                }
			}
			//更新页面
			$pagelist  = $_GET['pagelist'];
			if ($pagelist && is_array($pagelist)){
				foreach ($pagelist as $pageid=>$page){
					$model->where(array('pageid'=>$pageid))->data($page)->select();
				}
			}
			$this->showSuccess('update_succeed');
		}else {
			
			$condition = array('type'=>'page');
			$catid = intval($_GET['catid']);
			if ($catid) $condition['catid'] = $catid;
			
			$pagesize   = 20;
			$totalnum   = $model->where($condition)->count();
			$pagecount  = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
			$pagelist   = $model->where($condition)->page($_G['page'], $pagesize)->select();
			$pagination = $this->pagination($_G['page'], $pagecount, $totalnum, "catid=$catid", true);
			$categorylist = $model->where(array('type'=>'category'))->select();

			include template('page/page_list');
		}
		
	}

    /**
     *
     */
    public function add(){
		global $_G, $_lang;

        $model = new PageModel();
		if ($this->checkFormSubmit()) {
			$newpage = $_GET['newpage'];
			$newpage['pubtime']  = TIMESTAMP;
			$newpage['modified'] = TIMESTAMP;
			if (!$newpage['summary']) {
				$newpage['summary'] = cutstr(stripHtml($newpage['body']), 400);
			}
            $model->data($newpage)->add();
			$this->showSuccess('save_succeed');
		}else{
            $categorylist = $model->where(array('type'=>'category'))->select();
			$editorname = 'newpage[body]';
			include template('page/page_form');
		}
	}

    /**
     * 编辑页面
     */
    public function edit(){
		global $_G, $_lang;

		$model = new PageModel();
		$pageid = intval($_GET['pageid']);
		if($this->checkFormSubmit()){
			$newpage = $_GET['newpage'];
			$newpage['modified'] = TIMESTAMP;
			if (!$newpage['summary']) {
				$newpage['summary'] = cutstr(stripHtml($newpage['body']), 400);
			}
			$model->where(array('pageid'=>$pageid))->data($newpage)->save();
			$this->showSuccess('update_succeed');
		}else {
			$page = $model->where(array('pageid'=>$pageid))->getOne();
			$categorylist = $model->where(array('type'=>'category'))->select();
			$editorname = 'newpage[body]';
			$editorcontent = $page['body'];
			include template('page/page_form');
		}
	}
	
	/**
	 * 页面分类管理
	 */
	public function category(){
		global $_G,$_lang;

		$model = new PageModel();
		if($this->checkFormSubmit()){
			$delete = $_GET['delete'];
			if (!empty($delete) && is_array($delete)){
			    foreach ($delete as $pageid){
			        $model->where(array('pageid'=>$pageid))->delete();
			        $model->where(array('catid'=>$pageid))->delete();
                }
			}
			
			$categorylist = $_GET['categorylist'];
			if ($categorylist && is_array($categorylist)){
				foreach ($categorylist as $pageid=>$category){
					if ($category['title']){
						if ($pageid > 0){
							$model->where(array('pageid'=>$pageid))->data($category)->save();
						}else {
							$category['type'] = 'category';
							$model->data($category)->add();
						}
					}
				}
			}
			$this->showSuccess('save_succeed');
		}else {

			$categorylist = $model->where(array('type'=>'category'))->select();
			include template('page/page_category');
		}
	}
}