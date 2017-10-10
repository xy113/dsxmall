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
use Data\Item\ItemModel;
use Data\Shop\ShopAuthModel;
use Data\Shop\ShopDescModel;
use Data\Shop\ShopModel;
use Data\Shop\ShopRecordModel;

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

        $model = new ShopModel();
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
                    foreach ($shops as $shop_id) {
                        $model->where(array('shop_id'=>$shop_id))->data(array('closed'=>0))->save();
                    }
                    $this->showAjaxReturn();
                }

                if ($_GET['eventType'] == 'close'){
                    foreach ($shops as $shop_id) {
                        $model->where(array('shop_id'=>$shop_id))->data(array('closed'=>0))->save();
                        (new ItemModel())->where(array('shop_id'=>$shop_id))->data(array('on_sale'=>0))->save();
                    }
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

            $pagesize  = 20;
            $totalnum  = $model->where($condition)->count();
            $pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
            $_G['page'] = min(array($_G['page'], $pagecount));
            $shoplist   = $model->where($condition)->page($_G['page'], $pagesize)->order('shop_id', 'DESC')->select();
            $pagination = $this->pagination($_G['page'], $pagecount, $totalnum, http_build_query($queryParams), true);
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
        $condition = array('shop_id'=>$shop_id);
        (new ShopModel())->where($condition)->delete();
        (new ShopAuthModel())->where($condition)->delete();
        (new ShopDescModel())->where($condition)->delete();
        (new ShopRecordModel())->where($condition)->delete();

        $itemModel = new ItemModel();
        foreach ($itemModel->where(array('shop_id'=>$shop_id))->field('itemid')->select() as $item){
            $itemModel->deleteAllData($item['itemid']);
        }
    }

    /**
     * 等待审核
     */
    public function pending(){
        global $_G,$_lang;

        $model = new ShopModel();
        if ($this->checkFormSubmit()){
            $shops = $_GET['shops'];
            $eventType = trim($_GET['eventType']);
            if ($shops) {
                if ($eventType === 'delete'){
                    foreach ($shops as $shop_id){
                        $this->delShop($shop_id);
                    }
                }

                if ($eventType === 'accept'){
                    foreach ($shops as $shop_id){
                        $model->where(array('shop_id'=>$shop_id))->data(array('auth_status'=>'SUCCESS', 'closed'=>0))->save();
                    }
                }

                if ($eventType === 'refuse'){
                    foreach ($shops as $shop_id){
                        $model->where(array('shop_id'=>$shop_id))->data(array('auth_status'=>'FAIL', 'closed'=>1))->save();
                    }
                }
            }
            $this->showAjaxReturn();
        }else {
            $pagesize = 20;
            $queryParams = array();
            $condition = array("(`auth_status`='PENDING' OR `auth_status`='FAIL')");
            $q = $_GET['q'] ? htmlspecialchars($_GET['q']) : '';
            if ($q) {
                $condition['shop_name'] = array('LIKE', $q);
                $queryParams['q'] = $q;
            }

            $totalnum = $model->where($condition)->count();
            $pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
            $_G['page'] = min(array($_G['page'], $pagecount));
            $shoplist   = $model->where($condition)->page($_G['page'], $pagesize)->order('shop_id', 'DESC')->select();
            $pagination = $this->pagination($_G['page'], $pagecount, $totalnum, http_build_query($queryParams), true);
            unset($condition, $queryParams);

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
        $shop = (new ShopModel())->where(array('shop_id'=>$shop_id))->getOne();
        $auth = (new ShopAuthModel())->where(array('shop_id'=>$shop_id))->getOne();

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


        $model = new ShopModel();
        if ($auth_status == 'SUCCESS') {
            $model->where(array('shop_id'=>$shop_id))->data(array('auth_status'=>'SUCCESS', 'closed'=>'0'))->save();
            (new ShopAuthModel())->where(array('shop_id'=>$shop_id))->data(array('auth_status'=>'SUCCESS', 'auth_time'=>time()))->save();
        }else {
            $model->where(array('shop_id'=>$shop_id))->data(array('auth_status'=>'FAIL', 'closed'=>'1'))->save();
            (new ShopAuthModel())->where(array('shop_id'=>$shop_id))->data(array('auth_status'=>'FAIL', 'auth_time'=>time()))->save();
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
        $shoplist = (new ShopModel())->where($condition)->order('shop_id')->select();
        foreach ($shoplist as $shop){
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