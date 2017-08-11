<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/11
 * Time: 上午9:57
 */
namespace Model\Account;
class ChkloginController extends BaseController{
    /**
     *
     */
    public function index(){
        if ($this->islogin) {
            $this->showAjaxReturn();
        }else {
            $this->showAjaxError('FAIL', 'NOT LOGGED');
        }
    }
}