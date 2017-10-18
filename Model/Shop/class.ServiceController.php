<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/7
 * Time: 下午1:24
 */

namespace Model\Shop;


use Data\Shop\ShopModel;
use Data\Shop\ShopRecordModel;

class ServiceController extends BaseController
{
    /**
     * 更新访问记录
     */
    public function update_visit(){
        $shop_id = intval($_GET['shop_id']);
        $shopModel = new ShopModel();
        if ($shop_id) {
            $shopModel->where(array('shop_id'=>$shop_id))->data('`view_num`=`view_num`+1')->save();
            $recordModel = new ShopRecordModel();
            $res = $recordModel->where(array('shop_id'=>$shop_id, 'datestamp'=>date('Ymd')))->data("`visit_num`=`visit_num`+1")->save();
            if (!$res) {
                $recordModel->data(array(
                    'shop_id'=>$shop_id,
                    'datestamp'=>date('Ymd'),
                    'visit_num'=>1
                ))->add();
            }
        }
        $this->showAjaxReturn();
    }
}