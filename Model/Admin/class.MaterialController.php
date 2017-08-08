<?php
namespace Model\Admin;
class MaterialController extends BaseController{
    function __construct()
    {
        parent::__construct();
        $_GET['menu'] = 'material';
    }

    /**
     *
     */
    public function index(){
		$this->itemlist();
	}
	/**
	 * 素材列表
	 */
	public function itemlist(){
		global $_G,$_lang;
		if ($this->checkFormSubmit()){
			$material_ids = $_GET['id'];
			if ($material_ids && is_array($material_ids)){
				$material_ids = implodeids($material_ids);
				if ($_GET['option'] == 'delete'){
					$itemlist = material_get_list(array('id'=>array('IN', $material_ids)), 0);
					foreach ($itemlist as $item){
						if ($item['path']) @unlink(C('ATTACHDIR').$item['type'].'/'.$item['path']);
						if ($item['thumb']) @unlink(C('ATTACHDIR').$item['type'].'/'.$item['thumb']);
					}
					material_delete_data(array('id'=>array('IN', $material_ids)));
					$this->showAjaxReturn();
				}
			}else {
				$this->showAjaxError(-1);
			}
		}else {
			$pagesize = 20;
			$condition = array();
			$type = $_GET['type'] ? $_GET['type'] : 'image';
			$condition['type'] = $type;
			
			$keyword = trim($_GET['keyword']);
			if ($keyword) $condition['name'] = array('LIKE', $keyword);
			$total_count = material_get_count($condition);
			$page_count = $total_count < $pagesize ? 1 : ceil($total_count/$pagesize);
			$itemlist = material_get_list($condition, $pagesize, ($_G['page']-1)*$pagesize);
			$pages = $this->showPages($_G['page'], $page_count, $total_count,"type=$type&keyword=$keyword", 1);
			
			if ($itemlist) {
				$datalist = $uids = array();
				foreach ($itemlist as $item){
					$datalist[$item['id']] = $item;
					array_push($uids, $item['uid']);
				}
				$itemlist = $datalist;
				$uids = $uids ? implodeids($uids) : 0;
				$userlist = member_get_list(array('uid'=>array('IN', $uids)), 0);
				unset($datalist, $uids, $item);
			}
			
			if ($type == 'image') {
				$allowtypes = setting('image_allow_types') ? explode(',', setting('image_allow_types')) : array('jpg,jpeg,png,gif');
			}elseif ($type == 'voice'){
				$allowtypes = array('mp3','wma');
			}elseif ($type == 'video'){
				$allowtypes = array('mp4');
			}elseif ($type == 'doc'){
				$allowtypes = array('txt','doc','xls','ppt','docx','xlsx','pptx','pdf');
			}else {
				$allowtypes = explode(',', setting('file_allow_types'));
			}
			$file_types = $comma = '';
			foreach ($allowtypes as $t){
				$file_types.= $comma.'*.'.$t;
				$comma = ';';
			}
			unset($allowtypes, $comma, $t);
			include template('material_list');
		}
	}
	
	/**
	 * 添加素材
	 */
	public function add(){
		global $_G,$_lang;
		if ($this->checkFormSubmit()){
			
		}else {
			
			include template('material_form');
		}
	}
}