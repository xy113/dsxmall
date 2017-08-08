<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/7/31
 * Time: 上午10:12
 */
namespace Model\Seller;
use Core\Controller;

class BaseController extends Controller{
    protected $shop_id = 0;
    protected $shop = array();
    /**
     * BaseController constructor.
     */
    function __construct()
    {
        parent::__construct();
        if (!$this->isLogin()){
            member_show_login();
        }else {
            $shop = shop_get_data(array('owner_uid'=>$this->uid));
            if ($shop) {
                $this->shop = $shop;
                $this->shop_id = $shop['shop_id'];

                if ($this->shop['auth_status'] == 'PENDING'){
                    $this->showSuccess('shop_is_pending', null, array(
                        array('text'=>'go_back', 'url'=>U('m=openshop&c=index')),
                        array('text'=>'go_home', 'url'=>U('/'))
                    ));
                }
            }else {
                $this->redirect(U('m=openshop&c=index'));
            }
        }
    }
}