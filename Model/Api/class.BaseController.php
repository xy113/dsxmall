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

    protected function checkToken($uid, $token){
        $data = member_get_token($uid);
        if ($data['token'] !== $token) {
            $this->showAjaxError('1002', 'invalid_token');
        }
    }
}