<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/8
 * Time: 下午5:10
 */
namespace Model\Cart;
use Core\Controller;

class BaseController extends Controller{
    /**
     * BaseController constructor.
     */
    function __construct()
    {
        parent::__construct();
        if (!$this->isLogin()) {
            $redirect = urlencode(urlencode(curPageURL()));
            $this->redirect(U('m=account&c=login&redirect='.$redirect));
        }
    }
}