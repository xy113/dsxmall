<?php
namespace Model\Admin;

class WxmenuController extends BaseController{
    /**
     * WxmenuController constructor.
     */
    function __construct()
    {
        parent::__construct();
        $_GET['menu'] = 'wxmenu';
    }

    /**
	 * 微信菜单列表
	 */
	public function index(){
		global $_G,$_lang;
		if ($this->checkFormSubmit()) {
			$delete = $_GET['delete'];
			if ($delete && is_array($delete)){
				$deleteids = implodeids($delete);
				$this->m('weixin_menu')->where("id IN($deleteids)")->delete();
			}
			$menulist = $_GET['menulist'];
			if ($menulist && is_array($menulist)){
				$displayorder = 0;
				foreach ($menulist as $id=>$menu){
					$displayorder++;
					$menu['displayorder'] = $displayorder;
					$this->m('weixin_menu')->where(array('id'=>$id))->update($menu);
				}
			}
			$this->showSuccess('update_succeed');
		}else {
			$menulist = $this->m('weixin_menu')->order('displayorder ASC, id ASC')->select();
			if ($menulist) {
				$datalist = array();
				foreach ($menulist as $menu){
					$datalist[$menu['fid']][$menu['id']] = $menu;
				}
				$menulist = $datalist;
				unset($datalist, $menu);
			}
			include template('weixin_menu_list');
		}
	}
	
	/**
	 * 添加微信菜单
	 */
	public function add(){
		global $_G,$_lang;
		if ($this->checkFormSubmit()){
			$menu = $_GET['menu'];
			if ($menu['name']) {
				$menu['fid'] = intval($_GET['fid']);
				$id = $this->m('weixin_menu')->insert($menu, true);
				$this->showAjaxReturn($id);
			}else {
				$this->showAjaxError(-1);
			}
		}else {
			include template('weixin_menu_form');
		}
	}
	
	/**
	 * 编辑微信菜单
	 */
	public function edit(){
		global $_G,$_lang;
		$id = intval($_GET['id']);
		if ($this->checkFormSubmit()){
			$menu = $_GET['menu'];
			if ($menu['name']) {
				$this->m('weixin_menu')->where(array('id'=>$id))->update($menu);
				$this->showAjaxReturn($id);
			}else {
				$this->showAjaxError(-1);
			}
		}else {
			$menu = $this->m('weixin_menu')->where(array('id'=>$id))->getOne();
			include template('weixin_menu_form');
		}
	}
	
	/**
	 * 应用菜单
	 */
	public function apply(){
		$menulist = $this->m('weixin_menu')->order('displayorder ASC, id ASC')->select();
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
				}else {
					//无二级菜单
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

			$token = weixin_get_access_token(setting('wx_appid'), setting('wx_appsecret'));
			$res = weixin_create_menu($token, $jsondata);
			if ($res['errcode'] == 0){
				$this->showAjaxReturn($datalist);
			}else {
				$this->showAjaxError(-1, $res, $datalist);
			}
		}else {
			$token = weixin_get_access_token(setting('wx_appid'), setting('wx_appsecret'));
			weixin_delete_menu($token);
			$this->showAjaxReturn(0);
		}
	}
	
	/**
	 * 删除菜单
	 */
	public function remove(){
		$token = weixin_get_access_token(setting('wx_appid'), setting('wx_appsecret'));
		$res = weixin_delete_menu($token);
		if ($res['errcode'] == 0) {
			$this->showAjaxReturn(0);
		}else {
			$this->showAjaxError(-1);
		}
	}
}