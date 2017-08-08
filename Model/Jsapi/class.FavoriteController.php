<?php
namespace Jsapi;
class FavoriteController extends  BaseController{
	function __construct(){
		parent::__construct();
		if (!$this->isLogin()){
			$this->showAjaxError(100, L('not_login'));
		}
	}
	public function index(){
		
	}
	
	/**
	 * 添加收藏
	 */
	public function add_favorite(){
		$dataid = intval($_GET['dataid']);
		$datatype = $_GET['datatype'] ? trim($_GET['datatype']) : 'article';
		if (favorite_get_num(array('dataid'=>$dataid,'datatype'=>$datatype, 'uid'=>$this->uid)) == 0){
			//添加收藏
			favorite_add_data(array(
					'uid'=>$this->uid,
					'dataid'=>$dataid,
					'datatype'=>$datatype,
					'dateline'=>TIMESTAMP
			));
			
		}else {
			
		}
		$this->showAjaxReturn(0);
	}
	
	/**
	 * 取消收藏
	 */
	public function del_favorite(){
		$favid = intval($_GET['favid']);
		$dataid = intval($_GET['dataid']);
		$datatype = $_GET['datatype'] ? trim($_GET['datatype']) : 'article';
		if ($favid) {
			favorite_delete_data(array('uid'=>$this->uid, 'favid'=>$favid));
		}else {
			favorite_delete_data(array('dataid'=>$dataid,'datatype'=>$datatype, 'uid'=>$this->uid));
		}
		$this->showAjaxReturn(1);
	}
	
	/**
	 * 获取收藏
	 */
	public function get_favorite(){
		
	}
	
	/**
	 * 批量获取收藏信息
	 */
	public function batchget_favorite(){
		$count = $_GET['count'] ? intval($_GET['count']) : 20;
		$offset = $_GET['offset'] ? intval($_GET['offset']) : 0;
		$datatype = $_GET['datatype'] ? trim($_GET['datatype']) : 'article';
		$itemlist = favorite_get_list(array('uid'=>$this->uid, 'datatype'=>$datatype, $count, $offset, 'favid DESC'));
		$this->showAjaxReturn($itemlist);
	}
}