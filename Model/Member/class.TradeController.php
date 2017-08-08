<?php
namespace Model\Member;
class TradeController extends BaseController{
	public function index(){
		$this->itemlist();
	}
	
	public function itemlist(){
		global $_G,$_lang;

        $pagesize = 20;
        //$condition = array();
		$condition = array("(uid='".$this->uid."' OR payee_uid='".$this->uid."')");
		$q = htmlspecialchars($_GET['q']);
		if ($q) $condition[] = "(trade_no LIKE '%$q%' OR trade_name LIKE '%$q%')";
		

		$totalnum    = trade_get_count($condition);
		$pagecount   = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
        $_G['page']  = min(array($_G['page'], $pagecount));
        $start_limit = ($_G['page'] - 1) * $pagesize;
        $itemlist = trade_get_list($condition, $pagesize, $start_limit);
		$pages = $this->showPages($_G['page'], $pagecount, $totalnum, "");

		if ($itemlist) {
			$datalist = $uids = array();
			foreach ($itemlist as $item){
				if ($item['payee_uid'] == $this->uid) {
					$item['payee_uid'] = $item['uid'];
					$item['trade_fee'] = formatAmount($item['trade_fee']);
				}else {
					$item['trade_fee'] = '- '.formatAmount($item['trade_fee']);
				}
				$item['trade_status_name'] = $item['trade_status'] == 'PAID' ? $_lang['trade_success'] : $_lang['waiting_for_pay'];
				$datalist[$item['trade_id']] = $item;
				array_push($uids, $item['payee_uid']);
			}
			$itemlist = $datalist;
            $uids = array_unique($uids);
			$uids = $uids ? implodeids($uids) : 0;
			$userlist = member_get_list(array('uid'=>array('IN', $uids)), 0);
			unset($datalist, $uids, $item);
		}
		
		$_G['title'] = $_lang['trade_detail'];
		include template('trade_list');
	}
}