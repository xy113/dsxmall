<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/1
 * Time: 上午10:52
 */
namespace Model\Openshop;
use Core\Controller;

class BaseController extends Controller{
    protected $myshop = array();
    /**
     * BaseController constructor.
     */
    function __construct()
    {
        parent::__construct();
        if (!$this->isLogin()){
            member_show_login();
        }else {
            $this->myshop = shop_get_data(array('owner_uid'=>$this->uid));
            if ($this->myshop) {
                if ($this->myshop['auth_status'] == 'SUCCESS'){
                    //$this->redirect(U('m=seller&c=index'));
                }
                //print_r($this->myshop);exit();
                if ($this->myshop['auth_status'] == 'PENDING'){
                    $this->showSuccess('shop_is_pending', null, array(
                        array('text'=>'go_back', 'url'=>U('m=openshop&c=index')),
                        array('text'=>'go_home', 'url'=>U('/'))
                    ));
                }
            }
        }
    }
}