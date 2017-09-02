<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/3
 * Time: 下午5:02
 */
namespace Model\Item;
class IndexController extends BaseController{
    public function index(){
        global $_G,$_lang;

        include template('index');
    }
}