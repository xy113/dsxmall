<?php
/**
 *
 */
namespace Model\Admin;
use Core\ParseVideoUrl;
use Data\Post\PostCatlogModel;
use Data\Post\PostContentModel;
use Data\Post\PostImageModel;
use Data\Post\PostItemModel;
use Data\Post\PostMediaModel;

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
        global $_G,$_lang;

        $catid = isset($_GET['catid']) ? intval($_GET['catid']) : 0;
        $type = in_array($_GET['type'], array('image','video', 'voice')) ? $_GET['type'] : 'article';
        $item['from']    = setting('sitename');
        $item['fromurl'] = setting('siteurl');
        $item['author']  = $this->username;
        $item['price']   = 0;
        $item['pubtime'] = @date('Y-m-d H:i:s');

        $editorname = "content";
        $catloglist = (new PostCatlogModel())->getCatlogTree();
        include template('post/post_form');
	}

    /**
     * 编辑文章
     */
    public function edit(){
        global $_G,$_lang;

        $aid = intval($_GET['aid']);
        $itemModel = new PostItemModel();
        $item = $itemModel->where(array('aid'=>$aid))->getOne();
        $item['pubtime'] = $item['pubtime'] ? @date('Y-m-d H:i:s', $item['pubtime']) : @date('Y-m-d H:i:s');
        $type = in_array($item['type'], array('image','video')) ? $item['type'] : 'article';
        $catid = $item['catid'];

        $content = (new PostContentModel())->where(array('aid'=>$aid))->getOne();
        $editorname = "content";
        $editorcontent = $content['content'];
        //相册列表
        $gallery = (new PostImageModel())->where(array('aid'=>$aid))->order('displayorder ASC,id ASC')->select();
        //获取媒体信息
        $media = (new PostMediaModel())->where(array('aid'=>$aid))->getOne();
        //文章分类列表
        $catloglist = (new PostCatlogModel())->getCatlogTree();

        //载入模板
        include template('post/post_form');
    }
	
	/**
	 * 保存文章
	 */
	public function save(){
		global $_G;

		$aid = intval($_GET['aid']);
		$newpost = $_GET['newpost'];
		$eventType = htmlspecialchars($_GET['eventType']);
		if (is_array ($newpost)) {
		    if (!$newpost) {
		        $this->showError('empry_post_title');
            }
			$newpost['author']  = $newpost['author']  ? $newpost['author']  : $this->username;
			$newpost['from']    = $newpost['from']    ? $newpost['from']    : setting('sitename');
			$newpost['fromurl'] = $newpost['fromurl'] ? $newpost['fromurl'] : setting('siteurl');
			$newpost['tags'] = $newpost['tags'] ? $newpost['tags'] : '';
			$newpost['allowcomment'] = intval($newpost['allowcomment']);
			//文章摘要
			$newpost['summary'] = $newpost['summary'] ? $newpost['summary'] : cutstr(stripHtml($content), 300);
			$newpost['summary'] = str_replace('&amp;', '&', $newpost['summary']);
			$newpost['summary'] = str_replace('&nbsp;', '', $newpost['summary']);
			$newpost['summary'] = str_replace('　', '', $newpost['summary']);
			$newpost['summary'] = preg_replace('/\s/', '', $newpost['summary']);
            $newpost['pubtime'] = $newpost['pubtime'] ? strtotime($newpost['pubtime']) : time();

			$itemModel = new PostItemModel();
			if ($eventType == 'edit') {
			    //更新文章信息
                $newpost['modified'] = time();
			    $itemModel->where(array('aid'=>$aid))->data($newpost)->save();
            }else {
			    //添加文章信息
                $newpost['uid'] = $this->uid;
                $newpost['username'] = $this->username;
			    $aid = $itemModel->data($newpost)->add();
            }

            //添加文章内容
            $contentModel = new PostContentModel();
			$content = trim($_GET['content']);
            if ($eventType == 'edit') {
                $contentModel->where(array('aid'=>$aid))->data(array('content'=>$content))->save();
            }else {
                $contentModel->data(array('aid'=>$aid, 'uid'=>$this->uid, 'content'=>$content))->add();
            }
			
            //添加相册
            $gallery = $_GET['gallery'];
            //print_array($gallery);exit();
            if ($gallery) {
                $imageList = array();
                $imageModel = new PostImageModel();
                if ($eventType == 'edit') {
                    foreach ($imageModel->where(array('aid'=>$aid))->order('displayorder')->select() as $img){
                        $imageList[$img['id']]['mark'] = 'delete';
                        $imageList[$img['id']]['img'] = $img;
                    }
                }

                $displayorder = 0;
                foreach ($gallery as $id=>$img){
                    $imageList[$id]['img'] = $img;
                    $imageList[$id]['img']['displayorder'] = $displayorder++;
                    if (isset($imageList[$id])) {
                        $imageList[$id]['mark'] = 'update';
                    }else {
                        $imageList[$id]['mark'] = 'insert';
                    }
                }

                foreach ($imageList as $id=>$img){
                    if ($img['mark'] == 'insert'){
                        $img['img']['aid'] = $aid;
                        $img['img']['uid'] = $this->uid;
                        $imageModel->data($img['img'])->add();
                    }elseif ($img['mark'] == 'update'){
                        $imageModel->where(array('id'=>$id))->data($img['img'])->save();
                    }else {
                        $imageModel->where(array('id'=>$id))->delete();
                    }
                }
                //将第一张设为文章图片
                if (!$newpost['image']) {
                    $image = reset($gallery);
                    $itemModel->where(array('aid'=>$aid))->data(array('image'=>$image['image']))->save();
                }
            }

            $media = $_GET['media'];
            if ($media && $media['original_url']){
                if ($source = ParseVideoUrl::ParseUrl($media['original_url'])) {
                    $media['source'] = $source['swf'];
                    $media['image'] = $source['img'];
                    $media['original_url'] = $source['url'];

                    $mediaModel = new PostMediaModel();
                    if ($eventType == 'edit') {
                        $mediaModel->where(array('aid'=>$aid))->data($media)->save();
                    }else {
                        $media['aid'] = $aid;
                        $media['uid'] = $this->uid;
                        $mediaModel->data($media)->add();
                    }
                }
            }

            if ($eventType == 'edit'){
                $links = array (
                    array (
                        'text' => 'reedit',
                        'url' => U('c=post&a=edit&aid='.$aid)
                    ),
                    array (
                        'text'=>'view',
                        'url'=>U('m=post&c=detail&aid='.$aid),
                        'target'=>'_blank'
                    ),
                    array(
                        'text'=>'back_list',
                        'url'=>U('c=post&a=itemlist')
                    )
                );
                $this->showSuccess('post_update_succeed', null, $links, null,true);
            }else {
                $links = array (
                    array (
                        'text' => 'continue_publish',
                        'url' => U('c=post&a=add&type='.$newpost['type'].'&catid='.$newpost['catid'])
                    ),
                    array (
                        'text'=>'view',
                        'url'=>U('m=post&c=detail&aid='.$aid),
                        'target'=>'_blank'
                    ),
                    array(
                        'text'=>'back_list',
                        'url'=>U('c=post&a=itemlist')
                    )
                );
                $this->showSuccess('post_save_succeed', null, $links, null,true);
            }

		} else {
			$this->showError('invalid_parameter');
		}
	}
}