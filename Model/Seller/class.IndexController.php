<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/7/31
 * Time: 上午10:13
 */
namespace Model\Seller;
class IndexController extends BaseController{
    /**
     *
     */
    public function index(){
        global $_G,$_lang;

        $_G['title'] = '卖家中心';
        include template('index');
    }
}