<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/7/25
 * Time: 下午2:29
 */
namespace Model\Member;
use Data\Trade\WalletModel;

class IndexController extends BaseController{
    /**
     *
     */
    public function index(){
        global $_G,$_lang;

        $wallet = (new WalletModel())->getWallet($this->uid);
        $_G['title'] = '会员中心';
        include template('index');
    }
}