<?php
namespace Jsapi;
class AlbumController extends BaseController{
	public function index(){
		
	}
	
	/**
	 * 创建相册列表
	 */
	public function add_album(){
		$title = htmlspecialchars($_GET['title']);
		$isopen = intval($_GET['isopen']);
		$password = trim($_GET['password']);
		if(!$isopen){
			$password = getPassword($password);
		}
		if ($title) {
			$alnum = album_add_data(array(
					'uid'=>$this->uid,
					'title'=>$title,
					'isopen'=>$isopen,
					'password'=>$password,
					'dateline'=>TIMESTAMP
			), true);
			$this->showAjaxReturn($alnum);
		}else {
			$this->showAjaxError(100, 'PARAMETER INCORRECT');
		}
	}
	
	/**
	 * 获取专辑信息
	 */
	public function get_album(){
		$albumid = intval($_GET['albumid']);
		$this->showAjaxReturn(album_get_data(array('uid'=>$this->uid, 'albumid'=>$albumid)));
	}
	
	/**
	 * 获取相册列表
	 */
	public function batchget_album(){
		$condition = array('uid'=>$this->uid);
		$albumlist = album_get_list($condition, 0);
		if ($albumlist) {
			$datalist = $albumids = array();
			foreach ($albumlist as $album){
				$album['total_count'] = 0;
				$datalist[$album['albumid']] = $album;
				array_push($albumids, $album['albumid']);
			}
			$albumlist = $datalist;
			
			$albumids = $albumids ? implodeids($albumids) : 0;
			$countlist = $this->m('material')->field('albumid,COUNT(*) AS total_count')
			->where(array('albumid'=>array('IN', $albumids), 'type'=>'image'))->group('albumid')->select();
			if ($countlist) {
				foreach ($countlist as $count){
					$albumlist[$count['albumid']]['total_count'] = $count['total_count'];
				}
			}
			$total_count = material_get_count(array('uid'=>$this->uid, 'type'=>'image'));
			$albumlist = array_merge(array('0'=>array(
					'albumid'=>0,
					'uid'=>$this->uid,
					'title'=>L('all_photo'),
					'dateline'=>TIMESTAMP,
					'isopen'=>1,
					'total_count'=>$total_count
			)), $albumlist);
			unset($albumids, $countlist, $count, $datalist);
		}
		$this->showAjaxReturn(array_values($albumlist));
	}
}