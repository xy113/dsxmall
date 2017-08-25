<?php
namespace Model\Admin;
class OrderController extends BaseController{
    function __construct()
    {
        parent::__construct();
        $_GET['menu'] = 'order';
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
			$keyword = htmlspecialchars($_GET['keyword']);
			if ($keyword) $condition['order_name'] = array('LIKE', $keyword);
			
			$pagesize = 20;
			$totalnum = order_get_item_count($condition);
			$pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
			$itemlist  = order_get_item_list($condition, $pagesize, ($_G['page'] - 1)*$pagesize, 'order_id DESC');
			$pages = $this->showPages($_G['page'], $pagecount, $totalnum, "keyword=$keyword", 1);
			
			if ($itemlist) {
				$uids = $order_ids = $datalist = array();
				foreach ($itemlist as $item){
					$datalist[$item['order_id']] = $item;
					$order_ids[] = $item['order_id'];
					array_push($uids, $item['uid'], $item['seller_uid']);
				}
				$itemlist = $datalist;
			
				$uids = $uids ? implodeids($uids) : 0;
				$userlist = member_get_list(array('uid'=>array('IN', $uids)), $pagesize * 2);
				unset($datalist, $uids, $item);

				$order_ids = $order_ids ? implodeids($order_ids) : 0;
				if ($order_ids) {
                    $goods_list = M('order_goods')->where(array('order_id'=>array('IN', $order_ids)))->group('order_id')->select();
                    if ($goods_list) {
                        foreach ($goods_list as $goods){
                            $itemlist[$goods['order_id']]['goods_id'] = $goods['goods_id'];
                            $itemlist[$goods['order_id']]['goods_name'] = $goods['goods_name'];
                            $itemlist[$goods['order_id']]['goods_thumb'] = $goods['goods_thumb'];
                        }
                    }
                    unset($order_ids, $goods_list, $goods);
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
        $order = order_get_item(array('order_id'=>$order_id));
        $itemlist = order_get_goods_list(array('order_id'=>$order_id));

        if ($order['shipping_status']){
            $shipping = order_get_shipping(array('order_id'=>$order_id));
        }else {
            $express_list = M('express')->order('id', 'ASC')->select();
        }

        $_G['title'] = '订单详情';
        include template('order_detail');
    }
}