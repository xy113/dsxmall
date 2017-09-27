<?php
namespace Model\Admin;
class MenuController extends BaseController{
    /**
     * MenuController constructor.
     */
    function __construct()
    {
        parent::__construct();
        $_GET['menu'] = 'menu';
    }

    public function index(){
		$menuid = intval($_GET['menuid']);
		if ($menuid) {
			$this->itemlist();
		}else {
			$this->menulist();
		}
	}
	
	public function menulist(){
		global $_G,$_lang;
		if ($this->checkFormSubmit()){
			$delete = $_GET['delete'];
			if ($delete && is_array($delete)){
				$deleteids = implodeids($delete);
				menu_delete_data(array('id'=>array('IN', $deleteids)));
			}
			$menulist = $_GET['menulist'];
			if ($menulist && is_array($menulist)){
				$displayorder = 0;
				foreach ($menulist as $id=>$menu){
					if ($menu['name']){
						$menu['type'] = 'menu';
						$menu['displayorder'] = $displayorder;
						$displayorder++;
						if ($id > 0){
							menu_update_data(array('id'=>$id), $menu);
						}else {
							menu_add_data($menu);
						}
					}
				}
			}
			menu_update_cache();
			$this->showSuccess('save_succeed');
		}else {
			$menulist = menu_get_list(array('type'=>'menu'), 0);
			include template('menu_name_list');
		}
	}
	
	public function itemlist(){
		global $_G,$_lang;
		$menuid = intval($_GET['menuid']);
		if ($this->checkFormSubmit()){
			$delete = $_GET['delete'];
			if ($delete && is_array($delete)){
				$deleteids = implodeids($delete);
				menu_delete_data(array('id'=>array('IN', $deleteids)));
			}
			$itemlist = $_GET['itemlist'];
			if ($itemlist && is_array($itemlist)){
				$displayorder = 0;
				foreach ($itemlist as $id=>$item){
					$item['type'] = 'item';
					$item['menuid'] = $menuid;
					$item['displayorder'] = $displayorder;
					$displayorder++;
					if ($item['name']) {
						if ($id > 0){
							menu_update_data(array('id'=>$id), $item);
						}else {
							menu_add_data($item);
						}
					}
				}
			}
			menu_update_cache();
			$this->showSuccess('save_succeed');
		}else {
			$menu = menu_get_data(array('id'=>$menuid));
			$itemlist = menu_get_list(array('type'=>'item', 'menuid'=>$menuid), 0);
			if ($itemlist) {
				$datalist = array();
				foreach ($itemlist as $item){
					$datalist[$item['id']] = $item;
				}
				$itemlist = $datalist;
				unset($datalist, $item);
			}
			include template('menu_item_list');
		}
	}
	
	private function printItems($items, $fid=0){
		$html = '';
		if (is_array($items)) {
			foreach ($items as $id=>$item){
				if ($item['fid'] == $fid){
					$disabled = $item['type'] == 'system' ? ' disabled' : '';
					$target[$item['target']] == ' selected';
					$available = $item['available'] ? ' checked' : '';
					$iconurl = image($item['icon']);
					echo <<<END
					<div class="menu-item">				     
				     <table cellpadding="0" cellspacing="0" width="100%" class="listtable">
				        <tbody>
				            <tr>
				            	<td width="20">
				            		<input type="checkbox" class="checkbox checkmark" name="delete[]" value="$id">
				            		<input type="hidden" name="itemlist[$id][fid]" class="fid" value="$item[fid]">
				            	</td>
				            	<td width="50"><img src="$iconurl" width="50" height="50" rel="menuicon" data-id="{$id}"></td>
				            	<td width="100"><input type="text" name="itemlist[$id][name]" class="input-text w100" value="$item[name]"></td>
				                <td><input type="text" name="itemlist[$id][url]" class="input-text w300" value="$item[url]"$disabled></td>
				                <td width="80">
				                	<select name="itemlist[$id][target]">
				                        <option value="_self"$target[_self]>本窗口</option>
				                        <option value="_blank"$target[_blank]>新窗口</option>
				                        <option value="_top"$target[_top]>顶层框架</option>
				                    </select>
				                </td>
				                <td width="40"><input type="checkbox" name="itemlist[$id][available]" value="1" $available></td>
				            </tr>
				        </tbody>
				    </table>
				    <div class="sub-menu" data-id="$id" style="padding-left:30px; min-height:10px;">
	
END;
					$this->printItems($items, $id);
					echo '</div></div>';
				}
			}
		}
	}
	
	public function setimage(){
		$id = intval($_GET['id']);
		$image = trim($_GET['image']);
		menu_update_data(array('id'=>$id), array('icon'=>$image));
		menu_update_cache();
		$this->showAjaxReturn();
	}
}