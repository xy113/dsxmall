<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/2
 * Time: 下午12:08
 */
namespace Model\Seller;
class GoodsController extends BaseController{
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
        $_GET['menu'] = 'on_sale_goods';
        if ($type == 1) {
            $condition['on_sale'] = 1;
        }elseif ($type == 2){
            $condition['on_sale'] = 0;
            $_GET['menu'] = 'off_sale_goods';
        }
        $q = $_GET['q'] ? htmlspecialchars($_GET['q']) : '';
        if ($q) $condition['goods_name'] = array('LIKE', $q);

        $totalnum = goods_get_item_count($condition);
        $pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
        $_G['page'] = min(array($_G['page'], $pagecount));
        $start_limit = ($_G['page'] - 1) * $pagesize;
        $goods_list = goods_get_item_list($condition, $pagesize, $start_limit);
        $pages = $this->showPages($_G['page'], $pagecount, $totalnum, "type=$type&q=$q", true);

        $_G['title'] = $_lang['on_sale_goods'];
        include template('goods_list');
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
                    goods_update_item(array('id'=>array('IN', $ids)), array('on_sale'=>1));
                    $this->showSuccess('update_succeed');
                }

                //批量下架商品
                if ($_GET['option'] == 'off_sale'){
                    $ids = implodeids($ids);
                    goods_update_item(array('id'=>array('IN', $ids)), array('on_sale'=>0));
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
            $goods = $_GET['goods'];
            if ($goods['goods_name'] && $goods['goods_price']){
                //添加产品信息
                $goods['goods_sn'] = goods_create_sn();
                $goods['goods_price'] = floatval($goods['goods_price']);
                $goods['stock'] = intval($goods['stock']);
                $goods['uid'] = $this->uid;
                $goods['shop_id'] = $this->shop_id;
                $goods['create_time'] = time();
                //产品图片
                $gallery = $_GET['gallery'];
                $goods_img = $gallery ? reset($gallery) : array();
                $goods['goods_thumb'] = $goods_img['thumb'];
                $goods['goods_image'] = $goods_img['image'];
                $goods_id = goods_add_item($goods);
                //添加产品介绍
                $content = trim($_GET['content']);
                goods_add_desc(array(
                    'uid'=>$this->uid,
                    'goods_id'=>$goods_id,
                    'content'=>$content
                ));
                //添加产品图片
                if ($gallery && is_array($gallery)){
                    foreach ($gallery as $image){
                        $image['uid'] = $this->uid;
                        $image['goods_id'] = $goods_id;
                        goods_add_image($image);
                    }
                }
                $this->showSuccess('save_succeed', null, array(
                    array('text'=>'continue_publish', 'url'=>curPageURL()),
                    array('text'=>'back_list', 'url'=>U('c=goods&a=itemlist'))
                ));
            }else {
                $this->showError('invalid_parameter');
            }
        }else {

            $editorname = 'content';
            $cat_data = json_encode($this->getCatList());

            $_GET['menu'] = 'sell';
            $_G['title'] = $_lang['sell_goods'];
            include template('goods_form');
        }
    }

    public function edit(){
        global $_G,$_lang;

        $goods_id = intval($_GET['id']);
        if ($this->checkFormSubmit()) {
            $goods = $_GET['goods'];
            if ($goods['goods_name'] && $goods['goods_price']){
                //更新产品信息
                $goods['goods_price'] = floatval($goods['goods_price']);
                $goods['stock'] = intval($goods['stock']);
                $goods['update_time'] = time();
                //产品图片
                $gallery = $_GET['gallery'];
                $goods_img = $gallery ? reset($gallery) : array();
                $goods['goods_thumb'] = $goods_img['thumb'];
                $goods['goods_image'] = $goods_img['image'];
                goods_update_item(array('id'=>$goods_id), $goods);

                //添加产品介绍
                $content = trim($_GET['content']);
                goods_update_desc(array('goods_id'=>$goods_id), array('content'=>$content));

                $goods_image_list = goods_get_image_list(array('goods_id'=>$goods_id));
                if ($goods_image_list) {
                    $image_list = $sign_list = array();
                    foreach ($goods_image_list as $img){
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
                                    'goods_id'=>$goods_id,
                                    'thumb'=>$img['thumb'],
                                    'image'=>$img['image']
                                );
                            }
                        }
                    }

                    foreach ($image_list as $img_id=>$image) {
                        if ($sign_list[$img_id] == 'update') {
                            goods_update_image(array('id'=>$img_id), $image);
                        }elseif ($sign_list[$img_id] == 'insert'){
                            goods_add_image($image);
                        }else {
                            goods_delete_image(array('id'=>$img_id));
                        }
                    }
                }
                $this->showSuccess('update_succeed', null, array(
                    array('text'=>'reedit', 'url'=>curPageURL()),
                    array('text'=>'back_list', 'url'=>U('c=goods&a=itemlist'))
                ));
            }else {
                $this->showError('invalid_parameter');
            }
        }else {

            $goods = goods_get_item(array('id'=>$goods_id));
            $goods_desc = goods_get_desc(array('goods_id'=>$goods_id));
            $gallery = goods_get_image_list(array('goods_id'=>$goods_id));

            $editorname = 'content';
            $editorcontent = $goods_desc['content'];
            $cat_data = json_encode($this->getCatList());

            $_G['title'] = $_lang['edit_goods'];
            include template('goods_form');
        }
    }

    /**
     * 删除商品
     */
    public function del_goods(){
        $goods_id = intval($_GET['goods_id']);
        $this->delGoodsData($goods_id);
        $this->showAjaxReturn();
    }

    /**
     * 删除所有商品数据
     * @param $goods_id
     */
    private function delGoodsData($goods_id){
        goods_delete_item(array('uid'=>$this->uid, 'id'=>$goods_id));
        goods_delete_desc(array('uid'=>$this->uid, 'goods_id'=>$goods_id));
        goods_delete_image(array('uid'=>$this->uid, 'goods_id'=>$goods_id));
    }

    /**
     * 获取产品分类列表
     * @return array
     */
    private function getCatList(){
        $itemlist = goods_get_cat_list();
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