<?php
namespace Model\Home;

use Data\Common\BlockItemModel;
use Data\Common\BlockModel;
use Data\Item\ItemCatlogModel;
use Data\Item\ItemModel;
use Data\Post\PostItemModel;
use Data\Shop\ShopModel;

class IndexController extends BaseController{
    /**
     *
     */
    public function index(){
		global $_G,$_lang;

        //商品分类列表
        $item_catlog_list = array();
        foreach ((new ItemCatlogModel())->getCache() as $catlog){
            $item_catlog_list[$catlog['fid']][$catlog['catid']] = $catlog;
        }
        unset($catlog);
        //最新资讯
        $newPostList = (new PostItemModel())->where(array('status'=>1))->field('aid, title')->order('aid', 'DESC')->limit(0, 12)->select();

        $itemModel = new ItemModel();
        $item_list['hot'] = $itemModel->where(array('on_sale'=>1))->limit(0, 5)->selectHot();
        //企业店铺
        $shop_list = (new ShopModel())->where(array('closed'=>0))->limit(0, 10)->select();

        $blockModel = new BlockModel();
        $slide_list = $blockModel->getCache(1);
        $best_list = $blockModel->getCache(2);
        //今日特供
        $tegong = (new BlockItemModel())->where(array('id'=>8))->getOne();
        //粗耕优选
        $youxuanList = M('item_push p')->field('i.*')
            ->join('item i', 'i.itemid=p.itemid')->where('i.on_sale=1 AND i.price>0 AND p.groupid=2')
            ->limit(0, 5)->order('p.push_id DESC')->select();
        //猜你喜欢
        $recommendList = M('item_push p')->field('i.*')
            ->join('item i', 'i.itemid=p.itemid')->where('i.on_sale=1 AND i.price>0 AND p.groupid=1')
            ->limit(0, 50)->order('p.push_id DESC')->select();

        $_G['nav'] = 'home';
		include template('index');
	}

    /**
     *
     */
    public function app(){
        echo md5_16(random(10));
        echo '<br>';
        echo md5(random(10));
        print_array($_SERVER);
    }
}