<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/2
 * Time: 下午3:00
 */
namespace Model\Admin;
class GoodsController extends BaseController{
    function __construct()
    {
        parent::__construct();
        $_GET['menu'] = 'goodsitem';

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
                $ids = $_GET['ids'];
                if ($ids && is_array($ids)) {
                    //批量删除商品
                    if ($_GET['option'] == 'delete') {
                        foreach ($ids as $goods_id){
                            $this->delGoodsData($goods_id);
                        }
                        $this->showSuccess('delete_succeed');
                    }
                    //批量上架商品
                    if ($_GET['option'] == 'on_sale'){
                        $ids = implodeids($ids);
                        goods_update_item(array('id'=>array('IN', $ids)), array('on_sale'=>1));
                        $this->showSuccess('update_succeed');
                    }

                    //批量下架商品
                    if ($_GET['option'] == 'off_sale'){
                        $ids = implodeids($ids);
                        goods_update_item(array('id'=>array('IN', $ids)), array('on_sale'=>0));
                        $this->showSuccess('update_succeed');
                    }

                }else {
                    $this->showAjaxError('no_select');
                }
            }else {
                $this->showError('undefined_action');
            }
        }else {
            $pagesize = 10;
            $condition = array();
            $q = $_GET['q'] ? htmlspecialchars($_GET['q']) : '';
            if ($q) $condition['goods_name'] = array('LIKE', $q);

            $totalnum = goods_get_item_count($condition);
            $pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
            $_G['page'] = min(array($_G['page'], $pagecount));
            $start_limit = ($_G['page'] - 1) * $pagesize;
            $goods_list = goods_get_item_list($condition, $pagesize, $start_limit);
            $pages = $this->showPages($_G['page'], $pagecount, $totalnum, "q=$q", true);

            $_G['title'] = $_lang['goods_manage'];
            include template('goods_list');
        }
    }

    /**
     * 删除所有商品数据
     * @param $goods_id
     */
    private function delGoodsData($goods_id){
        goods_delete_item(array('id'=>$goods_id));
        goods_delete_desc(array('goods_id'=>$goods_id));
        goods_delete_image(array('goods_id'=>$goods_id));
    }
}