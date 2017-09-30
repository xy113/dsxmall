<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?php echo $_G[title];?></title>
    <meta name="keywords" content="<?php echo $_G[keywords];?>">
    <meta name="description" content="<?php echo $_G[description];?>">
    <meta name="render" content="webkit">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="icon" href="/static/images/common/favicon.png">
    <link rel="stylesheet" type="text/css" href="/static/css/style_cg.css">
    <script src="/static/js/jquery.js" type="text/javascript"></script>
    <script src="/static/js/common.js" type="text/javascript"></script>
    <script src="/static/js/angular.min.js" type="text/javascript"></script>
</head>
<body><?php include template('top_common'); ?><div class="header">
    <div class="area banner">
        <div class="global-logo">
            <img src="/static/images/cugeng/global-logo.png">
        </div>
        <div class="global-search-box">
            <form method="get" action="<?php echo U('/'); ?>">
                <input type="hidden" name="m" value="item">
                <input type="hidden" name="c" value="search">
                <div class="input-box">
                    <input type="text" class="text" placeholder="商品名称" name="q" value="<?php echo $q;?>">
                    <input type="submit" class="btn" value="搜索">
                </div>
            </form>
            <div class="hot">
                热门搜索:
                <a href="<?php echo U('m=item&c=search&q=花菜'); ?>">花菜</a>、
                <a href="<?php echo U('m=item&c=search&q=胡萝卜'); ?>">胡萝卜</a>、
                <a href="<?php echo U('m=item&c=search&q=五花肉'); ?>">五花肉</a>
            </div>
        </div>
        <ul class="apps">
            <li>
                <div class="pic showqrcode"><img src="/static/images/common/weixin_qrcode.jpg"></div>
                <p>在微信关注我们</p>
            </li>
            <li>
                <div class="pic showqrcode"><img src="/static/images/common/app_qrcode.jpg"></div>
                <p>下载粗耕APP</p>
            </li>
        </ul>
    </div>
</div>

<div class="global-nav">
    <div class="nav">
        <div class="cat"><span class="iconfont icon-sort"></span> 全部商品分类</div>
        <ul>
            <li><a href="<?php echo U('/'); ?>"<?php if($_G[nav]=="home") { ?> class="cur"<?php } ?>>首页</a></li>
            <li><a href="<?php echo U('m=item&c=search'); ?>"<?php if($_G[nav]=="item") { ?> class="cur"<?php } ?>>营养餐</a></li>
            <li><a href="<?php echo U('m=shop&c=index'); ?>"<?php if($_G[nav]=="shop") { ?> class="cur"<?php } ?>>企业店铺</a></li>
            <li><a href="<?php echo U('m=member&c=order&a=index'); ?>">我的订单</a></li>
        </ul>
        <div class="cart" id="nav-cart">
            <a href="<?php echo U('m=cart&c=index'); ?>">
            <span class="ico"></span>
            <span>购物车<?php echo cookie(cart_total_count); ?>件</span>
            <strong>去结算>></strong>
            </a>
        </div>
    </div>
</div>
