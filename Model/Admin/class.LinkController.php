<?php
namespace Model\Admin;
use Data\Common\LinkModel;

class LinkController extends BaseController{

    /**
     *
     */
    public function index(){
        $model = new LinkModel();
		if ($this->checkFormSubmit()){
			$delete = $_GET['delete'];
			if ($delete && is_array($delete)){
				foreach ($delete as $id){
				    $model->where(array('id'=>$id))->delete();
                }
			}
			
			$itemlist = $_GET['itemlist'];
			if ($itemlist && is_array($itemlist)) {
				foreach ($itemlist as $id=>$item){
					if ($item['title']) {
						if ($id > 0){
							$model->where(array('id'=>$id))->data($item)->save();
						}else {
							$model->data($item)->add();
						}
					}
				}
			}
			
			$model->updateCache();
			$this->showSuccess('update_succeed');
			
		}else {
			global $_G,$_lang;

			$categorylist = $model->where(array('type'=>'category'))->select();
			$itemlist = array();
			foreach ($model->where(array('type'=>'item'))->select() as $item){
			    $itemlist[$item['catid']][$item['id']] = $item;
            }
			include template('link_list');
		}
	}

    /**
     *
     */
    public function setimage(){
		$id = intval($_GET['id']);
		$image = htmlspecialchars($_GET['image']);
		if ($id && $image){
            $model = new LinkModel();
            $model->where(array('id'=>$id))->data(array('image'=>$image))->save();
            $model->updateCache();
        }
		$this->showAjaxReturn(0);
	}
}