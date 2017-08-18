<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/15
 * Time: 下午2:30
 */
namespace Model\Buy;
class NotifyController extends BaseController{
    public function index(){

    }

    /**
     *
     */
    public function wxpay(){
        cache('notify', $_GET);
    }
}