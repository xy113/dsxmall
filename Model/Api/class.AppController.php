<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/30
 * Time: 下午12:17
 */

namespace Model\Api;


class AppController extends BaseController
{
    function __construct()
    {
        $this->verifyToken = false;
        parent::__construct();
    }

    /**
     *
     */
    public function get_version(){
        $appid = trim($_GET['appid']);
        $appconf = C('app_'.$appid);
        $this->showAjaxReturn(array('version'=>$appconf['version']));
    }
}