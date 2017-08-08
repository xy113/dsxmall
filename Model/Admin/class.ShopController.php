<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/3
 * Time: 下午4:17
 */
namespace Model\Admin;
class ShopController extends BaseController{
    function __construct()
    {
        parent::__construct();
        $_GET['menu'] = 'shop';
    }

    public function index(){

    }

    /**
     * 店铺列表
     */
    public function itemlist(){
        global $_G,$_lang;

        if ($this->checkFormSubmit()){
            $ids = $_GET['ids'];
            if ($ids && is_array($ids)) {
                if ($_GET['option'] == 'delete'){
                    foreach ($ids as $shop_id) {
                        $this->delShop($shop_id);
                    }
                    $this->showSuccess('delete_succeed');
                }

                if ($_GET['option'] == 'open'){
                    $ids = implodeids($ids);
                    shop_update_data(array('shop_id'=>array('IN', $ids)), array('shop_status'=>'OPEN'));
                    $this->showSuccess('update_succeed');
                }

                if ($_GET['option'] == 'close'){
                    $ids = implodeids($ids);
                    shop_update_data(array('shop_id'=>array('IN', $ids)), array('shop_status'=>'CLOSE'));
                    $this->showSuccess('update_succeed');
                }

            }else {
                $this->showError('no_select');
            }
        }else {
            $pagesize = 20;
            $condition = array();
            $q = $_GET['q'] ? htmlspecialchars($_GET['q']) : '';
            if ($q) $condition['shop_name'] = array('LIKE', $q);

            $totalnum = shop_get_count($condition);
            $pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
            $_G['page'] = min(array($_G['page'], $pagecount));
            $start_limit = ($_G['page'] - 1) * $pagesize;
            $itemlist = shop_get_list($condition, $pagesize, $start_limit, 'shop_id DESC');
            $pages = $this->showPages($_G['page'], $pagecount, $totalnum, "q=$q", true);

            $_G['title'] = $_lang['shop_manage'];
            include template('shop_list');
        }
    }

    /**
     * 删除店铺信息
     * @param $shop_id
     */
    private function delShop($shop_id){
        shop_delete_data(array('shop_id'=>$shop_id));
        shop_delete_info(array('shop_id'=>$shop_id));
    }
}