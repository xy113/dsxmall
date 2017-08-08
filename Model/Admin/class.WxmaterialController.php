<?php
namespace Model\Admin;

class WxmaterialController extends  BaseController{
    function __construct()
    {
        parent::__construct();
        $_GET['menu'] = 'wxmaterial';
    }

    public function index(){
		global $_G,$_lang;
		
		$access_token = weixin_get_access_token(setting('wx_appid'), setting('wx_appsecret'));
		if ($this->checkFormSubmit()) {
			$material_ids = $_GET['media_id'];
			if ($material_ids && is_array($material_ids)){
				if ($_GET['option'] == 'delete') {
					foreach ($material_ids as $media_id){
						weixin_delete_material($access_token, $media_id);
					}
					$this->showSuccess('delete_succeed');
				}
			}else {
				$this->showError('no_select');
			}
		}else {
			$pagesize = 20;
			$type = isset($_GET['type']) ? trim($_GET['type']) : 'image';
			$res = weixin_get_material_list($access_token, $type, ($_G['page']-1)*$pagesize, $pagesize);
			$totalbum = $res['total_count'];
			$itemlist = $res['item'];
			$pagecount = $totalbum < $pagesize ? 1 : ceil($totalbum/$pagesize);
			$pages = $this->showPages($_G['page'], $pagecount, $totalnum, "type=$type", 1);
			include template('weixin_material_list');
		}
	}
	
	public function add(){
		$type = isset($_GET['type']) ? trim($_GET['type']) : 'image';
		$access_token = weixin_get_access_token(setting('wx_appid'), setting('wx_appsecret'));
		$access_data = array();
		$media = trim($_GET['media']);
		if ($type == 'image') {//图片素材
			$access_data = array('media'=>'@'.C('IMAGEDIR').$media);
		}elseif ($type == 'video') {
			$description = json_encode(array('title'=>urlencode($_GET['title']), 'introduction'=>urlencode($_GET['introduction'])));
			$description = urldecode($description);
			$access_data = array('media'=>'@'.C('ATTACHDIR').$media, 'description'=>$description);
		}elseif ($type == 'voice') {
			$access_data = array('media'=>'@'.C('ATTACHDIR').$media);
		}
		//$this->showAjaxReturn($access_data);
		if ($access_data) {
			$res = weixin_add_material($access_token, $type, $access_data);
			if ($res['media_id']) {
				$this->showAjaxReturn();
			}else {
				$this->showAjaxError($res['errcode'], $res['errmsg']);
			}
		}else {
			$this->showAjaxError(-1, 'invalid parameter');
		}
	}
	
	public function viewimage(){
		//ob_end_clean();
		$media_id = trim($_GET['media_id']);
		$access_token = weixin_get_access_token(setting('wx_appid'), setting('wx_appsecret'));
		$res = weixin_get_material($access_token, $media_id, 'image');
		echo $res;
		exit();
	}
}