<?php
namespace Model\Page;
use Data\Common\PageModel;

/**
 * Class DetailController
 * @package Model\Page
 */
class DetailController extends BaseController {
    /**
     * 页面详情
     */
    public function index() {
		global $_G,$_lang;

		$pageid = intval($_GET['pageid']);
		$pageData = PageModel::getInstance()->where(array('pageid'=>$pageid))->getOne();

        //文章分类
		$catgoryList = PageModel::getInstance()->where(array('type'=>'category'))->field('pageid,title')->order('displayorder')->select();
		//文章列表
        $pageList = PageModel::getInstance()->where(array('type'=>'page'))->field('pageid,catid,title')->order('displayorder')->select();
        $newPageList = array();
        foreach ($pageList as $page){
            $newPageList[$page['catid']][$page['pageid']] = $page;
        }
        $pageList = $newPageList;
        unset($newPageList);

		$this->var['title'] = $pageData['title'];
		include view('detail');
	}
}