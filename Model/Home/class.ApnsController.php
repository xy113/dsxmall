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
        $notice = new ApnsOrderActivityNotification();
        $notice->setText('你的订单已发货');
        $notice->setOrder_id("139");
        $notice->setBadge(5);

//        $notice = new ApnsNotification();
//        $notice->setText("APP已出新版本，请及时更新");

        $push = new ApnsPush(1);
        $push->setDeviceToken('39010d99134a5187a0900f7c1cfcf17a807e48686fea085b2d5241c8fe6cafc4');
        $push->send($notice);
    }
}