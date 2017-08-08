<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/5
 * Time: 上午11:23
 */
namespace Model\Admin;
class AppController extends BaseController{
    /**
     *
     */
    public function index(){
        global $_G,$_lang;

        if ($this->checkFormSubmit()) {

        }else {

            $_G['title'] = $_lang['app_manage'];
            $_GET['menu'] = 'app';
            include template('apps');
        }
    }
}