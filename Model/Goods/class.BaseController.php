<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/3
 * Time: 下午5:01
 */
namespace Model\Goods;
use Core\Controller;

class BaseController extends Controller{
    /**
     * BaseController constructor.
     */
    function __construct()
    {
        parent::__construct();
        G('nav', 'goods');
    }
}