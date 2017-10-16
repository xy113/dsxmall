<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/7/31
 * Time: 上午10:12
 */
namespace Model\Seller;
use Core\Controller;
use Data\Shop\ShopModel;

class BaseController extends Controller{
    protected $shop_id = 0;
    protected $shop_name = '';
    protected $shop_data = array();
    /**
     * BaseController constructor.
     */
    function __construct()
    {
        parent::__construct();
        if (!$this->isLogin()){
            $this->showLogin();
        }else {
            $shop = (new ShopModel())->where(array('uid'=>$this->uid))->getOne();
            if ($shop) {
                $this->shop_id = $shop['shop_id'];
                $this->shop_name = $shop['shop_name'];
                $this->shop_data = $shop;
            }
        }
    }
}