<?php
namespace Model\App;
class IndexController extends BaseController{
    /**
     * APP首页
     */
    public function index(){
		global $_G,$_lang;


		include template('index');
	}

    /**
     * 获取商品数据
     */
    public function batchget(){
        $offset = (G('page') - 1) * 20;
        $fields = 'itemid, title, thumb, price, market_price, sold';
        $itemlist = item_get_list(array('on_sale'=>1, 'catid<>74'), 20, $offset, 'itemid DESC', $fields);
        $datalist = array();
        foreach ($itemlist as $item){
            $item['thumb'] = image($item['thumb']);
            $item['price'] = formatAmount($item['price']);
            $datalist[] = $item;
        }
        $this->showAjaxReturn($datalist);
    }
}