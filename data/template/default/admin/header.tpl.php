<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>后台管理中心-<?php echo $_G[title];?></title>
    <meta name="keywords" content="<?php echo $_G[keywords];?>">
    <meta name="description" content="<?php echo $_G[description];?>">
    <meta name="render" content="webkit">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="icon" href="/static/images/common/favicon.ico">
    <link rel="stylesheet" type="text/css" href="/static/css/admin.css">
    <script src="/static/js/jquery.js" type="text/javascript"></script>
    <script src="/static/js/common.js" type="text/javascript"></script>
    <script src="/static/js/jquery.form.js" type="text/javascript"></script>
    <script src="/static/js/jquery.dsxui.js" type="text/javascript"></script>
    <script src="/static/js/pace.min.js" type="text/javascript"></script>
    <script>var myData = <?php echo json_encode($this->member); ?>;</script>
</head>
<body>
<div class="mcenter-header">
    <div class="header">
        <strong class="logo">后台管理中心</strong>
        <div class="right-menu">
            <a href="<?php echo U('m=admin&c=logout'); ?>">退出登录</a>
        </div>
    </div>
</div>
<div class="sidebar" id="sidebar">
    <div class="sidebar-content">
        <div class="scroll">
            <div class="menus" id="side-menu">
                <dl>
                    <dd><a><i class="icon">&#xf013e;</i>系统设置</a></dd>
                    <dt>
                    <ul>
                        <li><a rel="item" href="<?php echo U('c=setting&a=basic'); ?>"<?php if($_GET[menu]=="setting_basic") { ?> class="cur"<?php } ?>>基本设置</a></li>
                        <li><a rel="item" href="<?php echo U('c=setting&a=optimiz'); ?>"<?php if($_GET[menu]=="setting_optimiz") { ?> class="cur"<?php } ?>>优化设置</a></li>
                        <li><a rel="item" href="<?php echo U('c=setting&a=register'); ?>"<?php if($_GET[menu]=="setting_register") { ?> class="cur"<?php } ?>>注册设置</a></li>
                        <li><a rel="item" href="<?php echo U('c=setting&a=attach'); ?>"<?php if($_GET[menu]=="setting_attach") { ?> class="cur"<?php } ?>>附件设置</a></li>
                        <li><a rel="item" href="<?php echo U('c=setting&a=water'); ?>"<?php if($_GET[menu]=="setting_water") { ?> class="cur"<?php } ?>>图片水印</a></li>
                    </ul>
                    </dt>
                </dl>
                <dl>
                    <dd><a><i class="icon">&#xf012d;</i>用户管理</a></dd>
                    <dt>
                    <ul>
                        <li><a rel="item" href="<?php echo U('c=member&a=memberlist'); ?>"<?php if($_GET[menu]=="memberlist") { ?> class="cur"<?php } ?>>会员列表</a></li>
                        <li><a rel="item" href="<?php echo U('c=member&a=grouplist'); ?>"<?php if($_GET[menu]=="membergroup") { ?> class="cur"<?php } ?>>分组管理</a></li>
                    </ul>
                    </dt>
                </dl>
                <dl>
                    <dd><a><i class="icon">&#xf00b9;</i>界面管理</a></dd>
                    <dt>
                        <ul>
                            <li><a rel="item" href="<?php echo U('c=menu'); ?>"<?php if($_GET[menu]=="menu") { ?> class="cur"<?php } ?>>菜单管理</a></li>
                            <li><a rel="item" href="<?php echo U('c=ad'); ?>"<?php if($_GET[menu]=="ad") { ?> class="cur"<?php } ?>>广告管理</a></li>
                        </ul>
                    </dt>
                </dl>
                <dl>
                    <dd><a><i class="icon">&#xf0130;</i>文章管理</a></dd>
                    <dt>
                        <ul>
                            <li><a rel="item" href="<?php echo U('c=post&a=add'); ?>"<?php if($_GET[menu]=="add_article") { ?> class="cur"<?php } ?>>发布文章</a></li>
                            <li><a rel="item" href="<?php echo U('c=post&a=itemlist'); ?>"<?php if($_GET[menu]=="article_list") { ?> class="cur"<?php } ?>>文章列表</a></li>
                            <li><a rel="item" href="<?php echo U('c=postcat&a=itemlist'); ?>"<?php if($_GET[menu]=="article_cat") { ?> class="cur"<?php } ?>>分类管理</a></li>
                            <li><a rel="item" href="<?php echo U('c=postcat&a=merge'); ?>"<?php if($_GET[menu]=="merge_article") { ?> class="cur"<?php } ?>>合并分类</a></li>
                        </ul>
                    </dt>
                </dl>

                <dl>
                    <dd><a><i class="icon">&#xf0132;</i>微信设置</a></dd>
                    <dt>
                    <ul>
                        <li><a rel="item" href="<?php echo U('c=setting&a=weixin'); ?>"<?php if($_GET[menu]=="setting_weixin") { ?> class="cur"<?php } ?>>参数设置</a></li>
                        <li><a rel="item" href="<?php echo U('c=wxmenu'); ?>"<?php if($_GET[menu]=="wxmenu") { ?> class="cur"<?php } ?>>菜单设置</a></li>
                        <li><a rel="item" href="<?php echo U('c=wxmaterial'); ?>"<?php if($_GET[menu]=="wxmaterial") { ?> class="cur"<?php } ?>>素材管理</a></li>
                        <li><a rel="item" href="<?php echo U('c=wxnews'); ?>"<?php if($_GET[menu]=="wxnews") { ?> class="cur"<?php } ?>>图文消息</a></li>
                    </ul>
                    </dt>
                </dl>

                <dl>
                    <dd><a><i class="icon">&#xf006e;</i>财务管理</a></dd>
                    <dt>
                    <ul>
                        <li><a rel="item" href="<?php echo U('c=trade&a=itemlist'); ?>"<?php if($_GET[menu]=="trade") { ?> class="cur"<?php } ?>>交易记录</a></li>
                        <li><a rel="item" href="<?php echo U('c=order&a=itemlist'); ?>"<?php if($_GET[menu]=="order") { ?> class="cur"<?php } ?>>订单记录</a></li>
                    </ul>
                    </dt>
                </dl>

                <dl>
                    <dd><a><i class="icon">&#xf01ba;</i>页面管理</a></dd>
                    <dt>
                    <ul>
                        <li><a rel="item" href="<?php echo U('c=page&a=add'); ?>"<?php if($_GET[menu]=="page_add") { ?> class="cur"<?php } ?>>新建页面</a></li>
                        <li><a rel="item" href="<?php echo U('c=page&a=itemlist'); ?>"<?php if($_GET[menu]=="page_list") { ?> class="cur"<?php } ?>>页面列表</a></li>
                        <li><a rel="item" href="<?php echo U('c=page&a=category'); ?>"<?php if($_GET[menu]=="page_cat") { ?> class="cur"<?php } ?>>页面分类</a></li>
                    </ul>
                    </dt>
                </dl>

                <dl>
                    <dd><a><i class="icon">&#xf0034;</i>其他项目</a></dd>
                    <dt>
                    <ul>
                        <li><a rel="item" href="<?php echo U('c=material'); ?>"<?php if($_GET[menu]=="material") { ?> class="cur"<?php } ?>>素材管理</a></li>
                        <li><a rel="item" href="<?php echo U('c=district'); ?>"<?php if($_GET[menu]=="district") { ?> class="cur"<?php } ?>>地区管理</a></li>
                        <li><a rel="item" href="<?php echo U('c=link'); ?>"<?php if($_GET[menu]=="link") { ?> class="cur"<?php } ?>>友情链接</a></li>
                    </ul>
                    </dt>
                </dl>
            </div>
        </div>
    </div>
</div>
<div class="mainframe">
    <div class="main-content">