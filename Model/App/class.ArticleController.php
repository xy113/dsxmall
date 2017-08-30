<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/27
 * Time: 下午5:54
 */

namespace Model\App;


class ArticleController extends BaseController
{
    public function index(){

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
        $offset = (G('page') - 1) * 20;
        $itemlist = post_get_item_list(0, 20, $offset);
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
        $id = intval($_GET['id']);
        post_update_item(array('id'=>$id), '`viewnum`=`viewnum`+1');
        $article = post_get_item(array('id'=>$id));
        $content = post_get_content(array('aid'=>$id));
        $content = cleanUpStyle($content);
        $content = preg_replace('/\<a(.*?)\>(.*?)\<\/a\>/is', '\\2', $content);
        $content = preg_replace('/\<img(.*?)src=\"(.*?)\"(.*?)>/is', '<img src="\\2">', $content);

        include template('article_detail');
    }
}