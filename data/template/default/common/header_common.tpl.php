<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?php echo $_G[title];?></title>
    <meta name="keywords" content="<?php echo $_G[keywords];?>">
    <meta name="description" content="<?php echo $_G[description];?>">
    <link rel="icon" href="/static/images/common/favicon.ico">
    <link rel="stylesheet" type="text/css" href="/static/css/style_cg.css?<?php echo TIMESTAMP; ?>">
    <script src="/static/js/jquery.js" type="text/javascript"></script>
    <script src="/static/js/common.js" type="text/javascript"></script>
    <script src="/static/js/jquery.form.js" type="text/javascript"></script>
    <script src="/static/js/jquery.dsxui.js" type="text/javascript"></script>
    <script src="/static/js/jquery-ui.min.js" type="text/javascript"></script>
    <script src="/static/js/swiper.jquery.min.js" type="text/javascript"></script>
</head>
<body>
<div class="header">
    <div class="top">
        <div class="area">
            Hi 欢迎回来
            <a href="<?php echo U('m=account&c=login'); ?>">[登录]</a>
            <a href="<?php echo U('m=account&c=register'); ?>">[免费注册]</a>
        </div>
    </div>
    
    <div class="area banner">
        <div class="global-logo">
            <img src="/static/images/cugeng/global-logo.png">
        </div>
        <div class="global-search-box">
            <div class="input-box">
                <input type="text" class="text" placeholder="商品名称">
                <input type="submit" class="btn" value="搜索">
            </div>
            <div class="hot">热门搜索:花菜、胡萝卜、五花肉</div>
        </div>
        <div class="phone">
            <span>订购热线</span>
            <i class="phone-num">0858-12345678</i>
        </div>
    </div>
</div>

<div class="global-nav">
    <div class="nav">
        <div class="cat">商品分类</div>
        <ul>
            <li><a class="cur">首页</a></li>
            <li><a>营养餐</a></li>
            <li><a>企业店铺</a></li>
            <li><a>我的订单</a></li>
        </ul>
        <div class="cart">
            <div class="icon-cart"></div>
            <span>购物车0件</span>
            <strong>去结算>></strong>
        </div>
    </div>
</div>