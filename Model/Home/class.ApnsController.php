<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/3
 * Time: 上午1:00
 */

namespace Model\Home;


use Apns\ApnsNotification;
use Apns\ApnsOrderActivityNotification;
use Apns\ApnsPush;

class ApnsController extends BaseController
{
    /**
     * ApnsController constructor.
     */
    function __construct()
    {
        parent::__construct();
        $appkey = trim($_GET['appkey']);
        if ($appkey !== 'c3b15fb183388b2c2aedd9b18208346d'){
            $this->showAjaxReturn();
        }
    }

    /**
     *
     */
    public function index(){

    }

    /**
     *
     */
    public function sendNotice(){
        set_time_limit(0);
        ignore_user_abort(true);
        $limit = 0;
        $push = new ApnsPush();
        $lock = CACHE_PATH.'apns_update.lock';
        if (is_file($lock)){
            $this->showAjaxReturn();
        }else{
            touch($lock);
        }
        while (true){
            $token = M('apns_token')->order('id', 'ASC')->limit($limit,1)->getOne();
            if ($token){
                $notice = new ApnsNotification();
                $notice->setBadge(1);
                $notice->setAlert('粗耕已有新的版本，请前往App Store更新');

                $push->setDeviceToken($token['device_token']);
                $push->send($notice);
                $limit++;
            }else {
                @unlink($lock);
                $this->showAjaxReturn();
            }
            sleep(2);
        }
    }
}