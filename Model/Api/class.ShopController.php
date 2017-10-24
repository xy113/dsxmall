<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/20
 * Time: 下午3:46
 */

namespace Model\Api;


use Data\Shop\ShopDescModel;
use Data\Shop\ShopModel;

class ShopController extends BaseController
{
    public function index(){

    }

    /**
     * 获取商铺信息
     */
    public function get(){
        $shop_id = intval($_GET['shop_id']);
        $shop = ShopModel::getInstance()->where(array('shop_id'=>$shop_id))->getOne();
        $this->showAjaxReturn($shop);
    }

    /**
     * 批量获取店铺信息
     */
    public function batchget(){
        //查询关键字
        $q = htmlspecialchars($_GET['q']);
        //获取数目
        $count = $_GET['count'] ? intval($_GET['count']) : 20;
        //偏移量
        $offset = $_GET['offset'] ? intval($_GET['offset']) : 0;

        $condition = array();
        if ($q) $condition['shop_name'] = array('LIKE', $q);
        $shopList = ShopModel::getInstance()->where($condition)->order('total_sold', 'DESC')->limit($offset, $count)->select();

        $datalist = array();
        foreach ($shopList as $shop){
            $shop['shop_logo'] = image($shop['shop_logo']);
            $shop['shop_image'] = image($shop['shop_image']);
            $datalist[] = $shop;
        }
        $this->showAjaxReturn($datalist);
    }

    /**
     * 获取商铺简介
     */
    public function get_desc(){
        $shop_id = intval($_GET['shop_id']);
        $desc = ShopDescModel::getInstance()->where(array('shop_id'=>$shop_id))->getOne();
        $this->showAjaxReturn($desc);
    }
}