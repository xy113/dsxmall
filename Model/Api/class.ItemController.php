<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/28
 * Time: 上午11:26
 */

namespace Model\Api;


use Data\Item\ItemCatlogModel;
use Data\Item\ItemDescModel;
use Data\Item\ItemModel;
use Data\Item\Object\ItemDescObject;
use Data\Item\Object\ItemObject;
use Data\Shop\ShopModel;

class ItemController extends BaseController
{
    /**
     * 获取商品资料
     */
    public function get(){
        $model = new ItemModel();
        $itemid = intval($_GET['itemid']);
        if (!$itemid) $itemid = intval($_GET['id']);
        $item = $model->where(array('itemid'=>$itemid, 'on_sale'=>1))->getOne();
        if ($item) {
            $item['thumb'] = image($item['thumb']);
            $item['image'] = image($item['image']);

            $shop = (new ShopModel())->where(array('shop_id'=>$item['shop_id']))->getOne();
            if ($shop) {
                $item['shop_name'] = $shop['shop_name'];
                $item['shop_logo'] = image($shop['shop_logo']);
                $item['province'] = $shop['province'];
                $item['city'] = $shop['city'];
                $item['county'] = $shop['county'];
            }else {
                $item['shop_name'] = '';
                $item['shop_logo'] = image($shop['shop_logo']);
                $item['province'] = '贵州省';
                $item['city'] = '六盘水市';
                $item['county'] = '水城县';
            }
            $this->showAjaxReturn($item);
        }else {
            $this->showAjaxReturn(array());
        }
    }

    /**
     * 批量获取商品信息
     */
    public function batchget(){
        //查询关键字
        $q = htmlspecialchars($_GET['q']);
        //分类ID
        $catid = intval($_GET['catid']);
        //获取数目
        $count = $_GET['count'] ? intval($_GET['count']) : 20;
        //偏移量
        $offset = $_GET['offset'] ? intval($_GET['offset']) : 0;

        $condition = array();
        if ($catid) {
            $childids = ItemCatlogModel::getInstance()->getAllChildIds($catid);
            $condition['catid'] = array('IN', implodeids($childids));
        }

        if ($q) {
            $condition[] = "(`title` LIKE '%$q%' OR `subtitle` LIKE '%$q%')";
        }

        $itemlist = ItemModel::getInstance()->where($condition)->limit($offset, $count)->order('sold', 'DESC')->select();
        $datalist = array();
        foreach ($itemlist as $item){
            $item['thumb'] = image($item['thumb']);
            $item['image'] = image($item['image']);
            $datalist[] = $item;
        }
        $this->showAjaxReturn($datalist);
    }

    /**
     * 删除宝贝
     */
    public function delete(){
        $itemid = intval($_GET['itemid']);
        if (ItemModel::getInstance()->where(array('itemid'=>$itemid, 'uid'=>$this->uid))->count()){
            ItemModel::getInstance()->deleteAllData($itemid);
            $this->showAjaxReturn();
        }else {
            $this->showAjaxError(1, 'no item data');
        }
    }

    /**
     * 更新商品信息
     */
    public function update(){
        $itemid = intval($_GET['itemid']);
        $item = $_GET['item'];
        $content = $_GET['content'];

        if ($itemid) {
            if ($item) {
                $itemObj = new ItemObject($item);
                ItemModel::getInstance()->where(array('uid'=>$this->uid, 'itemid'=>$itemid))
                    ->data($itemObj->getBizContent())->save();
            }

            if ($content) {
                $descObj = new ItemDescObject();
                $descObj->setContent($content)->setUpdateTime(time());
                ItemDescModel::getInstance()->where(array('uid'=>$this->uid, 'itemid'=>$itemid))->data($descObj)->save();
            }
        }
        $this->showAjaxReturn();
    }

    /**
     * 添加宝贝
     */
    public function add(){
        $item = $_GET['item'];
        $content = $_GET['content'];

        if ($item && $content) {
            $itemObj = new ItemObject($item);
            try {
                $itemObj->setUid($this->uid);
                $itemid = ItemModel::getInstance()->addObject($item);

                $descObj = new ItemDescObject();
                $descObj->setUid($this->uid)->setItemid($itemid);
                $descObj->setContent($content)->setUpdateTime(time());
                ItemDescModel::getInstance()->data($descObj->getBizContent())->add();
                $this->showAjaxReturn(array('itemid'=>$itemid));
            }catch (\Exception $e){
                $this->showAjaxError(1, $e->getMessage());
            }
        }else {
            $this->showAjaxReturn('invalid_parameter');
        }
    }
}