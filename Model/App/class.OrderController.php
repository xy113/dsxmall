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

        $condition = array('uid'=>$this->uid);
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
        $totalnum = order_get_item_count($condition);
        $pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
        $_G['page'] = min(array($_G['page'], $pagecount));
        $start_limit = ($_G['page'] - 1) * $pagesize;
        $itemlist = order_get_item_list($condition, $pagesize, $start_limit, 'order_id DESC');
        $pages = $this->showPages($_G['page'], $pagecount, $start_limit, "", 1);

        if ($itemlist) {
            $datalist = $order_ids = array();
            foreach ($itemlist as $item){
                $item['item_count'] = 0;
                $item['trade_status'] = order_get_trade_status($item);
                $item['trade_status_tips'] = $_lang['order_trade_status'][$item['trade_status']];
                $item['shop_short_name'] = cutstr($item['shop_name'], 12, '..');
                $datalist[$item['order_id']] = $item;
                $order_ids[] = $item['order_id'];
            }

            $itemlist = $datalist;
            unset($datalist);

            $order_ids = array_unique($order_ids);
            $order_ids = $order_ids ? implodeids($order_ids) : 0;
            if ($order_ids) {
                $goods_list = order_get_goods_list(array('order_id'=>array('IN', $order_ids)));
                foreach ($goods_list as $goods){
                    $itemlist[$goods['order_id']]['item_count']+= $goods['goods_number'];
                    $itemlist[$goods['order_id']]['goods'][$goods['goods_id']] = $goods;
                }
            }
            unset($order_ids, $goods_list, $goods);
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
        $order = order_get_item(array('order_id'=>$order_id));
        $shop  = shop_get_data(array('shop_id'=>$order['shop_id']));
        $itemlist = order_get_goods_list(array('order_id'=>$order_id));
        $trade_status = order_get_trade_status($order);
        $trade_status_tips = $_lang['order_trade_status'][$trade_status];
        if ($trade_status == 3) $shipping = order_get_shipping(array('order_id'=>$order_id));

        $_G['title'] = '订单详情';
        include template('order_detail');
    }
}