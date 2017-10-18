<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/2
 * Time: 下午3:00
 */
namespace Model\Admin;
use Data\Item\ItemCatlogModel;
use Data\Item\ItemDescModel;
use Data\Item\ItemImageModel;
use Data\Item\ItemModel;
use Data\Item\ItemRecommendModel;

class ItemController extends BaseController{
    private $items = array();

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

        if ($this->checkFormSubmit()) {
            if ($this->checkFormSubmit()) {
                $this->items = $_GET['items'];
                if ($this->items && is_array($this->items)) {
                    $eventType = htmlspecialchars($_GET['eventType']);
                    if ($eventType == 'delete'){
                        $this->delete();
                    }

                    if ($eventType == 'on_sale'){
                        $this->on_sale();
                    }

                    if ($eventType == 'off_sale'){
                        $this->off_sale();
                    }
                    //移动文章
                    if ($eventType == 'move'){
                        $this->move();
                        exit();
                    }

                    if ($eventType == 'recommend'){
                        $this->recommend();
                    }
                }else {
                    $this->showAjaxError(2, 'no_select');
                }
            }else {
                $this->showAjaxError(1, 'undefined_action');
            }
        }else {

            $condition = array();
            $queryParams = array();

            $shop_name = htmlspecialchars($_GET['shop_name']);
            if ($shop_name) {
                $condition[] = "(s.shop_name LIKE '%$shop_name%')";
                $queryParams['shop_name'] = $shop_name;
            }

            $seller_name = htmlspecialchars($_GET['seller_name']);
            if ($seller_name) {
                $condition[] = "s.username='$seller_name'";
                $queryParams['seller_name'] = $seller_name;
            }

            $sale_status = htmlspecialchars($_GET['sale_status']);
            if ($sale_status) {
                if ($sale_status == 'on_sale'){
                    $condition[] = "i.on_sale=1";
                }
                if ($sale_status == 'off_sale'){
                    $condition[] = "i.on_sale=0";
                }
                $queryParams['sale_status'] = $sale_status;
            }

            $title = htmlspecialchars($_GET['title']);
            if ($title) {
                $condition[] = "(i.title LIKE '%$title%')";
                $queryParams['title'] = $title;
            }

            $min_price = htmlspecialchars($_GET['min_price']);
            $max_price = htmlspecialchars($_GET['max_price']);
            if ($min_price) {
                $condition[] = "i.price>".floatval($min_price);
                $queryParams['min_price'] = $min_price;
            }

            if ($max_price) {
                $condition[] = "i.price<".floatval($max_price);
                $queryParams['max_price'] = $max_price;
            }

            $itemid = htmlspecialchars($_GET['itemid']);
            if ($itemid) {
                $condition[] = "i.itemid='$itemid'";
                $queryParams['itemid'] = $itemid;
            }

            $catid = $_GET['catid'];
            if ($catid) {
                $condition['catid'] = intval($catid);
                $queryParams['catid'] = $catid;
            }

            $pagesize = 20;
            $totalnum = M('item i')->join('shop s', 's.shop_id=i.shop_id')->where($condition)->count();
            $pagecount  = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
            $_G['page'] = min(array($_G['page'], $pagecount));
            $fileds = 'i.itemid,i.catid,i.title,i.thumb,i.image,i.price,i.sold,i.on_sale,i.create_time,s.shop_id,s.shop_name';
            $itemlist   = M('item i')->field($fileds)->join('shop s', 's.shop_id=i.shop_id')->where($condition)
            ->order('i.itemid DESC')->page($_G['page'], $pagesize)->select();
            $pages = $this->showPages($_G['page'], $pagecount, $totalnum, http_build_query($queryParams), true);
            unset($condition, $queryParams);
            //商品分类
            $catlogModel = new ItemCatlogModel();
            $catloglist = $catlogModel->getCache();
            $catlogtree = $catlogModel->getCatlogTree();

            $_G['title'] = $_lang['item_manage'];
            include template('item/item_list');
        }
    }

    /**
     *
     */
    private function delete(){
        foreach ($this->items as $itemid){
            $this->delItemData($itemid);
        }
        $this->showAjaxReturn();
    }

    /**
     * 上架
     */
    private function on_sale(){
        $model = new ItemModel();
        foreach ($this->items as $itemid){
            $model->where(array('itemid'=>$itemid))->data(array('on_sale'=>1))->save();
        }
        $this->showAjaxReturn();
    }

    /**
     * 下架
     */
    private function off_sale(){
        $model = new ItemModel();
        foreach ($this->items as $itemid){
            $model->where(array('itemid'=>$itemid))->data(array('on_sale'=>0))->save();
        }
        $this->showAjaxReturn();
    }

    /**
     * 移动商品
     */
    public function move(){
        global $_G,$_lang;

        if ($this->checkFormSubmit()) {
            $items = $_GET['items'];
            $catid = intval($_GET['catid']);
            if ($items && $catid) {
                $itemModel = new ItemModel();
                foreach (explode(',', $items) as $itemid){
                    $itemModel->where(array('itemid'=>$itemid))->data(array('catid'=>$catid))->save();
                }
            }
            $this->showSuccess('update_succeed', null, array(
                array('text'=>'back_list', 'url'=>U('c=item&a=index'))
            ));
        }else {

            $items = $_GET['items'];
            $items = is_array($items) ? implode(',', $items) : $items;
            $catloglist = (new ItemCatlogModel())->getCatlogTree();

            include view('item/item_move');
        }
    }

    /**
     *
     */
    private function recommend(){
        $model = new ItemRecommendModel();
        foreach ($this->items as $itemid){
            $model->data(array('itemid'=>$itemid))->add(null, false, true);
        }
        $this->showAjaxReturn();
    }

    /**
     * 删除所有商品数据
     * @param $itemid
     */
    private function delItemData($itemid){
        $condition = array('itemid'=>$itemid);
        (new ItemModel())->where($condition)->delete();
        (new ItemDescModel())->where($condition)->delete();
        (new ItemImageModel())->where($condition)->delete();
        (new ItemRecommendModel())->where($condition)->delete();
    }

    //首页推荐商品

    /**
     * 推荐商品列表
     */
    public function recommend_list(){
        global $_G,$_lang;

        if ($this->checkFormSubmit()){
            $items = $_GET['items'];
            $model = new ItemRecommendModel();
            foreach ($items as $itemid){
                $model->where(array('itemid'=>$itemid))->delete();
            }
            $this->showSuccess('delete_succeed');
        }else {
            $pagesize = 20;
            $totalnum = M('item_recommend r')->join('item i', 'i.itemid=r.itemid')->count();
            $pagecount  = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
            $_G['page'] = min(array($_G['page'], $pagecount));
            $fileds = 'r.itemid,i.title,i.thumb,i.image,i.price,i.sold,i.on_sale,i.create_time';
            $itemlist   = M('item_recommend r')->field($fileds)->join('item i', 'i.itemid=r.itemid')
                ->order('r.id DESC')->page($_G['page'], $pagesize)->select();
            $pages = $this->showPages($_G['page'], $pagecount, $totalnum, null, true);
            unset($condition, $queryParams);

            include template('item/item_recommend');
        }
    }

    /**
     * 添加推荐商品
     */
    public function add_recommend(){
        $itemid = intval($_GET['itemid']);
        (new ItemRecommendModel())->data(array('itemid'=>$itemid))->add(null, false, true);
        $this->showAjaxReturn();
    }
}