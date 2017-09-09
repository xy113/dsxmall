<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/2
 * Time: 下午2:53
 */
namespace Model\Seller;
use Core\Download;
use Core\ExcelXML;

class SoldController extends BaseController{
    function __construct()
    {
        parent::__construct();
        G('menu', 'sold_item');
    }

    /**
     *
     */
    public function index(){
        $this->itemlist();
    }

    /**
     * 已卖出的宝贝
     */
    public function itemlist(){
        global $_G,$_lang;

        $tab = $_GET['tab'] ? htmlspecialchars($_GET['tab']) : 'all';
        $condition = array('seller_uid'=>$this->uid);
        if ($tab == 'waitPay'){
            $condition['pay_status'] = 0;
        }elseif ($tab == 'waitSend'){
            $condition['pay_status'] = 1;
            $condition['shipping_status'] = 0;
        }elseif ($tab == 'waitConfirm'){
            $condition['pay_status'] = 1;
            $condition['shipping_status'] = 1;
            $condition['order_status'] = 0;
        }elseif ($tab == 'waitRate'){
            $condition['pay_status'] = 1;
            $condition['shipping_status'] = 1;
            $condition['order_status'] = 1;
            $condition['evaluate_status'] = 0;
        }

        $pagesize = 10;
        $totalnum = order_get_count($condition);
        $pagecount  = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
        $_G['page'] = min(array($_G['page'], $pagecount));
        $order_list = order_get_list($condition, $pagesize, ($_G['page'] - 1) * $pagesize, 'order_id DESC');
        $pages = $this->showPages($_G['page'], $pagecount, $totalnum, "", 1);

        if ($order_list) {
            $datalist = $order_ids = array();
            foreach ($order_list as $order){
                $order['order_trade_status'] = order_get_trade_status($order);
                $order['shop_short_name'] = cutstr($order['shop_name'], 12, '..');
                $datalist[$order['order_id']] = $order;
                $order_ids[] = $order['order_id'];
            }

            $order_list = $datalist;
            unset($datalist, $order);

            $order_ids = array_unique($order_ids);
            $order_ids = $order_ids ? implodeids($order_ids) : 0;
            if ($order_ids) {
                $itemlist = order_get_item_list(array('order_id'=>array('IN', $order_ids)));
                foreach ($itemlist as $item){
                    $order_list[$item['order_id']]['items'][$item['itemid']] = $item;
                }
            }
            unset($order_ids, $itemlist, $item);
        }

        $_G['title'] = $_lang['sold_item'];
        include template('sold_list');
    }

    /**
     * 下载订单记录
     */
    public function download(){
        $excelfile = CACHE_PATH.'shop_orders_'.$this->shop_id.'.xls';
        $offset = intval(cookie('export_offset'));

        $excel = new ExcelXML();
        if ($offset == 0){
            file_put_contents($excelfile, $excel->getHeader());
            file_put_contents($excelfile, $excel->getRow(array(
                '商品名称','订单编号','买家账号','订单金额','下单时间','付款方式','支付状态','发货状态'
            )), FILE_APPEND);
        }

        $tab = $_GET['tab'] ? htmlspecialchars($_GET['tab']) : 'all';
        $condition = array('seller_uid'=>$this->uid);
        if ($tab == 'waitPay'){
            $condition['pay_status'] = 0;
        }elseif ($tab == 'waitSend'){
            $condition['pay_status'] = 1;
            $condition['shipping_status'] = 0;
        }elseif ($tab == 'waitConfirm'){
            $condition['pay_status'] = 1;
            $condition['shipping_status'] = 1;
            $condition['order_status'] = 0;
        }elseif ($tab == 'waitRate'){
            $condition['pay_status'] = 1;
            $condition['shipping_status'] = 1;
            $condition['order_status'] = 1;
            $condition['evaluate_status'] = 0;
        }

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
                    $order['title'],$order['order_no'],$order['buyer_name'],
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
        $excelfile = CACHE_PATH.'shop_orders_'.$this->shop_id.'.xls';
        Download::downExcel($excelfile, 'shop_orders_'.$this->shop_id.'.xls', true);
    }
}