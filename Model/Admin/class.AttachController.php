<?php
namespace Model\Admin;
class AttachController extends BaseController{
	public function index(){
		global $_G,$_lang;
		if($this->checkFormSubmit()){
			$delete = $_GET['delete'];
			if ($delete && is_array($delete)){
				$deleteids = implode(',', $delete);
				attach_delete_data("attachid IN($deleteids)");
				$this->showSuccess('delete_succeed');
			}else {
				$this->showError('no_select');
			}

		}else {
			$pagesize   = 20;
			$totalnum   = attach_get_num(0);
			$pagecount  = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
			$attachlist = attach_get_page(0, $_G['page'], $pagesize);
			$pages = $this->showPages($_G['page'], $pagecount, $totalnum, '', true);
			if ($attachlist) {
				$datalist = $uids = array();
				foreach ($attachlist as $attach){
					$datalist[$attach['attachid']] = $attach;
					array_push($uids, $attach['uid']);
				}
				$attachlist = $datalist;
				$uids = $uids ? implodeids($uids) : 0;
				if ($uids) {
					$userlist = member_get_list(array('uid'=>array('IN', $uids)), 0);
				}
				unset($datalist, $uids, $attach);
			}
			include template('attach_list');
		}
	}
}