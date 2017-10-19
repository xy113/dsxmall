<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/2
 * Time: 下午12:08
 */
namespace Model\Seller;
use Data\Item\Builder\ItemContentBuilder;
use Data\Item\ItemCatlogModel;
use Data\Item\ItemDescModel;
use Data\Item\ItemImageModel;
use Data\Item\ItemModel;
use Data\Item\Object\ItemDescObject;
use Data\Item\Object\ItemObject;

class ItemController extends BaseController{
    /**
     *
     */
    public function index(){
        $this->itemlist();
    }

    /**
     * 商品列表
     */
    public function itemlist(){
        global $_G,$_lang;

        if ($this->checkFormSubmit()){
            $items = $_GET['items'];
            if ($items && is_array($items)){
                if ($_GET['eventType'] == 'delete'){
                    foreach ($items as $itemid){
                        $this->delItemData($itemid);
                    }
                    $this->showSuccess('delete_succeed');
                }

                if ($_GET['eventType'] == 'on_sale'){
                    foreach ($items as $itemid){
                        $model = new ItemModel();
                        $model->where(array('itemid'=>$itemid))->update(array('on_sale'=>1));
                    }
                    $this->showSuccess('update_succeed');
                }

                if ($_GET['eventType'] == 'off_sale'){
                    foreach ($items as $itemid){
                        $model = new ItemModel();
                        $model->where(array('itemid'=>$itemid))->update(array('on_sale'=>0));
                    }
                    $this->showSuccess('update_succeed');
                }
            }else {
                $this->showError('no_select');
            }
        }else {
            $pagesize = 10;
            $condition = array('uid'=>$this->uid);
            $type = intval($_GET['type']);

            if ($type == 2){
                $condition['on_sale'] = 0;
                $_G['menu'] = 'off_sale_item';
            }else {
                $_G['menu'] = 'on_sale_item';
                $condition['on_sale'] = 1;
            }

            $model = ItemModel::getInstance();
            $totalnum   = $model->where($condition)->count();
            $pagecount  = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
            $_G['page'] = min(array($_G['page'], $pagecount));
            $itemlist = $model->where($condition)->page($_G['page'], $pagesize)->order('itemid', 'DESC')->select();
            $pagination = $this->pagination($_G['page'], $pagecount, $totalnum, "type=$type", true);

            $_G['title'] = $_lang['on_sale_item'];
            include template('item_list');
        }
    }

    /**
     * 出售宝贝
     */
    public function sell(){
        global $_G, $_lang;

        $itemid = intval($_GET['itemid']);
        if ($this->checkFormSubmit()){
            $catid = intval($_GET['catid']);
            /*
            $itemModel = new ItemModel();

            if ($itemid) {
                $itemModel->where(array('itemid'=>$itemid))->update(array('catid'=>$catid));
            }else {
                $itemContent = new ItemContentBuilder();
                $itemContent->setUid($this->uid);
                $itemContent->setCatid($catid);
                $itemContent->setShop_id($this->shop_id);
                $itemContent->setOn_sale('0');
                $itemid = $itemModel->insertObject($itemContent);
            }
            */
            $url = U('c=item&a=publish&catid='.$catid);
            $url.= $itemid ? "&itemid=".$itemid : '';
            $this->redirect($url);
        }else {
            $category_list = ItemCatlogModel::getInstance()->getCache();

            $_G['menu'] = 'sell';
            $_G['title'] = $_lang['sell_item'];
            include template('item_sell');
        }
    }

    /**
     * 发布宝贝
     */
    public function publish(){
        global $_G, $_lang;
        $_G['menu'] = 'sell';
        $catid = intval($_GET['catid']);
        $itemid = intval($_GET['itemid']);
        if (!$catid){
            $this->showError('invalid_parameter');
        }

        if ($this->checkFormSubmit()){
            $item = $_GET['item'];
            $itemObj = new ItemObject($item);
            if ($item['title'] && $item['price']){
                //更新产品信息
                $itemObj->setPrice(floatval($item['price']))
                        ->setSold(intval($item['stock']))
                        ->setCatid($catid);
                //产品图片
                $gallery = $_GET['gallery'];
                if ($gallery[0]['thumb']){
                    $itemObj->setThumb($gallery[0]['thumb']);
                    $itemObj->setImage($gallery[0]['image']);
                }
                if ($itemid) {
                    (new ItemModel())->where(array('itemid'=>$itemid))->updateObject($itemObj);
                }else {
                    $itemObj->setUid($this->uid)->setShopId($this->shop_id);
                    $itemid = (new ItemModel())->addObject($itemObj);
                }

                //添加产品介绍
                $content = trim($_GET['content']);
                $descModel = new ItemDescModel();
                if ($_GET['itemid']) {
                    $descObj = new ItemDescObject();
                    $descObj->setContent($content)->setUpdateTime(time());
                    $descModel->where(array('itemid'=>$itemid, 'uid'=>$this->uid))->data($descObj->getBizContent())->save();
                }else {
                    $descObj = new ItemDescObject();
                    $descObj->setUid($this->uid)->setItemid($itemid)->setContent($content)->setUpdateTime(time());
                    $descModel->data($descObj->getBizContent())->add();
                }

                if ($gallery) {
                    $imageModel = new ItemImageModel();
                    foreach ($gallery as $ga){
                        $id = intval($ga['id']);
                        if ($ga['thumb'] && $ga['image']){
                            if ($id > 0) {
                                $imageModel->where(array('id'=>$id, 'uid'=>$this->uid))->data(array(
                                    'thumb'=>$ga['thumb'],
                                    'image'=>$ga['image']
                                ))->save();
                            }else {
                                $imageModel->data(array(
                                    'uid'=>$this->uid,
                                    'itemid'=>$itemid,
                                    'thumb'=>$ga['thumb'],
                                    'image'=>$ga['image']
                                ))->add();
                            }
                        }
                    }
                }
                if ($_GET['itemid']) {
                    $this->showSuccess('update_succeed', null, array(
                        array('text'=>'reedit', 'url'=>curPageURL()),
                        array('text'=>'sell_item', 'url'=>U('c=item&a=sell')),
                        array('text'=>'back_list', 'url'=>U('c=item&a=itemlist'))
                    ));
                }else {
                    $this->showSuccess('update_succeed', null, array(
                        array('text'=>'sell_item', 'url'=>U('c=item&a=sell')),
                        array('text'=>'back_list', 'url'=>U('c=item&a=itemlist'))
                    ));
                }

            }else {
                $this->showError('invalid_parameter');
            }
        }else {
            if ($itemid) {
                $item    = (new ItemModel())->where(array('uid'=>$this->uid, 'itemid'=>$itemid))->getOne();
                $desc    = (new ItemDescModel())->where(array('itemid'=>$itemid, 'uid'=>$this->uid))->getOne();
                $gallery = (new ItemImageModel())->where(array('uid'=>$this->uid, 'itemid'=>$itemid))->select();
                $editorcontent = $desc['content'];
            }

            $catlogPaths = (new ItemCatlogModel())->getParents($catid);
            $catlogPaths = array_reverse($catlogPaths);
            $editorname = 'content';

            $_G['title'] = $_lang['publish_item'];
            include template('item_publish');
        }
    }

    /**
     * 获取商品列表
     */
    public function get_catelist(){
        $catlog_list = array();
        $fid = intval($_GET['fid']);
        foreach (ItemCatlogModel::getInstance()->getCache() as $catlog){
            if ($catlog['fid'] == $fid){
                $catlog_list[] = array('catid'=>$catlog['catid'], 'name'=>$catlog['name']);
            }
        }
        $this->showAjaxReturn($catlog_list);
    }

    /**
     * 删除商品
     */
    public function delete(){
        $itemid = intval($_GET['itemid']);
        $this->delItemData($itemid);
        $this->showAjaxReturn();
    }

    /**
     * 删除所有商品数据
     * @param $itemid
     */
    private function delItemData($itemid){
        $model = new ItemModel();
        if ($model->where(array('uid'=>$this->uid, 'itemid'=>$itemid))->delete()){
            //删除商品图片
            ItemImageModel::getInstance()->where(array('uid'=>$this->uid, 'itemid'=>$itemid))->delete();
            //删除商品描述
            ItemDescModel::getInstance()->where(array('uid'=>$this->uid, 'itemid'=>$itemid))->delete();
        }
    }
}