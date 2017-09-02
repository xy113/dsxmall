<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/2
 * Time: 下午12:08
 */
namespace Model\Seller;
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

        $pagesize = 10;
        $condition = array('uid'=>$this->uid);
        $type = intval($_GET['type']);
        $_G['menu'] = 'on_sale_item';
        if ($type == 1) {
            $condition['on_sale'] = 1;
        }elseif ($type == 2){
            $condition['on_sale'] = 0;
            $_G['menu'] = 'off_sale_item';
        }
        $q = $_GET['q'] ? htmlspecialchars($_GET['q']) : '';
        if ($q) $condition['name'] = array('LIKE', $q);

        $totalnum   = item_get_count($condition);
        $pagecount  = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
        $_G['page'] = min(array($_G['page'], $pagecount));
        $itemlist = item_get_list($condition, $pagesize, ($_G['page'] - 1) * $pagesize);
        $pages = $this->showPages($_G['page'], $pagecount, $totalnum, "type=$type&q=$q", true);

        $_G['title'] = $_lang['on_sale_item'];
        include template('item_list');
    }

    /**
     * 批量更新商品信息
     */
    public function batch_update(){
        if ($this->checkFormSubmit()) {
            $ids = $_GET['ids'];
            if ($ids && is_array($ids)) {
                //批量删除商品
                if ($_GET['option'] == 'delete') {
                    foreach ($ids as $goods_id){
                        $this->delGoodsData($goods_id);
                    }
                    $this->showSuccess('delete_succeed');
                }
                //批量上架商品
                if ($_GET['option'] == 'on_sale'){
                    $ids = implodeids($ids);
                    item_update_data(array('id'=>array('IN', $ids)), array('on_sale'=>1));
                    $this->showSuccess('update_succeed');
                }

                //批量下架商品
                if ($_GET['option'] == 'off_sale'){
                    $ids = implodeids($ids);
                    item_update_data(array('id'=>array('IN', $ids)), array('on_sale'=>0));
                    $this->showSuccess('update_succeed');
                }

            }else {
                $this->showAjaxError('no_select');
            }
        }else {
            $this->showError('undefined_action');
        }
    }

    /**
     * 出售宝贝
     */
    public function sell(){
        global $_G, $_lang;

        if ($this->checkFormSubmit()){
            $item = $_GET['item'];
            if ($item['name'] && $item['price']){
                //添加产品信息
                $item['sn'] = item_create_sn();
                $item['price'] = floatval($item['price']);
                $item['stock'] = intval($item['stock']);
                $item['uid'] = $this->uid;
                $item['shop_id'] = $this->shop_id;
                $item['create_time'] = time();
                //产品图片
                $gallery = $_GET['gallery'];
                $item_img = $gallery ? reset($gallery) : array();
                $item['thumb'] = $item_img['thumb'];
                $item['image'] = $item_img['image'];
                $itemid = item_add_data($item);
                //添加产品介绍
                $content = trim($_GET['content']);
                item_add_desc(array(
                    'uid'=>$this->uid,
                    'itemid'=>$itemid,
                    'content'=>$content
                ));
                //添加产品图片
                if ($gallery && is_array($gallery)){
                    foreach ($gallery as $image){
                        $image['uid'] = $this->uid;
                        $image['itemid'] = $itemid;
                        item_add_image($image);
                    }
                }
                $this->showSuccess('save_succeed', null, array(
                    array('text'=>'continue_publish', 'url'=>curPageURL()),
                    array('text'=>'back_list', 'url'=>U('c=item&a=itemlist'))
                ));
            }else {
                $this->showError('invalid_parameter');
            }
        }else {

            $editorname = 'content';
            $cat_data = json_encode($this->getCatList(), JSON_UNESCAPED_UNICODE);

            $_G['menu'] = 'sell';
            $_G['title'] = $_lang['sell_item'];
            include template('item_form');
        }
    }

    /**
     * 编辑宝贝
     */
    public function edit(){
        global $_G,$_lang;

        $itemid = intval($_GET['id']);
        if ($this->checkFormSubmit()) {
            $item = $_GET['item'];
            if ($item['name'] && $item['price']){
                //更新产品信息
                $item['price'] = floatval($item['price']);
                $item['stock'] = intval($item['stock']);
                $item['update_time'] = time();
                //产品图片
                $gallery = $_GET['gallery'];
                $item_img = $gallery ? reset($gallery) : array();
                $item['thumb'] = $item_img['thumb'];
                $item['image'] = $item_img['image'];
                $res = item_update_data(array('id'=>$itemid, 'uid'=>$this->uid), $item);

                //添加产品介绍
                $content = trim($_GET['content']);
                if ($res) item_update_desc(array('itemid'=>$itemid), array('content'=>$content, 'uid'=>$this->uid));

                $item_image_list = item_get_image_list(array('itemid'=>$itemid));
                if ($item_image_list) {
                    $image_list = $sign_list = array();
                    foreach ($item_image_list as $img){
                        $sign_list[$img['id']]  = 'delete';
                        $image_list[$img['id']] = $img;
                    }
                    if ($gallery && is_array($gallery)){
                        foreach ($gallery as $img_id=>$img) {
                            if (isset($image_list[$img_id])) {
                                $sign_list[$img_id] = 'update';
                                $image_list[$img_id]['thumb'] = $img['thumb'];
                                $image_list[$img_id]['image'] = $img['image'];
                            }else {
                                $sign_list[$img_id] = 'insert';
                                $image_list[$img_id] = array(
                                    'uid'=>$this->uid,
                                    'itemid'=>$itemid,
                                    'thumb'=>$img['thumb'],
                                    'image'=>$img['image']
                                );
                            }
                        }
                    }

                    foreach ($image_list as $img_id=>$image) {
                        if ($sign_list[$img_id] == 'update') {
                            item_update_image(array('id'=>$img_id), $image);
                        }elseif ($sign_list[$img_id] == 'insert'){
                            item_add_image($image);
                        }else {
                            item_delete_image(array('id'=>$img_id));
                        }
                    }
                }
                $this->showSuccess('update_succeed', null, array(
                    array('text'=>'reedit', 'url'=>curPageURL()),
                    array('text'=>'back_list', 'url'=>U('c=item&a=itemlist'))
                ));
            }else {
                $this->showError('invalid_parameter');
            }
        }else {

            $item = item_get_data(array('id'=>$itemid));
            $item_desc = item_get_desc(array('itemid'=>$itemid));
            $gallery = item_get_image_list(array('itemid'=>$itemid));

            $editorname = 'content';
            $editorcontent = $item_desc['content'];
            $cat_data = json_encode($this->getCatList());

            $_G['title'] = $_lang['edit_item'];
            include template('item_form');
        }
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
        item_delete_data(array('uid'=>$this->uid, 'id'=>$itemid));
        item_delete_desc(array('uid'=>$this->uid, 'itemid'=>$itemid));
        item_delete_image(array('uid'=>$this->uid, 'itemid'=>$itemid));
    }

    /**
     * 获取产品分类列表
     * @return array
     */
    private function getCatList(){
        $itemlist = item_get_cat_list();
        if ($itemlist) {
            $datalist = array();
            foreach ($itemlist as $item){
                $datalist[$item['fid']][$item['catid']] = array(
                    'fid'=>$item['fid'],
                    'catid'=>$item['catid'],
                    'name'=>$item['name']
                );
            }
            return $datalist;
        }else {
            return array();
        }
    }
}