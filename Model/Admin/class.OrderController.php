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
			    if ($_GET['option'] == 'delete'){
			        foreach ($orders as $order_id){
                        $order = order_get_data(array('order_id'=>$order_id));
                        order_delete_data(array('order_id'=>$order_id));
                        order_delete_item(array('order_id'=>$order_id));
                        order_delete_action(array('order_id'=>$order_id));
                        order_delete_shipping(array('order_id'=>$order_id));
                        trade_delete_data(array('trade_no'=>$order['trade_no']));
                    }
                    $this->showSuccess('delete_succeed');
                }
            }else {
                $this->showError('no_select');
            }
		}else {
			$condition = array();
			$q = htmlspecialchars($_GET['q']);
			if ($q) $condition[] = "`order_no`='$q' OR `buyer_name` LIKE '%$q%' OR `seller_name` LIKE '%$q%'";
			
			$pagesize = 20;
			$totalnum = order_get_count($condition);
			$pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
			$order_list = order_get_list($condition, $pagesize, ($_G['page'] - 1)*$pagesize, 'order_id DESC');
			$pages = $this->showPages($_G['page'], $pagecount, $totalnum, "q=$q", 1);
			
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
			}
			include template('order_list');
		}
	}

    /**
     * 下载订单
     */
    public function download(){
        $excelfile = CACHE_PATH.'excel_orders.xls';
        $offset = intval(cookie('export_offset'));

        $excel = new ExcelXML();
        if ($offset == 0){
            file_put_contents($excelfile, $excel->getHeader());
            file_put_contents($excelfile, $excel->getRow(array(
                '商品名称','订单编号','卖家账号','买家账号','订单金额','下单时间','付款方式','支付状态','发货状态'
            )), FILE_APPEND);
        }

        $condition = array();
        $q = htmlspecialchars($_GET['q']);
        if ($q) $condition[] = "`order_no`='$q' OR `buyer_name` LIKE '%$q%' OR `seller_name` LIKE '%$q%'";

        $pagesize = 100;
        $order_list = order_get_list($condition, $pagesize, $offset, 'order_id DESC');

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
        $excelfile = CACHE_PATH.'excel_orders.xls';
        Download::downExcel($excelfile, null, true);
    }

    /**
     * 订单详情
     */
    public function detail(){
        global $_G,$_lang;

        $order_id = intval($_GET['order_id']);
        $order = order_get_data(array('order_id'=>$order_id));
        $itemlist = order_get_item_list(array('order_id'=>$order_id));

        if ($order['shipping_status']){
            $shipping = order_get_shipping(array('order_id'=>$order_id));
        }else {
            $express_list = M('express')->order('id', 'ASC')->select();
        }
        $back_url = $_SERVER['HTTP_REFERER'];
        $_G['title'] = '订单详情';
        include template('order_detail');
    }
}