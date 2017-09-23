<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/14
 * Time: 上午9:48
 */
namespace Model\Material;

use Core\Controller;

class BaseController extends Controller
{
    /**
     * BaseController constructor.
     */
    function __construct()
    {
        parent::__construct();
        if (!$this->islogin) {
            exit();
        }
    }
}