<?php
namespace Model\Member;
class WalletController extends BaseController{
    function __construct()
    {
        parent::__construct();
        G('menu', 'wallet');
    }

    /**
     * 交易明细列表
     */
    public function index(){
		global $_G,$_lang;

        $pagesize = 20;
        $condition = array("(`uid`='".$this->uid."' OR payee_uid='".$this->uid."')");
        $date_range = $_GET['date_range'] ? trim($_GET['date_range']) : 'all';
        if ($date_range == '3days'){
            $condition[] = "DATEDIFF(NOW(), FROM_UNIXTIME(trade_time,'%Y-%m-%d %H:%i:%s'))<=3";
        }elseif ($date_range == '7days'){
            $condition[] = "DATEDIFF(NOW(), FROM_UNIXTIME(trade_time,'%Y-%m-%d %H:%i:%s'))<=7";
        }elseif ($date_range == 'oneMonth'){
            $condition[] = "DATEDIFF(NOW(), FROM_UNIXTIME(trade_time,'%Y-%m-%d %H:%i:%s'))<=30";
        }elseif ($date_range == 'threeMonth'){
            $condition[] = "DATEDIFF(NOW(), FROM_UNIXTIME(trade_time,'%Y-%m-%d %H:%i:%s'))<=90";
        }elseif ($date_range == 'oneYear'){
            $condition[] = "DATEDIFF(NOW(), FROM_UNIXTIME(trade_time,'%Y-%m-%d %H:%i:%s'))<=365";
        }
        $trade_type = $_GET['trade_type'] ? trim($_GET['trade_type']) : 'all';
        if ($trade_type !== 'all') $condition['trade_type'] = strtoupper(htmlspecialchars($trade_type));
        $pay_type = $_GET['pay_type'] ? trim($_GET['pay_type']) : 'all';
        if ($pay_type !== 'all') $condition['pay_type'] = htmlspecialchars($pay_type);

        $q = $_GET['q'] ? htmlspecialchars($_GET['q']) : '';
        if ($q) $condition[] = "(trade_no LIKE '%$q%' OR trade_name LIKE '%$q%')";

        $totalnum    = trade_get_count($condition);
        $pagecount   = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
        $_G['page']  = min(array($_G['page'], $pagecount));
        $itemlist = trade_get_list($condition, $pagesize, ($_G['page'] - 1) * $pagesize);
        $pages = $this->showPages($_G['page'], $pagecount, $totalnum, "date_range=$date_range&trade_type=$trade_type&pay_type=$pay_type&q=$q");

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

		$wallet = wallet_get_data($this->uid);
		$_G['title'] = $_lang['account_balance'];
		include template('wallet_index');
	}
}