<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/7
 * Time: 下午12:09
 */
namespace Model\Buy;
class OrderController extends BaseController{
    /**
     * 购买确认订单
     */
    public function index(){
        $this->confirm_order();
    }

    /**
     * 购买确认订单
     */
    public function confirm_order(){
        global $_G,$_lang;

        $_G['title'] = $_lang['confirm_order'];
        include template('confirm_order');
    }
}