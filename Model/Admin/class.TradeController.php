<?php
namespace Model\Admin;
use Core\Download;
use Core\ExcelXML;

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

    /**
     *
     */
    public function download(){
        $excelfile = CACHE_PATH.'trade_records.xls';
        $offset = intval(cookie('export_offset'));

        $excel = new ExcelXML();
        if ($offset == 0){
            file_put_contents($excelfile, $excel->getHeader());
            file_put_contents($excelfile, $excel->getRow(array(
                '商品名称','交易流水','收款方','付款方','付款金额','创建时间','付款方式','支付状态'
            )), FILE_APPEND);
        }

        $pagesize = 100;
        $condition = array();
        $itemlist = trade_get_list($condition, $pagesize, $offset, 'trade_id DESC');
        if ($itemlist) {
            $rows = '';
            foreach ($itemlist as $item){
                $offset++;
                $rows.= $excel->getRow(array(
                    $item['trade_name'],$item['trade_no'],$item['payee_name'],$item['payer_name'],
                    formatAmount($item['trade_fee']),date('Y-m-d H:i:s', $item['trade_time']),
                    $GLOBALS['_lang']['trade_pay_types'][$item['pay_type']],
                    ($item['trade_status'] == 'PAID' ? '已支付' : '未支付')
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
        $excelfile = CACHE_PATH.'trade_records.xls';
        Download::downExcel($excelfile, 'trade_records.xls', true);
    }
}