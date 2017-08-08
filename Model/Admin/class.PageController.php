<?php
namespace Model\Admin;
class PageController extends BaseController{
	public function index(){
		$this->itemlist();
	}

    /**
     *
     */
    public function itemlist(){
		global $_G, $_lang;
        $_GET['menu'] = 'page_list';
		if ($this->checkFormSubmit()){
			//删除页面
			$delete = $_GET['delete'];
			if (!empty($delete) && is_array($delete)){
				$deleteids = implode(',', $delete);
				page_delete_data(array('pageid'=>array('IN', $deleteids)));
			}
			//更新页面
			$pagelist  = $_GET['pagelist'];
			if ($pagelist && is_array($pagelist)){
				foreach ($pagelist as $pageid=>$page){
					page_update_data(array('pageid'=>$pageid), $page);
				}
			}
			$this->showSuccess('update_succeed');
		}else {
			
			$condition = array('type'=>'page');
			$catid = intval($_GET['catid']);
			if ($catid) $condition['catid'] = $catid;
			
			$pagesize  = 20;
			$totalnum  = page_get_count($condition);
			$pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
			$pagelist  = page_get_page($condition, $_G['page'], $pagesize);
			$pages = $this->showPages($_G['page'], $pagecount,$totalnum,"catid=$catid", 1);
			$categorylist = page_get_list(array('type'=>'category'), 0);
			include template('page_list');
		}
		
	}

    /**
     *
     */
    public function add(){
		global $_G, $_lang;
        $_GET['menu'] = 'page_add';
		if ($this->checkFormSubmit()) {
			$newpage = $_GET['newpage'];
			$newpage['pubtime']  = TIMESTAMP;
			$newpage['modified'] = TIMESTAMP;
			if (!$newpage['summary']) {
				$newpage['summary'] = cutstr(stripHtml($newpage['body']), 400);
			}
			page_add_data($newpage);
			$this->showSuccess('save_succeed');
		}else{
			$categorylist = page_get_list(array('type'=>'category'));
			$editorname = 'newpage[body]';
			include template('page_form');
		}
	}

	public function edit(){
		global $_G, $_lang;
        $_GET['menu'] = 'page_add';
		$pageid = intval($_GET['pageid']);
		if($this->checkFormSubmit()){
			$newpage = $_GET['newpage'];
			$newpage['modified'] = TIMESTAMP;
			if (!$newpage['summary']) {
				$newpage['summary'] = cutstr(stripHtml($newpage['body']), 400);
			}
			page_update_data(array('pageid'=>$pageid), $newpage);
			$this->showSuccess('modi_succeed');
		}else {
			$page = page_get_data(array('pageid'=>$pageid));
			$categorylist = page_get_list(array('type'=>'category'));
			$editorname = 'newpage[body]';
			$editorcontent = $page['body'];
			include template('page_form');
		}
	}
	
	/**
	 * 页面分类管理
	 */
	public function category(){
		global $_G,$_lang;
        $_GET['menu'] = 'page_cat';
		if($this->checkFormSubmit()){
			$delete = $_GET['delete'];
			if (!empty($delete) && is_array($delete)){
				$deleteids = implode(',', $delete);
				page_delete_data(array('pageid'=>array('IN', $deleteids)));
				page_delete_data(array('catid'=>array('IN', $deleteids)));
			}
			
			$categorylist = $_GET['categorylist'];
			if ($categorylist && is_array($categorylist)){
				foreach ($categorylist as $pageid=>$category){
					if ($category['title']){
						if ($pageid > 0){
							page_update_data(array('pageid'=>$pageid), $category);
						}else {
							$category['type'] = 'category';
							page_add_data($category);
						}
					}
				}
			}
			$this->showSuccess('save_succeed');
		}else {
			$categorylist = page_get_list(array('type'=>'category'), 0);
			include template('page_category');
		}
	}
}