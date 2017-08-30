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
    protected $verifyToken = true;
    /**
     * BaseController constructor.
     */
    function __construct()
    {
        parent::__construct();
        if ($this->verifyToken) {
            $uid = intval($_GET['uid']);
            $token = trim($_GET['token']);
            //$this->showAjaxReturn(cache('token_'.md5($uid)));
            $this->checkToken($uid, $token);
        }
    }

    /**
     * 验证客户端token
     * @param $uid
     * @param $token
     */
    protected function checkToken($uid, $token){
        $token_data = cache('token_'.md5($uid));
        if (!$token_data || !is_array($token_data)){
            $token_data = member_get_token($uid);
        }
        if ($token_data['token'] !== $token){
            $this->showAjaxError('1001', 'invalid_token');
        }else {
            $this->uid = $token_data['uid'];
            $this->username = $token_data['username'];
        }
    }
}