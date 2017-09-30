<?php
namespace Model\Admin;
use Core\Download;
use Core\ExcelXML;

class OrderController extends BaseController{
    /**
     * OrderController constructor.
     */
    function __construct()
    {
        parent::__construct();
        G('menu', 'order');
    }

    public function index(){
		$this->itemlist();
	}

    /**
     * 订单列表
     */
    public function itemlist(){
		global $_G,$_lang;
		if ($this->checkFormSubmit()){
            $orders = $_GET['orders'];
			if ($orders && is_array($orders)){
			    if ($_GET['eventType'] == 'delete'){
			        foreach ($orders as $order_id){
                        $order = order_get_data(array('order_id'=>$order_id));
                        order_delete_data(array('order_id'=>$order_id));
                        order_delete_item(array('order_id'=>$order_id));
                        order_delete_action(array('order_id'=>$order_id));
                        order_delete_shipping(array('order_id'=>$order_id));
                        order_delete_refund(array('order_id'=>$order_id));
                        trade_delete_data(array('trade_no'=>$order['trade_no']));
                    }
                    //$this->showSuccess('delete_succeed');
                    $this->showAjaxReturn();
                }
            }else {
                //$this->showError('no_select');
                $this->showAjaxError(1, 'no_select');
            }
		}else {
			$condition = array();
            $tab = $_GET['tab'] ? htmlspecialchars($_GET['tab']) : 'all';
            if ($tab == 'waitPay'){
                $condition['is_closed'] = 0;
                $condition['pay_status'] = 0;
                $condition['shipping_status'] = 0;
                $condition['receive_status'] = 0;
                $condition['refund_status'] = 0;
            }elseif ($tab == 'waitSend'){
                $condition['is_closed'] = 0;
                $condition['pay_status'] = 1;
                $condition['shipping_status'] = 0;
                $condition['receive_status'] = 0;
                $condition['refund_status'] = 0;
            }elseif ($tab == 'send'){
                $condition['is_closed'] = 0;
                $condition['pay_status'] = 1;
                $condition['shipping_status'] = 1;
                $condition['receive_status'] = 0;
                $condition['refund_status'] = 0;
            }elseif ($tab == 'received') {
                $condition['is_closed'] = 0;
                $condition['pay_status'] = 1;
                $condition['shipping_status'] = 1;
                $condition['receive_status'] = 1;
                $condition['review_status'] = 0;
                $condition['refund_status'] = 0;
            }elseif ($tab == 'reviewed'){
                $condition['is_closed'] = 0;
                $condition['pay_status'] = 1;
                $condition['shipping_status'] = 1;
                $condition['receive_status'] = 1;
                $condition['review_status'] = 1;
                $condition['refund_status'] = 0;
            }elseif ($tab == 'refunding'){
                $condition['is_closed'] = 0;
                $condition['pay_status'] = 1;
                $condition['refund_status'] = 1;
            }elseif ($tab == 'closed'){
                $condition['is_closed'] = 1;
            }

            $queryParams = array();
            $itemid = htmlspecialchars($_GET['itemid']);
            if ($itemid) {
                $condition['itemid'] = intval($itemid);
                $queryParams['itemid'] = $itemid;
            }

            $order_no = htmlspecialchars($_GET['order_no']);
            if ($order_no) {
                $condition['order_no'] = $order_no;
                $queryParams['order_no'] = $order_no;
            }

            $buyer_name = htmlspecialchars($_GET['buyer_name']);
            if ($buyer_name) {
                $condition['buyer_name'] = array('LIKE', $buyer_name);
                $queryParams['buyer_name'] = $buyer_name;
            }

            $order_status = intval($_GET['order_status']);
            if ($order_status) {
                switch ($order_status){
                    case 1:
                        $condition['is_closed'] = 0;
                        $condition['pay_type'] = 1;
                        $condition['pay_status'] = 0;
                        $condition['shipping_status'] = 0;
                        break;
                    case 2:
                        $condition['is_closed'] = 0;
                        $condition['pay_type'] = 1;
                        $condition['pay_status'] = 1;
                        $condition['shipping_status'] = 0;
                        break;
                    case 3:
                        $condition['is_closed'] = 0;
                        $condition['pay_type'] = 1;
                        $condition['pay_status'] = 1;
                        $condition['shipping_status'] = 1;
                        break;
                    case 4:
                        $condition['is_closed'] = 0;
                        $condition['pay_type'] = 1;
                        $condition['pay_status'] = 1;
                        $condition['shipping_status'] = 1;
                        $condition['receive_status'] = 1;
                        break;
                    case 6:
                        $condition['is_closed'] = 0;
                        $condition['pay_type'] = 1;
                        $condition['pay_status'] = 1;
                        $condition['refund_status'] = 1;
                        break;
                    case 7:
                        $condition['is_closed'] = 1;
                        $condition['pay_type'] = 1;
                        $condition['pay_status'] = 1;
                        $condition['receive_status'] = 2;
                        break;
                    default:;
                }
                $queryParams['order_status'] = $order_status;
            }

            $pay_type = intval($_GET['pay_type']);
            if ($pay_type) {
                $condition['pay_type'] = $pay_type;
                $queryParams['pay_type'] = $pay_type;
            }

            $wuliu_status = intval($_GET['wuliu_status']);
            if ($wuliu_status) {
                switch ($wuliu_status){
                    case 1:
                        $condition['shipping_status'] = 0;
                        break;
                    case 2:
                        $condition['shipping_status'] = 1;
                        break;
                    case 3:
                        $condition['shipping_status'] = 1;
                        $condition['receive_status'] = 1;
                        break;
                    default:;
                }
            }

            $title = htmlspecialchars($_GET['title']);
            if ($title) {
                $condition['title'] = array('LIKE', $title);
                $queryParams['title'] = $title;
            }

            $time_begin = htmlspecialchars($_GET['time_begin']);
            $time_end = htmlspecialchars($_GET['time_end']);
            if ($time_begin && !$time_end){
                $condition['create_time'] = array('>', strtotime($time_begin));
                $queryParams['time_begin'] = $time_begin;
            }elseif ($time_begin && $time_end){
                $condition[] = "`create_time`>".strtotime($time_begin)." AND `create_time`<".strtotime($time_end);
                $queryParams['time_begin'] = $time_begin;
                $queryParams['time_end'] = $time_end;
            }
			
			$pagesize = 20;
			$totalnum = order_get_count($condition);
			$pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
			$order_list = order_get_list($condition, $pagesize, ($_G['page'] - 1)*$pagesize, 'order_id DESC');
			$pages = $this->showPages($_G['page'], $pagecount, $totalnum, http_build_query($queryParams), 1);
			unset($condition, $queryParams);
			
			if ($order_list) {
				$uids = $order_ids = $datalist = array();
				foreach ($order_list as $order){
				    $status = order_get_trade_status($order);
				    $order['order_status'] = $_lang['order_trade_status'][$status];
					$datalist[$order['order_id']] = $order;
					$order_ids[] = $order['order_id'];
					array_push($uids, $order['uid'], $order['seller_uid']);
				}
				$order_list = $datalist;

				$order_ids = $order_ids ? implodeids($order_ids) : 0;
				if ($order_ids) {
                    $itemlist = M('order_item')->where(array('order_id'=>array('IN', $order_ids)))->group('order_id')->select();
                    if ($itemlist) {
                        foreach ($itemlist as $item){
                            $order_list[$item['order_id']]['itemid'] = $item['itemid'];
                            $order_list[$item['order_id']]['title'] = $item['title'];
                            $order_list[$item['order_id']]['thumb'] = $item['thumb'];
                        }
                    }
                    unset($order_ids, $itemlist, $item);
                }
			}
			include template('trade/order_list');
		}
	}

    /**
     * 下载订单
     */
    public function download(){
        $excelfile = CACHE_PATH.'orders.xls';
        $offset = intval(cookie('export_offset'));

        $excel = new ExcelXML();
        if ($offset == 0){
            file_put_contents($excelfile, $excel->getHeader());
            file_put_contents($excelfile, $excel->getRow(array(
                '商品名称','订单编号','卖家账号','买家账号','订单金额','下单时间','付款方式','支付状态','发货状态'
            )), FILE_APPEND);
        }

        $condition = array();
        $itemid = htmlspecialchars($_GET['itemid']);
        if ($itemid) {
            $condition['itemid'] = intval($itemid);
            //$queryParams['itemid'] = $itemid;
        }

        $order_no = htmlspecialchars($_GET['order_no']);
        if ($order_no) {
            $condition['order_no'] = $order_no;
            //$queryParams['order_no'] = $order_no;
        }

        $buyer_name = htmlspecialchars($_GET['buyer_name']);
        if ($buyer_name) {
            $condition['buyer_name'] = array('LIKE', $buyer_name);
            //$queryParams['buyer_name'] = $buyer_name;
        }

        $order_status = intval($_GET['order_status']);
        if ($order_status) {
            switch ($order_status){
                case 1:
                    $condition['pay_type'] = 1;
                    $condition['pay_status'] = 0;
                    $condition['shipping_status'] = 0;
                    break;
                case 2:
                    $condition['pay_type'] = 1;
                    $condition['pay_status'] = 1;
                    $condition['shipping_status'] = 0;
                    break;
                case 3:
                    $condition['pay_type'] = 1;
                    $condition['pay_status'] = 1;
                    $condition['shipping_status'] = 1;
                    break;
                case 4:
                    $condition['pay_type'] = 1;
                    $condition['pay_status'] = 1;
                    $condition['shipping_status'] = 1;
                    $condition['receive_status'] = 1;
                    break;
                case 6:
                    $condition['pay_type'] = 1;
                    $condition['pay_status'] = 1;
                    $condition['refund_status'] = 1;
                    break;
                case 7:
                    $condition['pay_type'] = 1;
                    $condition['pay_status'] = 1;
                    $condition['receive_status'] = 2;
                    break;
                default:;
            }
            //$queryParams['order_status'] = $order_status;
        }

        $pay_type = intval($_GET['pay_type']);
        if ($pay_type) {
            $condition['pay_type'] = $pay_type;
            //$queryParams['pay_type'] = $pay_type;
        }

        $wuliu_status = intval($_GET['wuliu_status']);
        if ($wuliu_status) {
            switch ($wuliu_status){
                case 1:
                    $condition['shipping_status'] = 0;
                    break;
                case 2:
                    $condition['shipping_status'] = 1;
                    break;
                case 3:
                    $condition['shipping_status'] = 1;
                    $condition['receive_status'] = 1;
                    break;
                default:;
            }
        }

        $title = htmlspecialchars($_GET['title']);
        if ($title) {
            $condition['title'] = array('LIKE', $title);
            //$queryParams['title'] = $title;
        }

        $time_begin = htmlspecialchars($_GET['time_begin']);
        $time_end = htmlspecialchars($_GET['time_end']);
        if ($time_begin && !$time_end){
            $condition['create_time'] = array('>', strtotime($time_begin));
            //$queryParams['time_begin'] = $time_begin;
        }elseif ($time_begin && $time_end){
            $condition[] = "`create_time`>".strtotime($time_begin)." AND `create_time`<".strtotime($time_end);
            $queryParams['time_begin'] = $time_begin;
            //$queryParams['time_end'] = $time_end;
        }
        $order_list = order_get_list($condition, 100, $offset, 'order_id DESC');

        if ($order_list) {
            $uids = $order_ids = $datalist = array();
            foreach ($order_list as $order){
                $datalist[$order['order_id']] = $order;
                $order_ids[] = $order['order_id'];
                array_push($uids, $order['uid'], $order['seller_uid']);
            }
            $order_list = $datalist;

            $order_ids = $order_ids ? implodeids($order_ids) : 0;
            if ($order_ids) {
                $itemlist = M('order_item')->where(array('order_id'=>array('IN', $order_ids)))->group('order_id')->select();
                if ($itemlist) {
                    foreach ($itemlist as $item){
                        $order_list[$item['order_id']]['itemid'] = $item['itemid'];
                        $order_list[$item['order_id']]['title'] = $item['title'];
                        $order_list[$item['order_id']]['thumb'] = $item['thumb'];
                    }
                }
                unset($order_ids, $itemlist, $item);
            }

            $rows = '';
            foreach ($order_list as $order){
                $offset++;
                $rows.= $excel->getRow(array(
                    $order['title'],$order['order_no'],$order['seller_name'],$order['buyer_name'],
                    formatAmount($order['total_fee']),date('Y-m-d H:i:s', $order['create_time']),
                    ($order['pay_type']==1 ? '在线支付' : '货到付款'), ($order['pay_status'] ? '已支付' : '未支付'),
                    ($order['shipping_status'] ? '已发货' : '未发货')
                ));
            }
            file_put_contents($excelfile, $rows, FILE_APPEND);
            cookie('export_offset', $offset);
            $this->showAjaxReturn();
        }else {
            cookie('export_offset', null);
            file_put_contents($excelfile, $excel->getFooter(), FILE_APPEND);
            $this->showAjaxError(1, 'complete');
        }
    }

    /**
     *
     */
    public function get_excel(){
        $excelfile = CACHE_PATH.'orders.xls';
        Download::downExcel($excelfile, null, true);
    }

    /**
     * 订单详情
     */
    public function detail(){
        global $_G,$_lang;

        $order_id = intval($_GET['order_id']);
        $order = order_get_data(array('order_id'=>$order_id));
        $shop = shop_get_data(array('shop_id'=>$order['shop_id']));
        $itemlist = order_get_item_list(array('order_id'=>$order_id));

        $_G['title'] = '订单详情';
        include template('trade/order_detail');
    }
}