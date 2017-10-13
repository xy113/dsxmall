<?php
namespace Model\Member;
use Data\Member\MemberModel;
use Data\Trade\OrderClosedModel;
use Data\Trade\OrderItemModel;
use Data\Trade\OrderModel;
use Data\Trade\OrderShippingModel;
use Data\Trade\WalletModel;

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
		
		$condition = array('buyer_uid'=>$this->uid,'is_deleted'=>0);
        if ($tab == 'waitPay'){
            $condition['pay_status'] = 0;
        }elseif ($tab == 'waitSend'){
            $condition['pay_status'] = 1;
            $condition['shipping_status'] = 0;
        }elseif ($tab == 'waitConfirm'){
            $condition['pay_status'] = 1;
            $condition['shipping_status'] = 1;
            $condition['receive_status'] = 0;
        }elseif ($tab == 'waitRate'){
            $condition['pay_status'] = 1;
            $condition['shipping_status'] = 1;
            $condition['receive_status'] = 1;
            $condition['review_status'] = 0;
        }
        $q = $_GET['q'] ? htmlspecialchars($_GET['q']) : '';
        if ($q) $condition['order_no'] = $q;

		$pagesize = 10;
		$orderModel = new OrderModel();
        $totalnum = $orderModel->where($condition)->count();
        $pagecount  = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
        $order_list = $orderModel->where($condition)->page($_G['page'], $pagesize)->order('order_id DESC')->select();
        $pages = $this->pagination($_G['page'], $pagecount, $totalnum, "q=$q", 1);

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
                $itemlist = (new OrderItemModel())->where(array('order_id'=>array('IN', $order_ids)))->select();
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
        $orderModel = new OrderModel();
        $order = $orderModel->where(array('order_id'=>$order_id, 'buyer_uid'=>$this->uid))->getOne();
        if ($order) {
            $orderModel->where(array('order_id'=>$order_id, 'buyer_uid'=>$this->uid))->data(array('is_deleted'=>1))->save();
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
        $orderModel = new OrderModel();
        $order = $orderModel->where(array('order_id'=>$order_id, 'buyer_uid'=>$this->uid))->getOne();
        if (!$order) {
            $this->showError('order_not_exists');
        }
        $trade_status = order_get_trade_status($order);
        $trade_status_tips = $_lang['order_trade_status'][$trade_status];
        if ($trade_status == 3) $shipping = (new OrderShippingModel())->where(array('order_id'=>$order_id))->getOne();
        $itemlist = (new OrderItemModel())->where(array('order_id'=>$order_id))->select();

        $_G['title'] = '订单详情';
        include template('order_detail');
    }

    /**
     * 确认收货
     */

    public function confirm(){
        $this->receipt();
    }

    /**
     * 确认收货
     */
    public function receipt(){
        $order_id = intval($_GET['order_id']);
        $password = trim($_GET['password']);
        $orderModel = new OrderModel();
        $order = $orderModel->where(array('order_id'=>$order_id, 'buyer_uid'=>$this->uid))->getOne();
        if ($order) {
            //验证密码
            $member = (new MemberModel())->where(array('uid'=>$this->uid))->field('password')->getOne();
            if ($member['password'] !== getPassword($password)){
                $this->showAjaxError('FAIL', 'password_incorrect');
            }
            //验证订单状态
            if (order_get_trade_status($order) == 3){
                //更新订单状态
                $orderModel->where(array('order_id'=>$order_id))->data(array('order_status'=>1, 'deal_time'=>time()))->save();
                //打款给卖家
                if ($order['pay_type'] == 1){
                    (new WalletModel())->increase($order['seller_uid'], $order['total_fee']);
                }
            }
            $this->showAjaxReturn();
        }else {
            $this->showAjaxError('FAIL', 'order_not_exists');
        }
    }

    /**
     *
     */
    public function frame_close(){
        global $_G,$_lang;

        $order_id = intval($_GET['order_id']);
        $orderModel = new OrderModel();
        $order = $orderModel->where(array('buyer_uid'=>$this->uid, 'order_id'=>$order_id))->getOne();
        if ($this->checkFormSubmit()){
            if ($order['pay_type'] == 1){
                if (order_get_trade_status($order) != 1){
                    $this->showAjaxError(1, 'order_can_not_close');
                }
            }else {
                if ($order['shipping_status']){
                    $this->showAjaxError(1, 'order_can_not_close');
                }
            }
            $close_reason = $_GET['otherReason'] ? htmlspecialchars($_GET['otherReason']) : htmlspecialchars($_GET['closeReason']);
            $orderModel->where(array('buyer_uid'=>$this->uid, 'order_id'=>$order_id))->data(array('is_closed'=>1))->save();
            (new OrderClosedModel())->data(array(
                'uid'=>$this->uid,
                'order_id'=>$order_id,
                'close_reason'=>$close_reason,
                'close_time'=>time()
            ))->add();
            $this->showAjaxReturn();
        }else {

            include template('frame_close_order');
        }
    }
}