<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/3
 * Time: 下午4:17
 */
namespace Model\Admin;
use Core\Download;
use Core\ExcelXML;

class ShopController extends BaseController{
    /**
     *
     */
    public function index(){
        $this->itemlist();
    }

    /**
     * 店铺列表
     */
    public function itemlist(){
        global $_G,$_lang;

        if ($this->checkFormSubmit()){
            $shops = $_GET['shops'];
            if ($shops && is_array($shops)) {
                if ($_GET['eventType'] == 'delete'){
                    foreach ($shops as $shop_id) {
                        $this->delShop($shop_id);
                    }
                    //$this->showSuccess('delete_succeed');
                    $this->showAjaxReturn();
                }

                if ($_GET['eventType'] == 'open'){
                    shop_update_data(array('shop_id'=>array('IN', implodeids($shops))), array('closed'=>'0'));
                    //$this->showSuccess('update_succeed');
                    $this->showAjaxReturn();
                }

                if ($_GET['eventType'] == 'close'){
                    shop_update_data(array('shop_id'=>array('IN', implodeids($shops))), array('closed'=>'1'));
                    item_update_data(array('shop_id'=>array('IN', implodeids($shops))), array('on_sale'=>'0'));
                    //$this->showSuccess('update_succeed');
                    $this->showAjaxReturn();
                }

            }else {
                //$this->showError('no_select');
                $this->showAjaxError(1, 'no_select');
            }
        }else {
            $queryParams = array();
            $condition = array('auth_status'=>'SUCCESS');
            $tab = $_GET['tab'] ? htmlspecialchars($_GET['tab']) : 'all';
            $queryParams['tab'] = $tab;
            if ($tab == 'open'){
                $condition['closed'] = '0';
            }

            if ($tab == 'closed'){
                $condition['closed'] = '1';
            }

            $shop_name = htmlspecialchars($_GET['shop_name']);
            if ($shop_name) {
                $condition['shop_name'] = array('LIKE', $shop_name);
                $queryParams['shop_name'] = $shop_name;
            }

            $username = htmlspecialchars($_GET['username']);
            if ($username) {
                $condition['username'] = $username;
                $queryParams['username'] = $username;
            }

            $phone = htmlspecialchars($_GET['phone']);
            if ($phone) {
                $condition['phone'] = $phone;
                $queryParams['phone'] = $phone;
            }

            $shop_status = strtoupper(htmlspecialchars($_GET['shop_status']));
            if ($shop_status == 'OPEN'){
                $condition['closed'] = '0';
                $queryParams['shop_status'] = 'OPEN';
            }
            if ($shop_status == 'CLOSE'){
                $condition['closed'] = '1';
                $queryParams['shop_status'] = 'CLOSE';
            }

            $time_begin = htmlspecialchars($_GET['time_begin']);
            $time_end = htmlspecialchars($_GET['time_end']);
            if ($time_begin && !$time_end){
                $condition['create_time'] = array('>', strtotime($time_begin));
                $queryParams['time_begin'] = $time_begin;
            }elseif ($time_begin && $time_end){
                $condition[] = "`create_time`>".strtotime($time_begin)." AND `create_time`<".strtotime($time_end);
                $queryParams['time_begin'] = $time_begin;
                $queryParams['time_end'] = $time_end;
            }

            $pagesize = 20;
            $totalnum = shop_get_count($condition);
            $pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
            $_G['page'] = min(array($_G['page'], $pagecount));
            $start_limit = ($_G['page'] - 1) * $pagesize;
            $itemlist = shop_get_list($condition, $pagesize, $start_limit, 'shop_id DESC');
            $pages = $this->showPages($_G['page'], $pagecount, $totalnum, http_build_query($queryParams), true);
            unset($condition, $queryParams);

            $_G['title'] = $_lang['shop_manage'];
            include template('shop/shop_list');
        }
    }

    /**
     * 删除店铺信息
     * @param $shop_id
     */
    private function delShop($shop_id){
        shop_delete_data(array('shop_id'=>$shop_id));
        shop_delete_auth(array('shop_id'=>$shop_id));
        $itemlist = item_get_list(array('shop_id'=>$shop_id), 0, 0, null, 'itemid');
        foreach ($itemlist as $item){
            item_delete_data(array('itemid'=>$item['itemid']));
            item_delete_desc(array('itemid'=>$item['itemid']));
            item_delete_image(array('itemid'=>$item['itemid']));
            item_detete_recommend(array('itemid'=>$item['itemid']));
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
                                'closed'=>'0'
                            ));
                        shop_update_auth(array('shop_id'=>$shop_id), array('auth_status'=>'SUCCESS', 'auth_time'=>time()));
                    }
                    $this->showSuccess('update_succeed');
                }

                if ($_GET['option'] == 'auth_fail'){
                    foreach ($ids as $shop_id){
                        $shop = shop_get_data(array('shop_id'=>$shop_id));
                        shop_update_data(array('shop_id'=>$shop_id),
                            array(
                                'auth_status'=>'FAIL',
                                'closed'=>'1'
                            ));
                        shop_update_auth(array('shop_id'=>$shop_id), array('auth_status'=>'FAIL', 'auth_time'=>time()));
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
            include template('shop/shop_pending');
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
        $auth = shop_get_auth(array('shop_id'=>$shop_id));

        $_G['title'] = $shop['shop_name'];
        include template('shop/shop_detail');
    }

    /**
     * 认证店铺
     */
    public function auth(){
        $shop_id = intval($_GET['shop_id']);
        $auth_status = strtoupper($_GET['auth_status']);
        $message = htmlspecialchars($_GET['message']);

        $shop = shop_get_data(array('shop_id'=>$shop_id));
        if ($auth_status == 'SUCCESS') {
            shop_update_data(array('shop_id'=>$shop_id),
                array(
                    'auth_status'=>'SUCCESS',
                    'closed'=>'0'
                ));
            shop_update_auth(array('shop_id'=>$shop['shop_id']), array('auth_status'=>'SUCCESS', 'auth_time'=>time()));
        }else {
            shop_update_data(array('shop_id'=>$shop_id),
                array(
                    'auth_status'=>'FAIL',
                    'closed'=>'1'
                ));
            shop_update_auth(array('shop_id'=>$shop['shop_id']), array('auth_status'=>'FAIL', 'auth_time'=>time()));
        }
        $this->showSuccess('shop_auth_success');
    }

    /**
     * 下载店铺数据
     */
    public function download(){
        $excelfile = CACHE_PATH.'shoplist.xls';
        $excel = new ExcelXML();
        file_put_contents($excelfile, $excel->getHeader());
        file_put_contents($excelfile, $excel->getRow(array(
            '店铺名称','卖家账号','联系电话','所在地','营业状态','开店日期'
        )), FILE_APPEND);

        $condition = array();
        $shop_name = htmlspecialchars($_GET['shop_name']);
        if ($shop_name) {
            $condition['shop_name'] = array('LIKE', $shop_name);
        }

        $username = htmlspecialchars($_GET['username']);
        if ($username) {
            $condition['username'] = $username;
        }

        $phone = htmlspecialchars($_GET['phone']);
        if ($phone) {
            $condition['phone'] = $phone;
        }

        $shop_status = strtoupper(htmlspecialchars($_GET['shop_status']));
        if ($shop_status == 'OPEN'){
            $condition['shop_status'] = 'OPEN';
        }
        if ($shop_status == 'CLOSE'){
            $condition['shop_status'] = 'CLOSE';
        }

        $time_begin = htmlspecialchars($_GET['time_begin']);
        $time_end = htmlspecialchars($_GET['time_end']);
        if ($time_begin && !$time_end){
            $condition['create_time'] = array('>', strtotime($time_begin));
        }elseif ($time_begin && $time_end){
            $condition[] = "`create_time`>".strtotime($time_begin)." AND `create_time`<".strtotime($time_end);
        }

        global $_lang;
        $rows = '';
        $shop_list = shop_get_list($condition, 0, 0);
        foreach ($shop_list as $shop){
            $rows.= $excel->getRow(array(
                $shop['shop_name'], $shop['username'],$shop['phone'],
                $shop['province'].' '.$shop['city'].' '.$shop['county'],
                $_lang['shop_status'][$shop['closed']], date('Y-m-d', $shop['create_time'])
            ));
        }
        file_put_contents($excelfile, $rows, FILE_APPEND);
        file_put_contents($excelfile, $excel->getFooter(), FILE_APPEND);
        $this->showAjaxReturn();
    }

    /**
     * 下载文件
     */
    public function get_excel(){
        $excelfile = CACHE_PATH.'shoplist.xls';
        Download::downExcel($excelfile, null, true);
    }

    /**
     * 关闭店铺
     */
    public function close(){
        global $_G,$_lang;

        if ($this->checkFormSubmit()){
            $shops = $_GET['shops'];
            $closeReason = htmlspecialchars($_GET['closeReason']);
            $template_id = intval($_GET['template_id']);
            foreach (explode(',', $shops) as $shop_id){
                $shop = shop_get_data(array('shop_id'=>$shop_id, 'closed'=>0));
                if ($shop) {

                }
            }
            $this->showAjaxReturn();
        }else {
            $notice_template_list = notice_get_template_list(array('template_type'=>'shop'));
            include template('shop/shop_close');
        }
    }
}