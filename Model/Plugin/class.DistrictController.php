<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/14
 * Time: 上午9:48
 */

namespace Model\Plugin;


use Data\Common\DistrictModel;

class DistrictController extends BaseController
{
    /**
     *
     */
    public function get(){
        $id = intval($_GET['id']);
        $model = new DistrictModel();
        $this->showAjaxReturn($model->where(array('id'=>$id))->getOne());
    }
    /**
     * 批量获取区位信息
     */
    public function batchget(){
        $fid = intval($_GET['fid']);
        $model = new DistrictModel();
        $this->showAjaxReturn($model->where(array('fid'=>$fid))->field('id,fid,name')->select());
    }
}