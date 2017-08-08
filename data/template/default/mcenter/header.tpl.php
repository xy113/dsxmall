<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $G[title];?></title>
<meta name="keywords" content="<?php echo $G[keywords];?>">
<meta name="description" content="<?php echo $G[description];?>">
<link rel="icon" href="/static/images/common/favicon.ico">
<link rel="stylesheet" type="text/css" href="/static/css/common.css">
<link rel="stylesheet" type="text/css" href="/static/css/mcenter.css">
<script src="/static/js/jquery.js" type="text/javascript"></script>
<script src="/static/js/common.js" type="text/javascript"></script>
<script src="/static/js/jquery.form.js" type="text/javascript"></script>
<script src="/static/js/jquery.dsxui.js" type="text/javascript"></script>
</head>
<body>
<div class="mcenter-header">
	<div class="area">
    	<strong class="logo">个人中心</strong>
    	<div class="right-menu">
        	<a href="/">网站首页</a>
            <a href="/?m=<?php echo $G[m];?>&c=setting">账户中心</a>
            <a href="/?m=<?php echo $G[m];?>&c=wallet">财务中心</a>
            <a href="/?m=admin">后台管理</a>
        </div>
    </div>
</div>
<div class="area mcenter-body">
	<div class="sidebar">
    	<h3 class="sidebar-title"><a href="/?m=<?php echo $G[m];?>">个人中心</a></h3>
    	<div class="sidebar-content">
        	<dl>
            	<dd><a><i class="icon">&#xf01be;</i>订单管理</a></dd>
                <dt>
                	<ul>
                        <li><a href="/?m=<?php echo $G[m];?>&c=order" id="menu_order">已购项目</a></li>
                        <li><a href="/?m=<?php echo $G[m];?>&c=favorite" id="menu_favorite">我的收藏</a></li>
                        <li><a href="/?m=<?php echo $G[m];?>&c=comment" id="menu_comment">我的评论</a></li>
                    </ul>
                </dt>
            </dl>
            
        	<dl>
            	<dd><a><i class="icon">&#xf013e;</i>我的账户</a></dd>
                <dt>
                	<ul>
                        <li><a href="/?m=<?php echo $G[m];?>&c=setting&a=userinfo" id="menu_userinfo">账户设置</a></li>
                        <li><a href="/?m=<?php echo $G[m];?>&c=wallet" id="menu_wallet">我的钱包</a></li>
                        <li><a href="/?m=<?php echo $G[m];?>&c=score" id="menu_score">我的积分</a></li>
                        <li><a href="/?m=<?php echo $G[m];?>&c=setting&a=security" id="menu_headimg">安全中心</a></li>
                    </ul>
                </dt>
            </dl>
            <dl>
            	<dd><a><i class="icon">&#xf0130;</i>内容管理</a></dd>
                <dt>
                	<ul>
                        <li><a href="/?m=<?php echo $G[m];?>&c=post" id="menu_post">我的文章</a></li>
                        <li><a href="/?m=<?php echo $G[m];?>&c=ad" id="menu_wallet">我的广告</a></li>
                    </ul>
                </dt>
            </dl>
        </div>
    </div>
    
    <div class="mainframe">
    	<div class="main-content">