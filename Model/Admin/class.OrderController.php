<?php
namespace Model\Admin;
class OrderController extends BaseController{
    function __construct()
    {
        parent::__construct();
        $_GET['menu'] = 'order';
    }

    public function index(){
		$this->itemlist();
	}
	
	public function itemlist(){
		global $_G,$_lang;
		if ($this->checkFormSubmit()){
			
		}else {
			$condition = array();
			$keyword = htmlspecialchars($_GET['keyword']);
			if ($keyword) $condition['order_name'] = array('LIKE', $keyword);
			
			$pagesize = 20;
			$totalnum = order_get_item_count($condition);
			$pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
			$itemlist = order_get_item_list($condition, $pagesize, ($_G['page'] - 1)*$pagesize, 'order_id DESC');
			$pages = $this->showPages($_G['page'], $pagecount, $totalnum, "keyword=$keyword", 1);
			
			if ($itemlist) {
				$uids = $datalist = array();
				foreach ($itemlist as $item){
					$datalist[$item['order_id']] = $item;
					array_push($uids, $item['uid'], $item['seller_uid']);
				}
				$itemlist = $datalist;
			
				$uids = $uids ? implodeids($uids) : 0;
				$userlist = member_get_list(array('uid'=>array('IN', $uids)), $pagesize * 2);
				unset($datalist, $uids, $item);
			}
			
			include template('order_list');
		}
	}
}