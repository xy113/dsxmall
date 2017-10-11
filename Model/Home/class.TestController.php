<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午11:43
 */

namespace Model\Home;


use Data\Item\Builder\ItemContentBuilder;
use Data\Item\ItemModel;
use WxApi\Builder\WxCustomImageMessageBuilder;
use WxApi\Builder\WxCustomMpnewsMessageBuilder;
use WxApi\Builder\WxCustomNewsMessageBuilder;
use WxApi\Builder\WxCustomTextMessageBuilder;
use WxApi\WxCustomMessageApi;

class TestController extends BaseController
{
    /**
     *
     */
    public function index(){
        $message = new WxCustomNewsMessageBuilder();
        $message->setTouser('olcZvxNn-5BbnaZoQGKjGpUg0sUY');
        $message->addArticle('111', '测试消息1', 'http://cg.liaidi.com/', 'http://cg.liaidi.com/data/attachment/image/photo/2017/09/20170921174246767340.jpg');
        $message->addArticle('222', '测试消息2', 'http://cg.liaidi.com/', 'http://cg.liaidi.com/data/attachment/image/photo/2017/09/20170921174200353329.jpg');

        $api = new WxCustomMessageApi();
        echo $api->sendMessage($message);
    }
}