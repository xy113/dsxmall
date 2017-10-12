<?php
namespace Model\Admin;

use WxApi\Builder\WxMaterialUploadContentBuilder;
use WxApi\Builder\WxVideoUploadContentBuilder;
use WxApi\WxMaterialApi;

class WxmaterialController extends  BaseController{
    function __construct()
    {
        parent::__construct();
        $_GET['menu'] = 'wxmaterial';
    }

    /**
     * 微信素材列表
     */
    public function index(){
		global $_G,$_lang;

        $api = new WxMaterialApi();
		if ($this->checkFormSubmit()) {
			$materials = $_GET['materials'];
			if ($materials && is_array($materials)){
			    foreach ($materials as $media_id){
			        $api->del($media_id);
                }
				$this->showAjaxReturn();
			}else {
				$this->showAjaxError(1,'no_select');
			}
		}else {
			$pagesize = 20;
			$type = isset($_GET['type']) ? trim($_GET['type']) : 'image';
			$data = $api->batchget($type, ($_G['page']-1)*$pagesize, $pagesize);
			$data = json_decode($data, true);
			$totalnum  = $data['total_count'];
			$itemlist  = $data['item'];
			$pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
			$pagination = $this->pagination($_G['page'], $pagecount, $totalnum, "type=$type", 1);
			include template('weixin/material_list');
		}
	}

    /**
     * 添加素材
     */
    public function add(){
		$type = isset($_GET['type']) ? trim($_GET['type']) : 'image';
		$media = htmlspecialchars($_GET['media']);
		if ($type == 'image') {//图片素材
            $builder = new WxMaterialUploadContentBuilder();
            $builder->media = C('ATTACHDIR').'image/'.$media;
			$api = new WxMaterialApi();
			$res = $api->add($type, $builder->getContent());
            $res = json_decode($res, true);
			if ($res['media_id']) {
			    $this->showAjaxReturn(array('media_id'=>$res['media_id']));
            }else {
			    $this->showAjaxError(1, 'FAIL',$res);
            }
		}

		if ($type == 'video'){
		    $builder = new WxVideoUploadContentBuilder();
		    $builder->media = C('ATTACHDIR').'video/'.$media;
		    $builder->title = htmlspecialchars($_GET['title']);
		    $builder->introduction = htmlspecialchars($_GET['introduction']);
		    $api = new WxMaterialApi();
		    $res = $api->add('video', $builder->getContent());
            $res = json_decode($res, true);
            if ($res['media_id']) {
                $this->showAjaxReturn(array('media_id'=>$res['media_id']));
            }else {
                $this->showAjaxError(1, 'FAIL',$res);
            }
        }

        if ($type == 'voice'){
            $builder = new WxMaterialUploadContentBuilder();
            $builder->media = C('ATTACHDIR').'voice/'.$media;
            $api = new WxMaterialApi();
            $res = $api->add($type, $builder->getContent());
            $res = json_decode($res, true);
            if ($res['media_id']) {
                $this->showAjaxReturn(array('media_id'=>$res['media_id']));
            }else {
                $this->showAjaxError(1, 'FAIL',$res);
            }
        }
	}

    /**
     * 显示素材图片
     */
    public function viewimage(){
		//ob_end_clean();
		$media_id = trim($_GET['media_id']);
		$res = (new WxMaterialApi())->get($media_id);
		echo $res;
		exit();
	}
}