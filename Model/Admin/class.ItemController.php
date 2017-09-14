<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/2
 * Time: 下午3:00
 */
namespace Model\Admin;
class ItemController extends BaseController{
    /**
     * ItemController constructor.
     */
    function __construct()
    {
        parent::__construct();
        G('menu', 'item');
    }

    /**
     *
     */
    public function index(){
        $this->itemlist();
    }

    /**
     * 商品列表
     */
    public function itemlist(){
        global $_G,$_lang;

        if ($this->checkFormSubmit()) {
            if ($this->checkFormSubmit()) {
                $items = $_GET['items'];
                if ($items && is_array($items)) {
                    //批量删除商品
                    if ($_GET['option'] == 'delete') {
                        foreach ($items as $itemid){
                            $this->delItemData($itemid);
                        }
                        $this->showSuccess('delete_succeed');
                    }
                    //批量上架商品
                    if ($_GET['option'] == 'on_sale'){
                        $itemids = implodeids($items);
                        item_update_data(array('itemid'=>array('IN', $itemids)), array('on_sale'=>1));
                        $this->showSuccess('update_succeed');
                    }

                    //批量下架商品
                    if ($_GET['option'] == 'off_sale'){
                        $itemids = implodeids($items);
                        item_update_data(array('itemid'=>array('IN', $itemids)), array('on_sale'=>0));
                        $this->showSuccess('update_succeed');
                    }

                }else {
                    $this->showError('no_select');
                }
            }else {
                $this->showError('undefined_action');
            }
        }else {
            $pagesize = 10;
            $condition = array();
            $q = $_GET['q'] ? htmlspecialchars($_GET['q']) : '';
            if ($q) $condition['title'] = array('LIKE', $q);

            $totalnum = item_get_count($condition);
            $pagecount  = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
            $_G['page'] = min(array($_G['page'], $pagecount));
            $itemlist   = item_get_list($condition, $pagesize, ($_G['page'] - 1) * $pagesize);
            $pages = $this->showPages($_G['page'], $pagecount, $totalnum, "q=$q", true);

            $shop_list = array();
            if ($itemlist) {
                $datalist = $shop_ids = array();
                foreach ($itemlist as $item){
                    $datalist[$item['itemid']] = $item;
                    $shop_ids[] = $item['shop_id'];
                }
                $itemlist = $datalist;
                unset($datalist, $item);

                $shop_ids = $shop_ids ? implodeids($shop_ids) : 0;
                if ($shop_ids) {
                    $shop_list = shop_get_list(array('shop_id'=>array('IN', $shop_ids)), 0, 0, null, 'shop_id,shop_name');
                    $datalist = array();
                    foreach ($shop_list as $shop){
                        $datalist[$shop['shop_id']] = $shop;
                    }
                    $shop_list = $datalist;
                }
                unset($datalist, $shop);
            }

            $_G['title'] = $_lang['item_manage'];
            include template('item_list');
        }
    }

    /**
     * 删除所有商品数据
     * @param $itemid
     */
    private function delItemData($itemid){
        item_delete_data(array('itemid'=>$itemid));
        item_delete_desc(array('itemid'=>$itemid));
        item_delete_image(array('itemid'=>$itemid));
    }
}