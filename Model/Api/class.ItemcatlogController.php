<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/20
 * Time: 下午3:56
 */

namespace Model\Api;


use Data\Item\ItemCatlogModel;

class ItemcatlogController extends BaseController
{
    public function index(){

    }

    /**
     * 获取分类信息
     */
    public function get(){
        $catid = intval($_GET['catid']);
        $catlog = ItemCatlogModel::getInstance()->where(array('catid'=>$catid))->getOne();
        if ($catlog) {
            $catlog['icon'] = image($catlog['icon']);
            $this->showAjaxReturn($catlog);
        }else {
            $this->showAjaxError(1, 'no data');
        }
    }

    /**
     * 批量获取分类信息
     */
    public function batchget(){
        $this->showAjaxReturn($this->getTree());
    }

    /**
     * @param int $fid
     * @return array
     */
    private function getTree($fid=0){
        static $catlogList;

        $catlogs=array();
        if (!$catlogList) {
            $catlogList = ItemCatlogModel::getInstance()->getCache();
        }

        foreach ($catlogList as $catlog) {
            if ($catlog['fid'] == $fid) {
                $data = array();
                $data['catid'] = $catlog['catid'];
                $data['fid']   = $catlog['fid'];
                $data['name']  = $catlog['name'];
                $data['icon']  = image($catlog['icon']);
                $data['childs'] = $this->getTree($catlog['catid']);
                $catlogs[] = $data;
            }
        }
        return $catlogs;
    }
}