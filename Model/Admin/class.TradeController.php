<?php
namespace Model\Admin;
class TradeController extends BaseController{
    /**
     * TradeController constructor.
     */
    function __construct()
    {
        parent::__construct();
        G('menu', 'trade');
    }

    public function index(){
		$this->itemlist();
	}

    /**
     *
     */
    public function itemlist(){
		global $_G,$_lang;
		if ($this->checkFormSubmit()){
			$trade_id = $_GET['trade_id'];
			if ($trade_id && is_array($trade_id)){
				$trade_id = implodeids($trade_id);
				switch ($_GET['option']){
					case 'delete':
						trade_delete_data(array('trade_id'=>array('IN', $trade_id)));
						$this->showSuccess('delete_succeed');
						break;
					default:;
				}
			}else {
				$this->showError('no_select');
			}
		}else {
			$condition = array();
			$q = htmlspecialchars($_GET['q']);
			if ($q) $condition[] = "`trade_no`='$q' OR (`trade_name` LIKE '%$q%')";
			
			$pagesize = 20;
			$totalnum = trade_get_count($condition);
			$pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
			$itemlist = trade_get_list($condition, $pagesize, ($_G['page']-1)*$pagesize, 'trade_id DESC');
			$pages = $this->showPages($_G['page'], $pagecount, $totalnum, "q=$q", 1);
			
			include template('trade_list');
		}
	}
}