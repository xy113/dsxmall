<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $G[title];?></title>
<meta name="keywords" content="<?php echo $G[keywords];?>">
<meta name="description" content="<?php echo $G[description];?>">
<link rel="icon" href="/static/images/common/favicon.ico">
<link rel="stylesheet" type="text/css" href="/static/css/common.css">
<link rel="stylesheet" type="text/css" href="/static/css/member.css">
<script src="/static/js/jquery.js" type="text/javascript"></script>
<script src="/static/js/common.js" type="text/javascript"></script>
<script src="/static/js/jquery.form.js" type="text/javascript"></script>
<script src="/static/js/jquery.dsxui.js" type="text/javascript"></script>
</head>
<body style="background:url(http://service.dsxcms.com/background.php?<?php echo TIMESTAMP;?>);">
<div class="topbar">
	<div class="area">
    	<div class="menu f-right">
        	<?php if($G[islogined]) { ?>
            <a href="/?m=account"><?php echo $G[username];?></a>
            <a href="/?m=member&c=logout">安全退出</a>
            <?php if($G[member][admincp]) { ?><a href="/?m=admin">后台管理</a><?php } ?>
            <?php } else { ?>
            <a href="/?m=member&c=login">登录</a>
            <a href="/?m=member&c=register">注册</a>
            <?php } ?>
            <a href="/?m=account&c=favorite">我的收藏</a>
        </div>
        <div><a href="/">网站首页</a></div>
    </div>
</div>