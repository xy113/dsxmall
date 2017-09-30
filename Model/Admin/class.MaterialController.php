<?php
namespace Model\Admin;
use Data\Common\MaterialModel;

class MaterialController extends BaseController{
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
			$materials = $_GET['materials'];
			if ($materials && is_array($materials)){
			    $model = new MaterialModel();
                foreach ($model->where(array('id'=>array('IN', implodeids($materials))))->select() as $material){
                    if ($material['path']) @unlink(C('ATTACHDIR').$material['type'].'/'.$material['path']);
                    if ($material['thumb']) @unlink(C('ATTACHDIR').$material['type'].'/'.$material['thumb']);
                    $model->where(array('id'=>$material['id']))->delete();
                }
			}
            $this->showAjaxReturn();
		}else {

			$condition = $queryParams = array();

            $type = $_GET['type'] ? $_GET['type'] : 'image';
            $condition[] = "m.type='$type'";
            $queryParams['type'] = $type;

			$uid = htmlspecialchars($_GET['uid']);
			if ($uid) {
			    $condition[] = "m.uid='$uid'";
			    $queryParams['uid'] = $uid;
            }

            $username = htmlspecialchars($_GET['username']);
			if ($username) {
			    $condition[] = "mb.username='$username'";
			    $queryParams['username'] = $username;
            }

            $name = htmlspecialchars($_GET['name']);
			if ($name) {
			    $condition[] = "m.name LIKE '%$name%'";
			    $queryParams['name'] = $name;
            }

            $time_begin = htmlspecialchars($_GET['time_begin']);
			if ($time_begin) {
			    $condition[] = "m.dateline>".strtotime($time_begin);
			    $queryParams['time_begin'] = $time_begin;
            }

            $time_end = htmlspecialchars($_GET['time_end']);
			if ($time_end) {
			    $condition[] = "m.dateline<".strtotime($time_end);
			    $queryParams['time_end'] = $time_end;
            }

            $pagesize = 20;
			$totalcount = M('material m')->join('member mb', 'mb.uid=m.uid')->where($condition)->count();
			$pagecount = $totalcount < $pagesize ? 1 : ceil($totalcount/$pagesize);
			$itemlist = M('material m')->join('member mb', 'mb.uid=m.uid')->field('m.*,mb.username')
                ->where($condition)->page($_G['page'], $pagesize)->order('m.id', 'DESC')->select();
			$pagination = $this->pagination($_G['page'], $pagecount, $totalcount, http_build_query($queryParams), true);
			unset($condition, $queryParams);
			
			//载入模板
			include template('material_list');
		}
	}
}