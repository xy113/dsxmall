<?php
namespace Model\Post;
class DetailController extends BaseController{
	public $id = 0;
	public $catid = 0;
	public function index(){
		global $_G,$_lang;
		$this->id = intval($_GET['id']);
		post_update_item(array('id'=>$this->id), "viewnum=viewnum+1");
		$article = post_get_item(array('id'=>$this->id));
		$article['tags'] = $article['tags'] ? unserialize($article['tags']) : array();
		if (!in_array($article['type'], array('image','video','music'))){
			$article['type'] = 'article';
		}

		$this->catid = $article['catid'];
		$category = post_get_category(array('catid'=>$this->catid));
		$_G['title'] = $article['title'].' - '.$category['name'];
		
		$_G['keywords'] = $article['tags'] ? implode(',', $article['tags']) : $_G['keywords'];
		$_G['description'] = $article['summary'] ? $article['summary'] : $_G['keywords'];
		
		$content['content'] = post_get_content(array('aid'=>$this->id));
		if ($article['type'] == 'image'){
			$piclist = image_get_list(array('dataid'=>$id, 'datatype'=>'article'), 0);
		}
		
		if($article['type'] == 'video'){
			$video = media_get_data(array('dataid'=>$id, 'datatype'=>'article'));
		}
		
		if ($category['template_detail']) {
			include template($category['template_detail']);
		}else {
			include template('detail_'.$article['type']);
		}
	}
}