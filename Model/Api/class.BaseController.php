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
    protected $appid;
    protected $token;
    /**
     * BaseController constructor.
     */
    function __construct()
    {
        parent::__construct();
        $this->appid = trim($_GET['appid']);
        $this->token = trim($_GET['token']);
        if (!$this->appid || !$this->token) {
            $this->showAjaxError('1001', 'invalid_token');
        }else{
            $appconf = C('app_'.$this->appid);
            $check_token = md5($appconf['appid'].$appconf['appkey'].substr(time(), 0, 6));
            if ($check_token !== $this->token){
                $this->showAjaxError('1001', 'invalid_token');
            }
        }
    }
}