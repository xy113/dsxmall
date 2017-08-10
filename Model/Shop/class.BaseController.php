<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/3
 * Time: 下午4:51
 */
namespace Model\Shop;
use Core\Controller;

class BaseController extends Controller{
    function __construct()
    {
        parent::__construct();
        G('nav', 'shop');
    }
}