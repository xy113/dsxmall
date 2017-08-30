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
        $fields = 'id, goods_name, goods_thumb, goods_price, market_price, sold';
        $itemlist = goods_get_item_list(array('on_sale'=>1), 20, $offset, 'id DESC', $fields);
        $datalist = array();
        foreach ($itemlist as $item){
            $item['goods_thumb_url'] = image($item['goods_thumb']);
            $item['goods_price'] = formatAmount($item['goods_price']);
            $datalist[] = $item;
        }
        $this->showAjaxReturn($datalist);
    }
}