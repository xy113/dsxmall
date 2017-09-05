<?php
namespace Model\Admin;
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
			
		}else {
			$condition = array();
			$q = htmlspecialchars($_GET['q']);
			if ($q) $condition['order_no'] = $q;
			
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
			
				$uids = $uids ? implodeids($uids) : 0;
				$userlist = member_get_list(array('uid'=>array('IN', $uids)), $pagesize * 2);
				unset($datalist, $uids, $order);

				$order_ids = $order_ids ? implodeids($order_ids) : 0;
				if ($order_ids) {
                    $itemlist = M('order_item')->where(array('order_id'=>array('IN', $order_ids)))->group('order_id')->select();
                    if ($itemlist) {
                        foreach ($itemlist as $item){
                            $order_list[$item['order_id']]['itemid'] = $item['itemid'];
                            $order_list[$item['order_id']]['name'] = $item['name'];
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