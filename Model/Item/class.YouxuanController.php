<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/14
 * Time: 上午11:34
 */

namespace Model\Item;


class YouxuanController extends BaseController
{
    /**
     * 粗耕优选
     */
    public function index(){
        global $_G, $_lang;

        $itemlist = M('item_push p')->field('i.*')
            ->join('item i', 'i.itemid=p.itemid')->where('i.on_sale=1 AND i.price>0 AND p.groupid=2')->limit(0, 100)->select();

        $this->var['title'] = '粗耕优选';
        include template('youxuan');
    }
}