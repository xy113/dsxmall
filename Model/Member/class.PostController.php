<?php
namespace Model\Member;
use Data\Post\PostItemModel;

class PostController extends BaseController{
	public function index(){
		$this->itemlist();
	}
	
	public function itemlist(){
		global $_G,$lang;
		if ($this->checkFormSubmit()) {
			
		}else {
			
			$pagesize = 20;
			$itemModel = new PostItemModel();
			$condition = array('uid'=>$this->uid);
			$totalcount = $itemModel->where($condition)->count();
			$pagecount  = $totalcount < $pagesize ? 1 : ceil($totalcount/$pagesize);
			$itemlist   = $itemModel->where($condition)->page($_G['page'], $pagesize)->order('aid DESC')->select();
			$pagination = $this->pagination($_G['page'], $pagecount, $totalcount);
			
			$_lang['title'] = $lang['my_article'];
			include template('post_list');
		}
	}
}