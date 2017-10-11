<?php
namespace Model\Admin;

use Data\Weixin\WeixinMenuModel;
use WxApi\WxMenuApi;

class WxmenuController extends BaseController{

    /**
	 * 微信菜单列表
	 */
	public function index(){
		global $_G,$_lang;

		$model = new WeixinMenuModel();
		if ($this->checkFormSubmit()) {
			$delete = $_GET['delete'];
			if ($delete && is_array($delete)){
			    foreach ($delete as $id){
			        $model->where(array('id'=>$id))->delete();
                }
			}
			$menulist = $_GET['menulist'];
			if ($menulist && is_array($menulist)){
				$displayorder = 0;
				foreach ($menulist as $id=>$menu){
					$displayorder++;
					$menu['displayorder'] = $displayorder;
					$model->where(array('id'=>$id))->data($menu)->save();
				}
			}
			$this->showSuccess('update_succeed');
		}else {
			$menulist = $model->order('displayorder ASC, id ASC')->select();
			if ($menulist) {
				$datalist = array();
				foreach ($menulist as $menu){
					$datalist[$menu['fid']][$menu['id']] = $menu;
				}
				$menulist = $datalist;
				unset($datalist, $menu);
			}
			include template('weixin/menu_list');
		}
	}
	
	/**
	 * 添加微信菜单
	 */
	public function add(){
		global $_G,$_lang;
		if ($this->checkFormSubmit()){
            $newmenu = $_GET['newmenu'];
			if ($newmenu['name']) {
                $newmenu['fid'] = intval($_GET['fid']);
                (new WeixinMenuModel())->data($newmenu)->add();
				$this->showAjaxReturn();
			}else {
				$this->showAjaxError(-1);
			}
		}else {
			include template('weixin/menu_form');
		}
	}
	
	/**
	 * 编辑微信菜单
	 */
	public function edit(){
		global $_G,$_lang;
		$id = intval($_GET['id']);
		$model = new WeixinMenuModel();
		if ($this->checkFormSubmit()){
            $newmenu = $_GET['newmenu'];
			if ($newmenu['name']) {
				$model->where(array('id'=>$id))->data($newmenu)->save();
				$this->showAjaxReturn();
			}else {
				$this->showAjaxError(-1);
			}
		}else {
			$menu = $model->where(array('id'=>$id))->getOne();
			include template('weixin/menu_form');
		}
	}
	
	/**
	 * 应用菜单
	 */
	public function apply(){
		$menulist = (new WeixinMenuModel())->order('displayorder ASC, id ASC')->select();
		if ($menulist) {
			$datalist = array();
			foreach ($menulist as $menu){
				$datalist[$menu['fid']][$menu['id']] = $menu;
			}
			$menulist = $datalist;
			unset($datalist, $menu);
			
			$datalist = array();
			foreach ($menulist[0] as $menu){
				if (count($menulist[$menu['id']]) > 0){
					$submenulist = array();
					foreach ($menulist[$menu['id']] as $submenu){
						if ($submenu['type'] == 'view'){
							if ($submenu['name'] && $submenu['url']){
								array_push($submenulist, array(
										'type'=>$submenu['type'],
										'name'=>urlencode($submenu['name']),
										'url'=>urlencode($submenu['url'])
								));
							}
						}elseif ($submenu['type'] == 'media_id' || $submenu['type'] == 'view_limited'){
							if ($submenu['name'] && $submenu['media_id']){
								array_push($submenulist, array(
										'type'=>$submenu['type'],
										'name'=>urlencode($submenu['name']),
										'media_id'=>urlencode($submenu['media_id'])
								));
							}
						}else{
							if ($submenu['name'] && $submenu['key']){
								array_push($submenulist, array(
										'type'=>$submenu['type'],
										'name'=>urlencode($submenu['name']),
										'key'=>urlencode($submenu['key'])
								));
							}
						}
					}
					
					array_push($datalist, array(
							'name'=>urlencode($menu['name']),
							'sub_button'=>$submenulist
					));
				}else {//无二级菜单
					if ($menu['type'] == 'view'){
						if ($menu['name'] && $menu['url']){
							array_push($datalist, array(
									'type'=>$menu['type'],
									'name'=>urlencode($menu['name']),
									'url'=>urlencode($menu['url'])
							));
						}
					}elseif ($menu['type'] == 'media_id' || $menu['type'] == 'view_limited'){
						if ($menu['name'] && $menu['media_id']){
							array_push($datalist, array(
									'type'=>$menu['type'],
									'name'=>urlencode($menu['name']),
									'media_id'=>urlencode($menu['media_id'])
										
							));
						}
						
					}else{
						if ($menu['name'] && $menu['key']){
							array_push($datalist, array(
									'type'=>$menu['type'],
									'name'=>urlencode($menu['name']),
									'key'=>urlencode($menu['key'])
										
							));
						}
					}
				}
			}
			$menulist = array('button'=>$datalist);
			$jsondata = json_encode($menulist);
			$jsondata = urldecode($jsondata);

			$api = new WxMenuApi();
			$res = $api->create($jsondata);
			if ($res['errcode'] == 0){
				$this->showAjaxReturn();
			}else {
				$this->showAjaxError(-1, 'FAIL', $res);
			}
		}
	}
	
	/**
	 * 删除菜单
	 */
	public function remove(){
		$res = (new WxMenuApi())->delete();
		if ($res['errcode'] == 0) {
			$this->showAjaxReturn(0);
		}else {
			$this->showAjaxError(-1);
		}
	}
}