<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/27
 * Time: 下午5:54
 */

namespace Model\App;


use Data\Post\PostContentModel;
use Data\Post\PostItemModel;

class ArticleController extends BaseController
{
    /**
     *
     */
    public function index(){
        $this->itemlist();
    }

    /**
     * 文章列表
     */
    public function itemlist(){
        global $_G,$_lang;

        include template('article_list');
    }

    /**
     *
     */
    public function batchget(){

        $itemlist = (new PostItemModel())->where(array('status'=>1))->field('aid,title,image,pubtime,view_num')
            ->page(G('page'), 20)->order('aid', 'DESC')->select();
        $datalist = array();
        foreach ($itemlist as $item){
            $item['pubtime'] = date('Y-m-d H:i', $item['pubtime']);
            $item['image'] = image($item['image']);
            $datalist[] = $item;
        }
        $this->showAjaxReturn($datalist);
    }

    /**
     * 文章详情
     */
    public function detail(){
        global $_G, $_lang;
        $aid = $_GET['aid'] ? intval($_GET['aid']) : intval($_GET['id']);

        $postItem = new PostItemModel();
        $postItem->updateView_num($aid);

        $article = $postItem->where(array('aid'=>$aid, 'status'=>1))->getOne();
        $content = (new PostContentModel())->where(array('aid'=>$aid))->getOne();
        $content = cleanUpStyle($content['content']);
        $content = preg_replace('/\<a(.*?)\>(.*?)\<\/a\>/is', '\\2', $content);
        $content = preg_replace('/\<img(.*?)src=\"(.*?)\"(.*?)>/is', '<img src="\\2">', $content);

        include template('article_detail');
    }
}