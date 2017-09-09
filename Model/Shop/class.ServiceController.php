<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/7
 * Time: 下午1:24
 */

namespace Model\Shop;


class ServiceController extends BaseController
{
    /**
     * 更新访问记录
     */
    public function update_visit(){
        $shop_id = intval($_GET['shop_id']);
        if ($shop_id) {
            shop_update_data(array('shop_id'=>$shop_id), '`view_num`=`view_num`+1');
            $res = shop_update_record(array('shop_id'=>$shop_id, 'datestamp'=>date('Ymd')), "`visit_num`=`visit_num`+1");
            if (!$res) {
                shop_add_record(array(
                    'shop_id'=>$shop_id,
                    'datestamp'=>date('Ymd'),
                    'visit_num'=>1
                ));
            }
        }
        $this->showAjaxReturn();
    }
}