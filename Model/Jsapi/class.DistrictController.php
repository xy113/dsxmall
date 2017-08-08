<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/1
 * Time: 下午4:53
 */
namespace Model\Jsapi;
class DistrictController extends BaseController{


    /**
     *
     */
    public function get_district(){
        $id = intval($_GET['id']);
        $this->showAjaxReturn(district_get_data(array('id'=>$id)));
    }

    /**
     * 批量获取区位信息
     */
    public function batchget_district(){
        $fid = intval($_GET['fid']);
        $itemlist = district_get_list(array('fid'=>$fid), 0, 0, null, 'id,fid,name');
        $this->showAjaxReturn($itemlist);
    }
}