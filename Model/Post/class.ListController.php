<?php
namespace Model\Post;
use Data\Item\ItemModel;

class ListController extends BaseController{
    /**
     *
     */
    public function index(){
		global $_G,$_lang;

		$pagesize = 20;
		$catid = intval($_GET['catid']);
		$condition = $catid ? array('catid'=>$catid) : '';

		$itemModel = new ItemModel();
		$totalcount  = $itemModel->where($condition)->count();
		$pagecount   = $totalcount < $pagesize ? 1 : ceil($totalcount/$pagesize);
		$articlelist = $itemModel->where($condition)->page($_G['page'], $pagesize)->order('aid', 'DESC')->select();
		$pagination = $this->pagination($_G['page'], $pagecount, $totalcount, "catid=$catid");
		

		$_G['title'] = '';
        include template('list');
	}
}