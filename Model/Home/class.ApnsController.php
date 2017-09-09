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
     *
     */
    public function index(){
//        $notice = new ApnsOrderActivityNotification();
//        $notice->setText('你的订单已发货');
//        $notice->setOrder_id("139");
//        $notice->setBadge(5);

        $notice = new ApnsNotification();
        $notice->setText("粗耕已出新版本，请及时更新");

        $push = new ApnsPush(0);
        $push->setDeviceToken('58cc6c5435a794762bd7b3ebcdfbe3f7371e435b49a63b553c438e9402bcca28');
        $push->send($notice);
    }
}