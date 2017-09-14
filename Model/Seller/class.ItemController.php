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
                        item_update_data(array('itemid'=>$itemid), array('on_sale'=>1));
                    }
                    $this->showSuccess('update_succeed');
                }

                if ($_GET['eventType'] == 'off_sale'){
                    foreach ($items as $itemid){
                        item_update_data(array('itemid'=>$itemid), array('on_sale'=>0));
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
    }

    /**
     * 出售宝贝
     */
    public function sell(){
        global $_G, $_lang;

        if ($this->checkFormSubmit()){
            $catid = intval($_GET['catid']);
            $itemid = item_add_data(array(
                'uid'=>$this->uid,
                'catid'=>$catid,
                'shop_id'=>$this->shop_id,
                'item_sn'=>item_create_sn(),
                'on_sale'=>0,
                'create_time'=>time()
            ));
            $this->redirect(U('c=item&a=publish&catid='.$catid.'&itemid='.$itemid));
        }else {
            $category_list = item_get_cat_list();

            $_G['menu'] = 'sell';
            $_G['title'] = $_lang['sell_item'];
            include template('item_sell');
        }
    }

    /**
     *
     */
    public function publish(){
        global $_G, $_lang;
        $_G['menu'] = 'sell';
        $catid = intval($_GET['catid']);
        $itemid = intval($_GET['itemid']);
        if (!$catid || !$itemid){
            $this->showError('invalid_parameter');
        }

        if ($this->checkFormSubmit()){
            $item = $_GET['item'];
            if ($item['title'] && $item['price']){
                //更新产品信息
                $item['price'] = floatval($item['price']);
                $item['stock'] = intval($item['stock']);
                $item['update_time'] = time();
                //产品图片
                $gallery = $_GET['gallery'];
                if ($gallery[0]['thumb']){
                    $item['thumb'] = $gallery[0]['thumb'];
                    $item['image'] = $gallery[0]['image'];
                }
                item_update_data(array('itemid'=>$itemid, 'uid'=>$this->uid), $item);

                //添加产品介绍
                $content = trim($_GET['content']);
                $res = item_update_desc(array('itemid'=>$itemid, 'uid'=>$this->uid), array('content'=>$content, 'update_time'=>time()));
                if (!$res) {
                    item_add_desc(array(
                        'itemid'=>$itemid,
                        'content'=>$content,
                        'uid'=>$this->uid,
                        'update_time'=>time()
                    ));
                }

                foreach ($gallery as $ga){
                    $id = intval($ga['id']);
                    if ($ga['thumb'] && $ga['image']){
                        if ($id > 0) {
                            item_update_image(array('id'=>$id, 'uid'=>$this->uid), array(
                                'thumb'=>$ga['thumb'],'image'=>$ga['image']
                            ));
                        }else {
                            item_add_image(array(
                                'uid'=>$this->uid,
                                'itemid'=>$itemid,
                                'thumb'=>$ga['thumb'],
                                'image'=>$ga['image']
                            ));
                        }
                    }
                }
                $this->showSuccess('update_succeed', null, array(
                    array('text'=>'reedit', 'url'=>curPageURL()),
                    array('text'=>'sell_item', 'url'=>U('c=item&a=sell')),
                    array('text'=>'back_list', 'url'=>U('c=item&a=itemlist'))
                ));
            }else {
                $this->showError('invalid_parameter');
            }
        }else {

            $item = item_get_data(array('itemid'=>$itemid));
            $desc = item_get_desc(array('itemid'=>$itemid, 'uid'=>$this->uid));
            $gallery = item_get_image_list(array('itemid'=>$itemid));

            $editorname = 'content';
            $editorcontent = $desc['content'];
            $_G['title'] = $_lang['publish_item'];
            include template('item_publish');
        }
    }

    /**
     *
     */
    public function get_catelist(){
        $category_list = item_get_cat_list();
        $fid = intval($_GET['fid']);
        $new_category_list = array();
        foreach ($category_list as $cat){
            if ($cat['fid'] == $fid){
                $new_category_list[] = array('catid'=>$cat['catid'], 'name'=>$cat['name']);
            }
        }
        $this->showAjaxReturn($new_category_list);
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
        item_delete_data(array('uid'=>$this->uid, 'itemid'=>$itemid));
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

    private function update(){
        $itemlist = item_get_list(array('item_sn'=>''),0);
        foreach ($itemlist as $item){
            item_update_data(array('itemid'=>$item['itemid']), array('item_sn'=>item_create_sn()));
        }
    }
}