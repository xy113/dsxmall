<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/29
 * Time: 下午5:04
 */

namespace Model\Api;


use Data\Common\DistrictModel;

class DistrictController extends BaseController
{

    /**
     * 批量获取区域列表
     */
    public function batchget(){
        $fid = intval($_GET['fid']);
        $districtlist = (new DistrictModel())->where(array('fid'=>$fid))->field('id, fid, name')->select();
        $this->showAjaxReturn($districtlist);
    }
}