<?php
namespace Model\Member;
class OrderController extends BaseController{
    /**
     * OrderController constructor.
     */
    function __construct()
    {
        parent::__construct();
        $_GET['menu'] = 'order_manage';
    }

    public function index(){
		$this->itemlist();
	}

    /**
     * 订单管理
     */
    public function itemlist(){
		global $_G,$_lang;
		$tab = $_GET['tab'] ? htmlspecialchars($_GET['tab']) : 'all';
		
		$condition = array('uid'=>$this->uid);
		if ($tab == 'free'){
			$condition['order_fee'] = 0;
		}elseif ($tab == 'not_free') {
			$condition['order_fee'] = array('>', 0);
		}
		
		if ($keyword) $condition[] = "(order_name LIKE '%$keyword%' OR order_no LIKE '%$keyword%')";
		
		$pagesize  = 20;
		$totalnum  = order_get_item_count($condition);
		$pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
		$itemlist = order_get_item_list($condition, $pagesize, ($_G['page']-1)*$pagesize, 'order_id DESC');
		$pages = $this->showPages($_G['page'], $pagecount, $totalnum, "tab=$tab&keyword=$keyword", 1);
		
		if ($itemlist) {
			$uids = $datalist = array();
			foreach ($itemlist as $item){
				$datalist[$item['order_id']] = $item;
				array_push($uids, $item['seller_uid']);
			}
			$itemlist = $datalist;
			$uids = $uids ? implodeids($uids) : 0;
			$userlist = member_get_list(array('uid'=>array('IN', $uids)), 0);
			unset($uids, $datalist, $item);
		}

		$_G['title'] = $_lang['order_list'];
		include template('order_list');
	}


}