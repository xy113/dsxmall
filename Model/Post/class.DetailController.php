<?php
namespace Model\Post;
use Data\Post\PostCatlogModel;
use Data\Post\PostContentModel;
use Data\Post\PostImageModel;
use Data\Post\PostItemModel;
use Data\Post\PostMediaModel;

class DetailController extends BaseController{
	public $aid = 0;
	public $catid = 0;

    /**
     * 文章详情
     */
    public function index(){
		global $_G,$_lang;

		$postItem = new PostItemModel();
		$this->aid = $_GET['aid'] ? intval($_GET['aid']) : intval($_GET['id']);
        $postItem->updateView_num($this->aid);
		$article = $postItem->where(array('aid'=>$this->aid))->getOne();

		$article['tags'] = $article['tags'] ? unserialize($article['tags']) : array();
		if (!in_array($article['type'], array('image','video','voice'))){
			$article['type'] = 'article';
		}
		//文章内容
		$content = (new PostContentModel())->where(array('aid'=>$this->aid))->getOne();

		if ($article['type'] == 'image'){
		    $gallery = (new PostImageModel())->where(array('aid'=>$this->aid))->order('displayorder ASC,id ASC')->select();
        }

        if ($article['type'] == 'media'){
		    $media = (new PostMediaModel())->where(array('aid'=>$this->aid))->getOne();
        }

		$this->catid = $article['catid'];
		$postCatlog = new PostCatlogModel();
		$catlog = $postCatlog->where(array('catid'=>$this->catid))->getOne();
		$_G['title'] = $article['title'].' - '.$catlog['name'];

		$_G['keywords'] = $article['tags'] ? implode(',', $article['tags']) : $_G['keywords'];
		$_G['description'] = $article['summary'] ? $article['summary'] : $_G['keywords'];

		//最新文章
        $newPostList = $postItem->where(array('status'=>1))->order('aid', 'DESC')->field('aid,title')->limit(0, 10)->select();
        //热点图文
        $hotPostList = $postItem->where("`status`=1 AND `image`<>''")->order('view_num', 'DESC')->field('aid,title,image')->limit(0, 5)->select();

        if ($catlog['template_detail']) {
			include template($catlog['template_detail']);
		}else {
			include template('detail_'.$article['type']);
		}
	}
}