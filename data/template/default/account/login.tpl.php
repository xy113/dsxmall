<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>登录</title>
    <meta name="keywords" content="<?php echo $_G[keywords];?>">
    <meta name="description" content="<?php echo $_G[description];?>">
    <link rel="icon" href="/static/images/common/favicon.ico">
    <link rel="stylesheet" type="text/css" href="/static/css/account.css">
    <script src="/static/js/jquery.js" type="text/javascript"></script>
    <script src="/static/js/common.js" type="text/javascript"></script>
    <script src="/static/js/jquery.form.js" type="text/javascript"></script>
    <script src="/static/js/jquery.dsxui.js" type="text/javascript"></script>
</head>
<body><div class="area main-body-div">
    <div class="sign-in-map"></div>
    <div class="sign-in-div">
        <h3>快速登录</h3>
        <div class="sign-content">
            <form method="post" id="loginForm" autocomplete="off">
                <div class="err-tips" id="err-tips"></div>
                <div class="input-div">
                    <div class="ico-box"><i class="icon">&#xf012d;</i></div>
                    <div class="input-box"><input type="text" class="text" id="account" name="account_<?php echo FORMHASH; ?>" placeholder="用户名/手机号/邮箱"></div>
                </div>
                <div class="input-div">
                    <div class="ico-box"><i class="icon">&#xf00c9;</i></div>
                    <div class="input-box"><input type="password" class="text" id="password" name="password_<?php echo FORMHASH; ?>" placeholder="密码" maxlength="20"></div>
                </div>
                <div class="input-div">
                    <div class="ico-box"><i class="icon">&#xf00b0;</i></div>
                    <div class="input-box">
                        <input type="text" name="captchacode" class="text" id="captchacode" placeholder="验证码" maxlength="4">
                        <img src="/index.php?m=common&c=captcha" onclick="this.src='/index.php?m=common&c=captcha&'+Math.random()" title="看不清，换一张" class="captcha">
                    </div>
                </div>
                <div class="sign-button-div"><button type="submit" class="sign-button">登录</button></div>
                <div class="sign-link">
                    <span><a href="">忘记密码?</a></span>
                    <a href="/?m=account&c=register">新用户注册</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#loginForm").submit(function(e) {
        var account = $("#account").val();
        if(!DSXUtil.IsUserName(account) && !DSXUtil.IsMobile(account) && !DSXUtil.IsEmail(account)){
            $("#err-tips").text('账号输入错误').show();
            return false;
        }
        var password = $("#password").val();
        if(!DSXUtil.IsPassword(password)){
            $("#err-tips").text('密码错误').show();
            return false;
        }
        var captcha = $("#captchacode").val();
        if(captcha.length != 4){
            $("#err-tips").text('验证码错误').show();
            return false;
        }
        $.ajax({
            type:'POST',
            url:"/index.php?m=account&c=login&a=chklogin&inajax=1",
            async:false,
            dataType:"json",
            data:$("#loginForm").serializeArray(),
            success: function(json){
                if(json.errcode == 0){
                    DSXUtil.reFresh();
                }else {
                    $(".captcha").attr('src','/index.php?m=common&c=captcha&'+Math.random());
                    $("#err-tips").text(json.errmsg).show();
                }
            }
        });
        return false;
    });
</script>
<div class="footer" id="footer">
    <div class="area">
        <div class="bottomNav">
            <a href="/">网站首页</a>
            <span class="split">|</span>
            <a href="#">关于我们</a>
            <span class="split">|</span>
            <a href="#">联系方式</a>
            <span class="split">|</span>
            <a href="#">广告服务</a>
            <span class="split">|</span>
            <a href="#">法律援助</a>
            <span class="split">|</span>
            <a href="#">加入我们</a>
            <span class="split">|</span>
            <a href="#">支付方式</a>
            <span class="split">|</span>
            <a href="#">技术支持</a>
        </div>
        <div class="copyright">©2016 郎客你好版权所有   闽ICP备17008804号</div>
    </div>
</div>
</body>
</html>