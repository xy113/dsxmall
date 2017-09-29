<?php
/**
 *
 */
namespace Model\Admin;
use Data\Member\MemberModel;
use Data\Post\PostCatlogModel;
use Data\Post\PostItemModel;

class PostController extends BaseController{
	public function index(){
		$this->itemlist();
	}
	
	/**
	 * 文章列表
	 */
	public function itemlist(){
		global $_G,$_lang;

        $condition = $queryParams = array();
        $searchType = intval($_GET['searchType']);
        $queryParams['searchType'] = $searchType;

        $title = htmlspecialchars($_GET['title']);
        if ($title) {
            $condition[] = "i.title LIKE '$title'";
            $queryParams['title'] = $title;
        }

        $username = htmlspecialchars($_GET['username']);
        if ($username) {
            $condition[] = "i.username='$username'";
            $queryParams['username'] = $username;
        }

        $catid = htmlspecialchars($_GET['catid']);
        if ($catid) {
            $condition[] = "i.catid='$catid'";
            $queryParams['catid'] = $catid;
        }

        $status = htmlspecialchars($_GET['status']);
        if ($status != '') {
            $condition[] = "i.status='$status'";
            $queryParams['status'] = $status;
        }

        $type = htmlspecialchars($_GET['type']);
        if ($type) {
            $condition[] = "i.type='$type'";
            $queryParams['type'] = $type;
        }

        $time_begin = htmlspecialchars($_GET['time_begin']);
        if ($time_begin) {
            $condition[] = "i.pubtime>".strtotime($time_begin);
            $queryParams['time_begin'] = $time_begin;
        }

        $time_end = htmlspecialchars($_GET['time_end']);
        if ($time_end) {
            $condition[] = "i.pubtime<".strtotime($time_end);
            $queryParams['time_end'] = $time_end;
        }

        $q = htmlspecialchars($_GET['q']);
        if ($q) $condition[] = "i.title LIKE '%$q%'";

        $pagesize  = 20;
        $totalnum  = M('post_item i')->join('post_catlog c', 'c.catid=i.catid')->where($condition)->count();
        $pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
        $itemlist = M('post_item i')->join('post_catlog c', 'c.catid=i.catid')->field('i.*,c.name as cat_name')
            ->where($condition)->page($_G['page'], $pagesize)->order('aid', 'DESC')->select();
        $pagination = $this->pagination($_G['page'], $pagecount, $totalnum,http_build_query($queryParams),1);
        unset($condition, $queryParams);

        $catloglist = (new PostCatlogModel())->getCatlogTree();
        include template('post/post_list');
	}

    /**
     * 删除文章
     */
    public function delete(){
	    if ($this->checkFormSubmit()){
            $items = $_GET['items'];
            if ($items && is_array($items)){
                $itemModel = new PostItemModel();
                foreach ($items as $aid){
                    $itemModel->deleteAllData($aid);
                }
            }
        }
        $this->showAjaxReturn();
    }
	
	/**
	 * 移动文章
	 */
	public function move(){
		if ($this->checkFormSubmit()){
            $items = $_GET['items'];
            $target = intval($_GET['target']);
            if ($items && is_array($items)){
                $itemModel = new PostItemModel();
                foreach ($items as $aid){
                    $itemModel->where(array('aid'=>$aid))->data(array('catid'=>$target))->save();
                }
            }
		}
		$this->showAjaxReturn();
	}

    /**
     * 审核文章
     */
    public function review(){
        $event = trim($_GET['event']);
        if ($this->checkFormSubmit()){
            $items = $_GET['items'];
            if ($items && is_array($items)){
                $itemModel = new PostItemModel();
                foreach ($items as $aid){
                    if ($event == 'pass'){
                        $itemModel->where(array('aid'=>$aid))->data(array('status'=>1))->save();
                    }else {
                        $itemModel->where(array('aid'=>$aid))->data(array('status'=>-1))->save();
                    }
                }
            }
        }
        $this->showAjaxReturn();
    }

    /**
     * 设置文章图片
     */
    public function setimage(){
        $aid = intval($_GET['aid']);
        $image = htmlspecialchars($_GET['image']);
        if ($aid && $image){
            (new PostItemModel())->where(array('aid'=>$aid))->data(array('image'=>$image))->save();
            $this->showAjaxReturn(0);
        }else {
            $this->showAjaxError(1, 'invalid_parameter');
        }
    }
	
	/**
	 * 发布文章
	 */
	public function add(){
		if ($this->checkFormSubmit()){
			$this->save();
		}else {
			global $_G,$_lang,$config;
			$catid = isset($_GET['catid']) ? intval($_GET['catid']) : 0;
			$categoryoptions = post_get_category_options(0, $catid,1);
			$type = in_array($_GET['type'], array('image','video')) ? $_GET['type'] : 'article';
			$article['from']    = setting('sitename');
			$article['fromurl'] = setting('siteurl');
			$article['author']  = $this->username;
			$article['price']   = 0;
			$article['pubtime'] = @date('Y-m-d H:i:s');

            $editorname = "content";
            $_GET['menu'] = 'add_article';
			include template('post_form');
		}
	}
	
	/**
	 * 保存文章
	 */
	private function save(){
		global $_G;
		
		$newpost = $_GET['newpost'];
		$content = $_GET['content'];
		if (is_array ($newpost)) {
			$newpost['uid'] = $this->uid;
			$newpost['pubtime']  = strtotime($newpost['pubtime']);
 			$newpost['modified'] = TIMESTAMP;
			$newpost['author']   = $newpost['author'] ? $newpost['author'] : $this->username;
			$newpost['from']     = isset($newpost['from']) ? $newpost['from'] : setting('sitename');
			$newpost['fromurl']  = isset($newpost['fromurl']) ? $newpost['fromurl'] : setting('siteurl');
			$newpost['tags'] = $newpost['tags'] ? $newpost['tags'] : '';
			$newpost['allowcomment'] = intval($newpost['allowcomment']);
			if (!$newpost['summary']) {
				$newpost['summary'] = cutstr(stripHtml($content), 300);
			}
			$newpost['summary'] = str_replace('&amp;', '&', $newpost['summary']);
			$newpost['summary'] = str_replace('&nbsp;', '', $newpost['summary']);
			$newpost['summary'] = str_replace('　', '', $newpost['summary']);
			$newpost['summary'] = preg_replace('/\s/', '', $newpost['summary']);
			
			$id = post_add_item($newpost);
			if ($newpost['type'] == 'article') {
				if ($content) {
					$contentlist = preg_split('/<hr class=\"ke-pagebreak\" style=\"page-break-after: always;\">/', $content);
					foreach ($contentlist as $key=>$value){
						$data = array(
								'aid'=>$id,
								'uid'=>$this->uid,
								'content'=>$value,
								'pageorder'=>$key+1
						);
						post_add_content($data);
					}
					post_update_item(array('id'=>$id), array('contents'=>count($contentlist)));
				}
			}
			
			if ($newpost['type'] == 'image'){
				$piclist = $_GET['piclist'];
				if (is_array($piclist)) {
					foreach ($piclist as $key=>$pic){
						$pic['aid'] = $id;
						$pic['uid'] = $this->uid;
						$pic['isremote'] = 0;
						post_add_image($pic);
					}
					if (!$newpost['image']) {
						$image = reset($piclist);
						post_update_item(array('id'=>$id), array('image'=>$image['image']));
					}
				}
			}
			
			if ($newpost['type'] == 'video'){
				$videourl = trim($_GET['videourl']);
				if ($videourl) {
					$videodata = \Core\ParseVideoUrl::ParseUrl ($videourl);
					if ($videodata) {
						post_add_media(array(
								'aid'=>$id,
								'uid'=>$this->uid,
								'image'=>$videodata['img'],
								'source'=>$videodata['swf'],
								'original_url'=>$videodata['url']
						));
						if (!$newpost['image']) post_update_item(array('id'=>$id), array('image'=>$videodata['img']));
					}
				}
			}
			
			$links = array (
					array (
							'text' => 'continue_publish',
							'url' => U('c=post&a=add&type='.$newpost['type'].'&catid='.$newpost['catid'])
					),
					array (
							'text'=>'view',
							'url'=>U('m=post&c=detail&id='.$id),
							'target'=>'_blank'
					),
					array(
							'text'=>'back_list',
							'url'=>U('c=post&a=itemlist')
					)
			);
			$this->showSuccess('article_save_succeed', null, $links, null,true);
		} else {
			$this->showError('undefined_error');
		}
	}
	
	/**
	 * 编辑文章
	 */
	public function edit(){
		if ($this->checkFormSubmit()){
			$this->update();
		}else {
			global $_G,$_lang;
			$id = intval($_GET['id']);
			$article = post_get_item(array('id'=>$id));
			$article['pubtime'] = @date('Y-m-d H:i:s', $article['pubtime']);
			if (in_array($article['type'], array('image','video'))){
				$type = $article['type'];
			}else {
				$type = 'article';
			}
			
			if ($article['type'] == 'article'){
				$content = post_get_content(array('aid'=>$id));
			}
			
			if ($article['type'] == 'image'){
				$piclist = post_get_image_list(array('aid'=>$id), 0);
			}
			
			if ($article['type'] == 'video'){
				$videodata = post_get_media_data(array('aid'=>$id));
			}
			$categoryoptions = post_get_category_options(0, $article['catid'],1);

            $editorname = "content";
            $editorcontent = $content;

            $_G['menu'] = 'add_article';
			include template('post_form');
		}
	}
	
	/**
	 * 更新文章
	 */
	public function update(){
		global $_G;

		$id = intval($_GET['id']);
		$newpost = $_GET['newpost'];
		$content = $_GET['content'];
		if (is_array($newpost)) {
			$newpost['pubtime']  = strtotime($newpost['pubtime']);
			$newpost['modified'] = TIMESTAMP;
			$newpost['author']   = $newpost['author'] ? $newpost['author'] : $this->username;
			$newpost['from']     = isset($newpost['from']) ? $newpost['from'] : setting('sitename');
			$newpost['fromurl']  = isset($newpost['fromurl']) ? $newpost['fromurl'] : setting('siteurl');
			$newpost['tags'] = $newpost['tags'] ? $newpost['tags'] : '';
			$newpost['allowcomment'] = intval($newpost['allowcomment']);
			if (!$newpost['summary']) {
				$newpost['summary'] = cutstr(stripHtml($content), 300);
			}
			$newpost['summary'] = str_replace('&amp;', '&', $newpost['summary']);
			$newpost['summary'] = str_replace('&nbsp;', '', $newpost['summary']);
			$newpost['summary'] = str_replace('　', '', $newpost['summary']);
			$newpost['summary'] = preg_replace('/\s/', '', $newpost['summary']);
			//$newpost['summary'] = preg_replace('/[\n|\r]/', '', $newpost['summary']);
			
			post_update_item(array('id'=>$id), $newpost);
			if ($newpost['type'] == 'article') {
				if ($content) {
					post_delete_content(array('aid'=>$id));
					$contentlist = preg_split('/<hr class=\"ke-pagebreak\" style=\"page-break-after: always;\">/', $content);
					foreach ($contentlist as $key=>$value){
						$data = array(
								'aid'=>$id,
								'uid'=>$this->uid,
								'content'=>$value,
								'pageorder'=>$key+1
						);
						post_add_content($data);
					}
				}
			}
			
			if ($newpost['type'] == 'image'){
				post_delete_image(array('aid'=>$id));
				$piclist = $_GET['piclist'];
				if ($piclist) {
					foreach ($piclist as $pic){
						$pic['aid'] = $id;
						$pic['uid'] = $this->uid;
						$pic['isremote'] = 0;
						post_add_image($pic);
					}
					if (!$newpost['image']) {
						$image = reset($piclist);
						post_update_item(array('id'=>$id), array('image'=>$image['image']));
					}
				}
			}
			
			if ($newpost['type'] == 'video'){
				$videourl = trim($_GET['videourl']);
				if ($videourl) {
					$videodata = \Core\ParseVideoUrl::ParseUrl ($videourl);
					if ($videodata) {
						post_update_media(
								array('aid'=>$id), 
								array(
										'image'=>$videodata['img'],
										'source'=>$videodata['swf'],
										'original_url'=>$videodata['url']
								)
						);
						if (!$newpost['image']) post_update_item(array('id'=>$id), array('image'=>$videodata['img']));
					}
				}
			}
		
			$links = array (
					array (
							'text' => 'reedit',
							'url' => U('c=post&a=edit&id='.$id)
					),
					array (
							'text' => 'view',
							'url' => U('m=post&c=detail&id='.$id),
							'target' => '_blank'
					),
					array(
							'text'=>'back_list',
							'url'=>U('c=post&a=itemlist')
					)
			);
			$this->showSuccess('article_update_succeed',null, $links,null,true);
		} else {
			$this->showError('undefined_error');
		}
	}

}