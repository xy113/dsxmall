<?php
namespace Jsapi;

class AttachController extends  BaseController{
	public function index(){}
	
	public function get_list(){
		$type = $_GET['type'];
		$condition = array('uid'=>$this->uid);
		$video_type = array('mp4', 'rm', 'rmvb', 'wmv');
		$voice_type = array('mp3', 'wma', 'wav', 'amr');
		$doc_type = array('doc','xls', 'ppt', 'docx', 'xlsx', 'pptx', 'txt', 'pdf');
		if ($type && $type == 'video'){
			$condition['attachtype'] = array('IN', implodeids($video_type));
		}elseif ($type && $type == 'voice'){
			$condition['attachtype'] = array('IN', implodeids($voice_type));
		}elseif ($type && $type == 'doc'){
			$condition['attachtype'] = array('IN', implodeids($doc_type));
		}elseif ($type && $type == 'other'){
			$other_type = array_merge($video_type, $voice_type, $doc_type);
			$condition['attachtype'] = array('NOT IN', implodeids($other_type));
		}
		
		$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
		$count = isset($_GET['count']) ? intval($_GET['count']) : 20;
		
		$itemlist = attach_get_list($condition, $count, $offset, 'attachid DESC');
		if ($itemlist) {
			$datalist = array();
			foreach ($itemlist as $item){
				$item['formated_size'] = formatsize($item['attachsize']);
				$item['attachurl'] = attachment($item['attachment']);
				$datalist[$item['attachid']] = $item;
			}
			$itemlist = $datalist;
		}
		$this->showAjaxReturn($itemlist);
	}
	
	public function get_count(){
		$type = $_GET['type'];
		$condition = array('uid'=>$this->uid);
		if ($type) $condition['attachtype'] = $type;
		$this->showAjaxReturn(array('count'=>attach_get_num($condition)));
	}
	
	public function upload(){
		if ($_GET['from'] == 'swfupload'){
			$uid = $_GET['uid'];
			$access_token = $_GET['access_token'];
			if ($access_token == md5(FORMHASH.$uid)){
				G('uid', $uid);
			}
			//$this->showAjaxReturn($_GET);
		}
		if (G('uid')) {
			if ($filedata = attach_upload_data('filedata')){
				$filedata['formated_size'] = formatsize($filedata['attachsize']);
				$filedata['attachurl'] = attachment($filedata['attachment']);
				$this->showAjaxReturn($filedata);
			}
		}else {
			$this->showAjaxError(-1, 'upload_failed');
		}
	}
}