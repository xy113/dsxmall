<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/5
 * Time: 上午10:21
 */
namespace Model\Api;
use Core\Controller;

class BaseController extends Controller{
    /**
     * BaseController constructor.
     */
    function __construct()
    {
        parent::__construct();
        $uid = intval($_GET['uid']);
        $token = trim($_GET['token']);

        !$uid && $uid = $this->uid;
        if (!$uid) $this->showAjaxError('FAIL', L('invalid_user_id'));
        if (!$token || $token !== md5($uid.formhash())){
            $this->showAjaxError('FAIL', L('invalid_token'));
        }else {
            $this->uid = $uid;
        }
    }
}