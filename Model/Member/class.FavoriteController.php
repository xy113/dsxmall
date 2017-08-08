<?php
namespace Model\Member;
class FavoriteController extends BaseController{
	public function index(){
		global $_G,$_lang;
		$condition = array('uid'=>$this->uid);
		$keyword = htmlspecialchars($_GET['keyword']);
		if ($keyword) $condition['title'] = array('LIKE', $keyword);
		
		$pagesize  = 20;
		$totalnum  = favorite_get_count($condition);
		$pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
		$itemlist = favorite_get_list($condition, $pagesize, ($_G['page']-1)*$pagesize, 'favid DESC');
		$pages = $this->showPages($_G['page'], $pagecount, $totalnum, "keyword=$keyword", 1);
		include template('favorite_index');
	}
	
	/**
	 * 添加收藏
	 */
	public function add(){
		$dataid = intval($_GET['dataid']);
		$datatype = trim($_GET['datatype']);
		if (!$dataid || !$datatype) {
			$this->showAjaxError(100, L('invalid_parameter'));
		}else {
			if (favorite_get_num(array('dataid'=>$dataid, 'datatype'=>$datatype)) > 0){
				$this->showAjaxReturn(0);
			}else {
				if ($datatype == 'article') {
					$article = post_get_item(array('id'=>$dataid));
					favorite_add_data(array(
							'uid'=>$this->uid,
							'dataid'=>$dataid,
							'datatype'=>'article',
							'title'=>$article['title'],
							'image'=>$article['image'],
							'dateline'=>TIMESTAMP
					));
					$this->showAjaxReturn(0);
				}
			}
		}
	}
	
	/**
	 * 取消收藏
	 */
	public function remove(){
		$favid = intval($_GET['favid']);
		if (favorite_delete_data(array('uid'=>$this->uid,'favid'=>$favid))){
			$this->showAjaxReturn(0);
		}else {
			$this->showAjaxError(1);
		}
	}
}