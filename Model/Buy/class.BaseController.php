<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/7
 * Time: 下午12:09
 */
namespace Model\Buy;
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