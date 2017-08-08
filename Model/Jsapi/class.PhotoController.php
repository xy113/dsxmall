<?php
namespace Jsapi;
class PhotoController extends  BaseController{
	public function index(){
		
	}
	
	public function get_count(){
		$condition = array('uid'=>$this->uid);
		$count = photo_get_num($condition);
		$this->showAjaxReturn(array('count'=>$count));
	}
	
	public function get_list(){
		global $G,$lang;
		
		$albumid = intval($_GET['albumid']);
		$condition = array('uid'=>$this->uid);
		if ($albumid) $condition['albumid'] = $albumid;
		
		$pagesize  = 100;
		$totalnum  = photo_get_num($condition);
		$pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
		$photolist = photo_get_page($condition, $G['page'], $pagesize, 'photoid DESC');
		
		$this->showAjaxReturn(array_values($photolist));
	}
	
	public function upload(){
		$albumid = intval($_GET['albumid']);
		$filedata = photo_upload_data();
		if (!$filedata['errno']){
			if ($albumid) photo_update_data(array('photoid'=>$filedata['photoid']), array('albumid'=>$albumid));
			$this->showAjaxReturn($filedata);
		}else {
			$upload_error = L('upload_error');
			$this->showAjaxError($filedata['errno'], $upload_error[$filedata['errno']]);
		}
	}
}