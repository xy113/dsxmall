<?php
namespace Model\Admin;

use WxApi\WxNewsApi;

class WxnewsController extends  BaseController{
    /**
     * WxnewsController constructor.
     */
    function __construct()
    {
        parent::__construct();
        $_GET['menu'] = 'wxnews';
    }

    /**
     * 图文消息列表
     */
    public function index(){
		global $_G, $_lang;

		$api = new WxNewsApi();
		if ($this->checkFormSubmit()) {
			$materials = $_GET['materials'];
			if ($materials && is_array($materials)) {
				foreach ($materials as $media_id) {
                    $api->delete($media_id);
				}
				$this->showAjaxReturn();
			}else {
				$this->showAjaxError(1,'no_select');
			}
		}else {
			$pagesize = 20;
			$data = $api->batchget(($_G['page']-1)*$pagesize, $pagesize);
			$data = json_decode($data, true);
			$itemlist = $data['item'];
			$totalcount = $data['total_count'];
			$pagecount  = $totalcount < $pagesize ? 1 : ceil($totalcount/$pagesize);
			$pagination = $this->pagination($_G['page'], $pagecount, $totalcount, "", 1);
			
			if ($itemlist) {
				$datalist = array();
				foreach ($itemlist as $item){
					$item['title'] = $item['content']['news_item'][0]['title'];
					$item['thumb_media_id'] = $item['content']['news_item'][0]['thumb_media_id'];
					$item['item_count'] = count($item['content']['news_item']);
					unset($item['content']);
					array_push($datalist, $item);
				}
				$itemlist = $datalist;
				unset($datalist, $item);
			}
			include template('weixin/news_list');
		}
	}
	
	public function add(){
		global $_G,$_lang;
		
		if ($this->checkFormSubmit()) {
			$news_item = $_GET['news_item'];
			if ($news_item && is_array($news_item)){
				$news_order = $_GET['news_order'];
				$news_articles = array();
				foreach ($news_order as $index=>$k){
					$article = $news_item[$k];
					if ($article['title'] && $article['author'] && $article['content'] && $article['thumb_media_id']){
						array_push($news_articles, array(
								'title'=>urlencode($article['title']),
								'author'=>urlencode($article['author']),
								'digest'=>urlencode($article['digest']),
								'thumb_media_id'=>$article['thumb_media_id'],
								'content'=>urlencode($article['content']),
								'content_source_url'=>urlencode($article['content_source_url'])
						));
					}
				}
				if ($news_articles) {
					$access_token = weixin_get_access_token(setting('wx_appid'), setting('wx_appsecret'));
					$news_articles = array('articles'=>$news_articles);
					$news_articles = urldecode(json_encode($news_articles));
					$res = weixin_add_news($access_token, $news_articles);
					if ($res['media_id']){
						$this->showAjaxReturn();
					}else {
						$this->showAjaxError($res['errcode'], $res['errmsg']);
					}
				}else {
					$this->showAjaxError(100);
				}
			}
		}else {
			include template('weixin/weixin_news_form');
		}
	}
	
	public function edit(){
		global $_G,$_lang;
		$media_id = trim($_GET['media_id']);
		$access_token = weixin_get_access_token(setting('wx_appid'), setting('wx_appsecret'));
		if ($this->checkFormSubmit()) {
			$news_item = $_GET['news_item'];
			if ($news_item && is_array($news_item)){
				$news_order = $_GET['news_order'];
				foreach ($news_order as $index=>$k){
					$article = $news_item[$k];
					$access_data = array(
							'media_id'=>$media_id,
							'index'=>$index,
							'articles'=>array(
									'title'=>urlencode($article['title']),
									'author'=>urlencode($article['author']),
									'digest'=>urlencode($article['digest']),
									'thumb_media_id'=>$article['thumb_media_id'],
									'content'=>urlencode($article['content']),
									'content_source_url'=>urlencode($article['content_source_url'])
							)
					);
					$access_data = urldecode(json_encode($access_data));
					$res = weixin_update_news($access_token, $access_data);
					print_r($res);
				}
				$this->showAjaxReturn();
			}
		}else {
			$news = weixin_get_material($access_token, $media_id, 'news');
			$news_item = $news['news_item'];
			include template('weixin/weixin_news_form');
		}
	}
}