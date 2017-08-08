<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/1
 * Time: 上午10:54
 */
namespace Model\Openshop;
class IndexController extends BaseController{
    /**
     * 申请开店
     */
    public function index(){
        $this->redirect(U('m=openshop&c=auth'));
    }
}