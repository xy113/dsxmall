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
        $q = $_GET['q'] ? htmlspecialchars($_GET['q']) : '';
        if ($q) $condition['order_no'] = $q;

		$pagesize = 10;
        $totalnum = order_get_count($condition);
        $pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
        $_G['page'] = min(array($_G['page'], $pagecount));
		$offset = ($_G['page'] - 1) * $pagesize;
        $order_list = order_get_list($condition, $pagesize, $offset, 'order_id DESC');
        $pages = $this->showPages($_G['page'], $pagecount, $offset, "", 1);

        if ($order_list) {
            $datalist = $order_ids = array();
            foreach ($order_list as $order){
                $order['trade_status'] = order_get_trade_status($order);
                $order['trade_status_tips']   = $_lang['order_trade_status'][$order['trade_status']];
                $order['shop_short_name']     = cutstr($order['shop_name'], 12, '..');
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

		$_G['title'] = $_lang['order_list'];
		include template('order_list');
	}

    /**
     * 删除订单
     */
    public function delete(){
        $order_id = intval($_GET['order_id']);
        $order = order_get_data(array('order_id'=>$order_id, 'uid'=>$this->uid));
        if ($order) {
            order_delete_data(array('order_id'=>$order_id));
            order_delete_item(array('order_id'=>$order_id));
            order_delete_action(array('order_id'=>$order_id));
            order_delete_shipping(array('order_id'=>$order_id));
            trade_delete_data(array('trade_no'=>$order['trade_no']));
            $this->showAjaxReturn();
        }else {
            $this->showAjaxError(1, 'order_delete_fail');
        }
    }

    /**
     * 查看订单详情
     */
    public function detail(){
        global $_G,$_lang;

        $order_id = intval($_GET['order_id']);
        $order = order_get_data(array('order_id'=>$order_id));
        $trade_status = order_get_trade_status($order);
        $trade_status_tips = $_lang['order_trade_status'][$trade_status];
        if ($trade_status == 3) $shipping = order_get_shipping(array('order_id'=>$order_id));
        $itemlist = order_get_item_list(array('order_id'=>$order_id));

        $_G['title'] = '订单详情';
        include template('order_detail');
    }

    /**
     * 确认收货
     */

    public function confirm(){
        $this->receipt();
    }
    public function receipt(){
        $order_id = intval($_GET['order_id']);
        $password = trim($_GET['password']);
        $order = order_get_data(array('order_id'=>$order_id, 'uid'=>$this->uid));
        if ($order) {
            //验证密码
            $member = member_get_data(array('uid'=>$this->uid), 'password');
            if ($member['password'] !== getPassword($password)){
                $this->showAjaxError('FAIL', 'password_incorrect');
            }
            //验证订单状态
            if (order_get_trade_status($order) == 3){
                //更新订单状态
                order_update_data(array('order_id'=>$order_id),
                    array(
                        'order_status'=>1,
                        'deal_time'=>time()
                    ));
                //打款给卖家
                if ($order['pay_type'] == 1 || $order['pay_type'] == 2){
                    wallet_income($order['seller_uid'], $order['total_fee']);
                }
            }
            $this->showAjaxReturn();
        }else {
            $this->showAjaxError('FAIL', 'order_not_exists');
        }
    }
}