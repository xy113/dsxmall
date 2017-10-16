<?php
namespace Model\Admin;
use Core\Download;
use Core\ExcelXML;
use Data\Trade\TradeModel;

class TradeController extends BaseController{
    /**
     * TradeController constructor.
     */
    function __construct()
    {
        parent::__construct();
        G('menu', 'trade');
    }

    public function index(){
		$this->itemlist();
	}

    /**
     *
     */
    public function itemlist(){
		global $_G,$_lang;

		$tradeModel = new TradeModel();
		if ($this->checkFormSubmit()){
			$trades = $_GET['trades'];
			if ($trades) {
			    $ids = implodeids($trades);
			    if ($_GET['eventType'] == 'delete'){
                    $tradeModel->where(array('trade_id'=>array('IN', $ids)))->delete();
                }
                $this->showAjaxReturn();
            }
		}else {
			$condition = $queryParams = array();
            $tab = $_GET['tab'] ? htmlspecialchars($_GET['tab']) : 'all';
            if ($tab == 'paid'){
                $condition['pay_status'] = '1';
            }elseif ($tab == 'unpaid'){
                $condition['pay_status'] = '0';
            }

            $trade_name = htmlspecialchars($_GET['trade_name']);
            if ($trade_name) {
                $condition['trade_name'] = array('LIKE', $trade_name);
                $queryParams['trade_name'] = $trade_name;
            }

            $payer_name = htmlspecialchars($_GET['payer_name']);
            if ($payer_name) {
                $condition['payer_name'] = $payer_name;
                $queryParams['payer_name'] = $payer_name;
            }

            $payee_name = htmlspecialchars($_GET['payee_name']);
            if ($payee_name) {
                $condition['payee_name'] = $payee_name;
                $queryParams['payee_name'] = $payee_name;
            }

            $pay_status = htmlspecialchars($_GET['pay_status']);
            if ($pay_status == 'PAID'){
                $condition['pay_status'] = 1;
                $queryParams['payee_status'] = $pay_status;
            }

            if ($pay_status == 'UNPAID'){
                $condition['pay_status'] = 0;
                $queryParams['payee_status'] = $pay_status;
            }

            $min_fee = htmlspecialchars($_GET['min_fee']);
            if ($min_fee) {
                $condition['trade_fee'] = array('>', floatval($min_fee));
                $queryParams['min_fee'] = $min_fee;
            }

            $max_fee = htmlspecialchars($_GET['max_fee']);
            if ($max_fee) {
                $condition['trade_fee'] = array('<', floatval($max_fee));
                $queryParams['max_fee'] = $max_fee;
            }

            $pay_type = htmlspecialchars($_GET['pay_type']);
            if ($pay_type) {
                $condition['pay_type'] = $pay_type;
                $queryParams['pay_type'] = $pay_type;
            }

            $trade_no = htmlspecialchars($_GET['trade_no']);
            if ($trade_no) {
                $condition['trade_no'] = $trade_no;
                $queryParams['trade_no'] = $trade_no;
            }

            $time_begin = htmlspecialchars($_GET['time_begin']);
            if ($time_begin) {
                $condition['trade_time'] = array('>', strtotime($time_begin));
                $queryParams['time_begin'] = $time_begin;
            }

            $time_end = htmlspecialchars($_GET['time_end']);
            if ($time_begin) {
                $condition['trade_time'] = array('<', strtotime($time_end));
                $queryParams['time_end'] = $time_end;
            }
			
			$pagesize = 20;
			$totalnum = $tradeModel->where($condition)->count();
			$pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
			$itemlist  = $tradeModel->where($condition)->page($_G['page'], $pagesize)->order('trade_id DESC')->select();
			$pages = $this->pagination($_G['page'], $pagecount, $totalnum, http_build_query($queryParams), 1);
			unset($condition, $queryParams);
			
			include template('trade/trade_list');
		}
	}

	public function export(){
        $offset = 0;
        $excelfile = CACHE_PATH.'trade_records.xls';
        $excel = new ExcelXML();
        file_put_contents($excelfile, $excel->getHeader());
        file_put_contents($excelfile, $excel->getRow(array(
            '商品名称','交易流水','收款方','付款方','付款金额','创建时间','付款方式','支付状态'
        )), FILE_APPEND);

        $condition = array();
        $trade_name = htmlspecialchars($_GET['trade_name']);
        if ($trade_name) {
            $condition['trade_name'] = array('LIKE', $trade_name);
        }

        $payer_name = htmlspecialchars($_GET['payer_name']);
        if ($payer_name) {
            $condition['payer_name'] = $payer_name;
        }

        $payee_name = htmlspecialchars($_GET['payee_name']);
        if ($payee_name) {
            $condition['payee_name'] = $payee_name;
        }

        $pay_status = htmlspecialchars($_GET['pay_status']);
        if ($pay_status == 'PAID'){
            $condition['pay_status'] = 1;
        }

        if ($pay_status == 'UNPAID'){
            $condition['pay_status'] = 0;
        }

        $min_fee = htmlspecialchars($_GET['min_fee']);
        if ($min_fee) {
            $condition['trade_fee'] = array('>', floatval($min_fee));
        }

        $max_fee = htmlspecialchars($_GET['max_fee']);
        if ($max_fee) {
            $condition['trade_fee'] = array('<', floatval($max_fee));
        }

        $pay_type = htmlspecialchars($_GET['pay_type']);
        if ($pay_type) {
            $condition['pay_type'] = $pay_type;
        }

        $trade_no = htmlspecialchars($_GET['trade_no']);
        if ($trade_no) {
            $condition['trade_no'] = $trade_no;
        }

        $time_begin = htmlspecialchars($_GET['time_begin']);
        if ($time_begin) {
            $condition['trade_time'] = array('>', strtotime($time_begin));
        }

        $time_end = htmlspecialchars($_GET['time_end']);
        if ($time_begin) {
            $condition['trade_time'] = array('<', strtotime($time_end));
        }

        while (true) {
            $itemlist = (new TradeModel())->where($condition)->limit($offset,50)->order('trade_id DESC')->select();
            if ($itemlist) {
                $rows = '';
                foreach ($itemlist as $item){
                    $offset++;
                    $rows.= $excel->getRow(array(
                        $item['trade_name'],$item['trade_no'],$item['payee_name'],$item['payer_name'],
                        formatAmount($item['trade_fee']),date('Y-m-d H:i:s', $item['trade_time']),
                        $GLOBALS['_lang']['trade_pay_types'][$item['pay_type']],
                        ($item['pay_status'] == 1 ? '已支付' : '未支付')
                    ));
                }
                file_put_contents($excelfile, $rows, FILE_APPEND);
                unset($rows);
            }else {
                file_put_contents($excelfile, $excel->getFooter(), FILE_APPEND);
                $this->showAjaxReturn();
            }
            sleep(1);
        }
    }

    /**
     *
     */
    public function download(){
        $excelfile = CACHE_PATH.'trade_records.xls';
        Download::downExcel($excelfile, 'trade_records.xls', true);
    }
}