<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/29
 * Time: 下午5:04
 */

namespace Model\Api;


class DistrictController extends BaseController
{
    function __construct()
    {
        $this->verifyToken = false;
        parent::__construct();
    }

    /**
     * 批量获取区域列表
     */
    public function batchget(){
        $fid = intval($_GET['fid']);
        $itemlist = district_get_list(array('fid'=>$fid), 0, 0, null, 'id, fid, name');
        $this->showAjaxReturn($itemlist);
    }
}