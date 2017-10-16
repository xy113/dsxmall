<?php
namespace Model\App;
use Data\Common\BlockModel;
use Data\Post\PostItemModel;

class IndexController extends BaseController{
    /**
     * APP首页
     */
    public function index(){
		global $_G,$_lang;

        $menulist = array();
        foreach (cache('menu_2') as $menu){
            if (strpos($menu['url'], 'http://') !== false){
                $menu['is_url'] = true;
            }else {
                $menu['is_url'] = false;
            }
            $menulist[] = $menu;
        }
        $newPostList = (new PostItemModel())->where(array('status'=>1))->order('aid', 'DESC')->limit(0, 6)->select();

        $blockModel = new BlockModel();
        $slide_list = $blockModel->getCache(4);
        $ad_list = $blockModel->getCache(5);
        include template('index');
	}

    /**
     * 获取商品数据
     */
    public function batchget(){
        $offset = (G('page') - 1) * 20;
        $fields = 'i.itemid, i.title, i.thumb, i.price, i.sold';
        $itemlist = M('item_recommend r')->field($fields)->join('item i', 'i.itemid=r.itemid')
            ->where('on_sale=1')->limit($offset, 20)->order('r.id DESC')->select();
        $datalist = array();
        foreach ($itemlist as $item){
            $item['thumb'] = image($item['thumb']);
            $item['price'] = formatAmount($item['price']);
            $datalist[] = $item;
        }
        $this->showAjaxReturn($datalist);
    }
}