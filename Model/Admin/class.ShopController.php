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
        G('menu', 'shop');
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
            $condition = array('auth_status'=>'SUCCESS');
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
        $itemlist = item_get_list(array('shop_id'=>$shop_id), 0);
        foreach ($itemlist as $item){
            item_delete_data(array('id'=>$item['id']));
            item_delete_desc(array('itemid'=>$item['id']));
            item_delete_image(array('itemid'=>$item['id']));
        }
    }

    /**
     * 等待审核
     */
    public function pending(){
        global $_G,$_lang;

        if ($this->checkFormSubmit()){
            $ids = $_GET['ids'];
            if ($ids && is_array($ids)){
                if ($_GET['option'] == 'delete'){
                    foreach ($ids as $shop_id){
                        $this->delShop(intval($shop_id));
                    }
                    $this->showSuccess('delete_succeed');
                }

                if ($_GET['option'] == 'auth_success'){
                    foreach ($ids as $shop_id){
                        $shop = shop_get_data(array('shop_id'=>$shop_id));
                        shop_update_data(array('shop_id'=>$shop_id),
                            array(
                                'auth_status'=>'SUCCESS',
                                'shop_status'=>'OPEN'
                            ));
                        shop_update_owner(array('owner_uid'=>$shop['owner_uid']), array('auth_status'=>'SUCCESS', 'auth_time'=>time()));
                    }
                    $this->showSuccess('update_succeed');
                }

                if ($_GET['option'] == 'auth_fail'){
                    foreach ($ids as $shop_id){
                        $shop = shop_get_data(array('shop_id'=>$shop_id));
                        shop_update_data(array('shop_id'=>$shop_id),
                            array(
                                'auth_status'=>'FAIL',
                                'shop_status'=>'CLOSE'
                            ));
                        shop_update_owner(array('owner_uid'=>$shop['owner_uid']), array('auth_status'=>'FAIL', 'auth_time'=>time()));
                    }
                    $this->showSuccess('update_succeed');
                }
            }else {
                $this->showError('no_select');
            }
        }else {
            $pagesize = 20;
            $condition = array("(`auth_status`='PENDING' OR `auth_status`='FAIL')");
            $q = $_GET['q'] ? htmlspecialchars($_GET['q']) : '';
            if ($q) $condition['shop_name'] = array('LIKE', $q);

            $totalnum = shop_get_count($condition);
            $pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
            $_G['page'] = min(array($_G['page'], $pagecount));
            $start_limit = ($_G['page'] - 1) * $pagesize;
            $itemlist = shop_get_list($condition, $pagesize, $start_limit, 'shop_id DESC');
            $pages = $this->showPages($_G['page'], $pagecount, $totalnum, "q=$q", true);

            $_G['title'] = $_lang['shop_manage'];
            include template('shop_pending');
        }
    }

    /**
     * 店铺详情
     */
    public function detail(){
        global $_G,$_lang;
        G('menu', 'shop_pending');

        $shop_id = intval($_GET['shop_id']);
        $shop = shop_get_data(array('shop_id'=>$shop_id));
        $owner = shop_get_owner(array('owner_uid'=>$shop['owner_uid']));
        $shop_info = shop_get_info(array('shop_id'=>$shop_id));

        $_G['title'] = $shop['shop_name'];
        include template('shop_detail');
    }

    public function auth(){
        $shop_id = intval($_GET['shop_id']);
        $auth_status = strtoupper($_GET['auth_status']);
        $message = htmlspecialchars($_GET['message']);

        $shop = shop_get_data(array('shop_id'=>$shop_id));
        if ($auth_status == 'SUCCESS') {
            shop_update_data(array('shop_id'=>$shop_id),
                array(
                    'auth_status'=>'SUCCESS',
                    'shop_status'=>'OPEN'
                ));
            shop_update_owner(array('owner_uid'=>$shop['owner_uid']), array('auth_status'=>'SUCCESS', 'auth_time'=>time()));
        }else {
            shop_update_data(array('shop_id'=>$shop_id),
                array(
                    'auth_status'=>'FAIL',
                    'shop_status'=>'CLOSE'
                ));
            shop_update_owner(array('owner_uid'=>$shop['owner_uid']), array('auth_status'=>'FAIL', 'auth_time'=>time()));
        }
        $this->showSuccess('shop_auth_success');
    }
}