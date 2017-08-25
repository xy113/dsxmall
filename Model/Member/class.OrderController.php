<?php
namespace Model\Member;
class OrderController extends BaseController{
    /**
     * OrderController constructor.
     */
    function __construct()
    {
        parent::__construct();
        G('menu', 'order_manage');
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
                    $itemlist[$goods['order_id']]['goods'][$goods['goods_id']] = $goods;
                }
            }
            unset($order_ids, $goods_list, $goods);
        }

		$_G['title'] = $_lang['order_list'];
		include template('order_list');
	}

    /**
     * 删除订单
     */
    public function delete(){
        $order_id = intval($_GET['order_id']);
        $order = order_get_item(array('order_id'=>$order_id, 'uid'=>$this->uid));
        if ($order) {
            order_delete_item(array('order_id'=>$order_id));
            order_delete_goods(array('order_id'=>$order_id));
            order_delete_action(array('order_id'=>$order_id));
            order_delete_shipping(array('order_id'=>$order_id));
            trade_delete_data(array('trade_no'=>$order['trade_no']));
            $this->showAjaxReturn();
        }else {
            $this->showAjaxError(1, L('order_delete_fail'));
        }
    }

    /**
     * 查看订单详情
     */
    public function detail(){
        global $_G,$_lang;

        $order_id = intval($_GET['order_id']);
        $order = order_get_item(array('order_id'=>$order_id));
        $itemlist = order_get_goods_list(array('order_id'=>$order_id));
        $trade_status = order_get_trade_status($order);
        $trade_status_tips = $_lang['order_trade_status'][$trade_status];
        if ($trade_status == 3) $shipping = order_get_shipping(array('order_id'=>$order_id));

        $_G['title'] = '订单详情';
        include template('order_detail');
    }

    /**
     * 确认收货
     */
    public function receipt(){
        $order_id = intval($_GET['order_id']);
        $password = trim($_GET['password']);
        $order = order_get_item(array('order_id'=>$order_id, 'uid'=>$this->uid));
        if ($order) {
            //验证密码
            $member = member_get_data(array('uid'=>$this->uid), 'password');
            if ($member['password'] !== getPassword($password)){
                $this->showAjaxError('FAIL', 'password_incorrect');
            }
            //验证订单状态
            if (order_get_trade_status($order) == 3){
                //更新订单状态
                order_update_item(array('order_id'=>$order_id),
                    array(
                        'order_status'=>1,
                        'deal_time'=>time()
                    ));
                //打款给卖家
                wallet_income($order['seller_uid'], $order['total_fee']);
            }
            $this->showAjaxReturn();
        }else {
            $this->showAjaxError('FAIL', 'order_not_exists');
        }
    }
}