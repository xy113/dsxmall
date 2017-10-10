<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?php echo $_G[title];?></title>
    <meta name="keywords" content="<?php echo $_G[keywords];?>">
    <meta name="description" content="<?php echo $_G[description];?>">
    <link rel="icon" href="/static/images/common/favicon.png">
    <link rel="stylesheet" type="text/css" href="/static/css/member.css">
    <script src="/static/js/jquery.js" type="text/javascript"></script>
    <script src="/static/js/common.js" type="text/javascript"></script>
    <script src="/static/js/jquery.dsxui.js" type="text/javascript"></script>
</head>
<body><?php include template('top_common'); ?><div class="membercp-header">
    <div class="area header">
        <strong class="logo"><img src="/static/images/common/grzx_logo.png"></strong>
        <div class="right-menu">
            <a href="<?php echo U('/'); ?>">网站首页</a>
            <a href="<?php echo U('c=setting'); ?>">账户中心</a>
            <a href="<?php echo U('c=wallet'); ?>">财务中心</a>
            <a href="<?php echo U('m=seller&c=index'); ?>" target="_blank">我是卖家</a>
            <?php if($_G[member][admincp]) { ?><a href="<?php echo U('m=admin&c=index'); ?>">后台管理</a><?php } ?>
        </div>
    </div>
</div>
<div style="height: 30px; display: block; clear: both;"></div>
<div class="area">
<div class="sidebar">
    <div class="sidebar-content">
        <dl>
            <dd><a><i class="iconfont icon-formfill"></i><?php echo L(order_manage); ?></a></dd>
            <dt>
            <ul>
                <li><a href="<?php echo U('c=order'); ?>"<?php if($_G[menu]=="order_manage") { ?> class="cur"<?php } ?>>已买到的宝贝</a></li>
            </ul>
            </dt>
        </dl>

        <dl>
            <dd><a><i class="iconfont icon-peoplefill"></i>我的账户</a></dd>
            <dt>
            <ul>
                <li><a href="<?php echo U('c=setting&a=userinfo'); ?>"<?php if($_G[menu]=="userinfo") { ?> class="cur"<?php } ?>>账户设置</a></li>
                <li><a href="<?php echo U('c=setting&a=security'); ?>"<?php if($_G[menu]=="security") { ?> class="cur"<?php } ?>>安全中心</a></li>
                <li><a href="<?php echo U('c=wallet&a=index'); ?>"<?php if($_G[menu]=="wallet") { ?> class="cur"<?php } ?>>我的钱包</a></li>
                <li><a href="<?php echo U('c=address&a=index'); ?>"<?php if($_G[menu]=="address") { ?> class="cur"<?php } ?>>收货地址</a></li>
                <li><a href="<?php echo U('c=collection'); ?>"<?php if($_G[menu]=="collection") { ?> class="cur"<?php } ?>>我的收藏</a></li>
                <!--<li><a href="<?php echo U('c=comment'); ?>"<?php if($_G[menu]=="comment") { ?> class="cur"<?php } ?>>我的评论</a></li>-->
            </ul>
            </dt>
        </dl>
    </div>
</div>
<div class="mainframe">
    <div class="main-content">