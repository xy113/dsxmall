<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/29
 * Time: 下午11:16
 */

namespace Model\App;


use Data\Common\PageModel;

class PageController extends BaseController
{
    public function index(){

    }

    /**
     *
     */
    public function detail(){
        global $_G,$_lang;

        $pageid = intval($_GET['pageid']);
        $pagecontent = (new PageModel())->where(array('pageid'=>$pageid))->getOne();

        $_G['title'] = $pagecontent['title'];
        include template('page_detail');
    }
}