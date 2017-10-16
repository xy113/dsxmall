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

        echo rawurlencode(curPageURL());
        header('location:'.U('/').rawurlencode(curPageURL()));
    }
}