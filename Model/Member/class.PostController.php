<?php
namespace Model\Member;
class PostController extends BaseController{
	public function index(){
		$this->itemlist();
	}
	
	public function itemlist(){
		global $_lang,$lang;
		if ($this->checkFormSubmit()) {
			
		}else {
			
			$pagesize = 20;
			$condition = array('uid'=>$this->uid);
			$totalcount = post_get_item_count($condition);
			$pagecount = $total_count < $pagesize ? 1 : ceil($total_count/$pagesize);
			$itemlist = post_get_item_page($condition, $_lang['page'], $pagesize, 'id DESC');
			$pages = $this->showPages($_lang['page'], $pagecount, $totalcount);
			
			$_lang['title'] = $lang['my_article'];
			include template('post_list');
		}
	}
}