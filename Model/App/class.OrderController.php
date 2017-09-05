<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/29
 * Time: 下午3:01
 */

namespace Model\App;


class OrderController extends BaseController
{
    public function index(){
        $this->itemlist();
    }

    /**
     * 订单管理
     */
    public function itemlist(){
        global $_G,$_lang;
        $tab = $_GET['tab'] ? htmlspecialchars($_GET['tab']) : 'all';

        $condition = array('buyer_uid'=>$this->uid);
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
        $offset   = ($_G['page'] - 1) * $pagesize;
        $totalnum = order_get_count($condition);
        $pagecount  = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
        $_G['page'] = min(array($_G['page'], $pagecount));
        $order_list = order_get_list($condition, $pagesize, $offset, 'order_id DESC');
        $pages = $this->showPages($_G['page'], $pagecount, $totalnum, "", 1);

        if ($order_list) {
            $datalist = $order_ids = array();
            foreach ($order_list as $order){
                $order['item_count'] = 0;
                $order['trade_status'] = order_get_trade_status($order);
                $order['trade_status_tips'] = $_lang['order_trade_status'][$order['trade_status']];
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
                    $order_list[$item['order_id']]['item_count']+= $item['quantity'];
                    $order_list[$item['order_id']]['items'][$item['itemid']] = $item;
                }
            }
            unset($order_ids, $itemlist, $item);
        }

        $_G['title'] = $_lang['order_list'];
        include template('order_list');
    }

    /**
     * 订单详情
     */
    public function detail(){
        global $_G,$_lang;

        $order_id = intval($_GET['order_id']);
        $order = order_get_data(array('order_id'=>$order_id, 'buyer_uid'=>$this->uid));
        $shop  = shop_get_data(array('shop_id'=>$order['shop_id']));
        $itemlist = order_get_item_list(array('order_id'=>$order_id));
        $trade_status = order_get_trade_status($order);
        $trade_status_tips = $_lang['order_trade_status'][$trade_status];
        if ($trade_status == 3) $shipping = order_get_shipping(array('order_id'=>$order_id));

        $_G['title'] = '订单详情';
        include template('order_detail');
    }
}