<?php
namespace Model\Admin;
class LinkController extends BaseController{
    /**
     * LinkController constructor.
     */
    function __construct()
    {
        parent::__construct();
        $_GET['menu'] = 'link';
    }

    public function index(){
		if ($this->checkFormSubmit()){
			$delete = $_GET['delete'];
			if ($delete && is_array($delete)){
				$deleteids = implodeids($delete);
				link_delete_data(array('id'=>array('IN', $deleteids)));
			}
			
			$linklist = $_GET['linklist'];
			if ($linklist && is_array($linklist)) {
				foreach ($linklist as $id=>$link){
					if ($link['title']) {
						if ($id > 0){
							link_update_data(array('id'=>$id), $link);
						}else {
							link_add_data($link);
						}
					}
				}
			}
			
			$this->updatecache();
			$this->showSuccess('update_succeed');
			
		}else {
			global $_G,$_lang;
			$categorylist = link_get_list(array('type'=>'category'), 0);
			$linklist = link_get_list(array('type'=>'item'), 0);
			if ($linklist) {
				$datalist = array();
				foreach ($linklist as $link){
					$link['image'] = image($link['image']);
					$datalist[$link['catid']][$link['id']] = $link;
				}
				$linklist = $datalist;
				unset($datalist, $link);
			}
			include template('link_list');
		}
	}
	
	public function setimage(){
		$id = intval($_GET['id']);
		$image = htmlspecialchars($_GET['image']);
		link_update_data(array('id'=>$id), array('image'=>$image));
		$this->updatecache();
		$this->showAjaxReturn(0);
	}
	
	private function updatecache(){
		$categorylist = link_get_list(array('type'=>'category'), 0);
		$linklist = link_get_list(array('type'=>'item'), 0);
		cache('link_cateogory', $categorylist);
		cache('link_item', $linklist);
	}
}