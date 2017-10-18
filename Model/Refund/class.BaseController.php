<?php
namespace Model\Refund;
use Core\Controller;

/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/12
 * Time: 下午4:10
 */

class BaseController extends Controller
{
    /**
     * BaseController constructor.
     */
    function __construct()
    {
        parent::__construct();
        if (!$this->islogin){
            $this->showLogin();
        }
    }
}