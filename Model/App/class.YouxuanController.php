<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/13
 * Time: 下午5:54
 */

namespace Model\App;


use Data\Common\BlockModel;

class YouxuanController extends BaseController
{
    /**
     *
     */
    public function index(){
        global $_G,$_lang;

        $itemlist = M('item_push p')->field('i.*')
            ->join('item i', 'i.itemid=p.itemid')->where('i.price>0 AND p.groupid=2')->limit(0, 50)->select();

        $blockModel = new BlockModel();
        $slide_list = $blockModel->getCache(4);

        $_G['title'] = '粗耕优选';
        include template('youxuan');
    }
}