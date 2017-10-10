<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>大师兄内容管理系统管理中心</title>
<style type="text/css">
body {padding:0; margin:0; font:12px Arial; background-color:#CCC; background-size:cover; position:relative;}
a:link,a:active,a:visited{color:#333333; text-decoration:none;}
a:hover{color:#FF0000; text-decoration:underline;}
.login-wrap{background:#fff; border-radius:5px; margin:100px auto; width:400px; box-shadow:0 3px 5px #333;}
.login-wrap .title{font-size:20px; margin:0 0 10px 0; padding:20px 0; text-align:center; border-radius:5px 5px 0 0; border-bottom:1px #eee solid;}
.login-wrap .item{padding:15px 0; text-align:center;}
.login-wrap .input-text{font-size:14px; width:260px; padding:5px 0; border-radius:2px; height:40px; line-height:40px; text-align:center; box-sizing:border-box; border-width:1px; border:1px #CCC solid;}
.login-wrap .input-text:hover{border-color:#09C; background-color:#f9f9f9;}
.login-wrap .button{width:270px; height:40px; line-height:40px; margin-bottom:20px; cursor:pointer; font-size:16px; font-weight:bold; background:#C30; border-radius:3px; color:#fff; text-align:center; display:inline-block; box-sizing:border-box;}
.login-wrap .button:hover{background:#C03;}
.login-wrap .err{color:#F00; text-align:center; font-size:12px; display:none;}
.copyright{position:fixed; bottom:30px; width:100%; display:block; text-align:center;}
.copyright,.copyright *,.copyright a{font:400 12px Arial; color:#fff;}
</style>
<script src="/static/js/jquery.js" type="text/javascript"></script>
<script src="/static/js/common.js" type="text/javascript"></script>
<link rel="icon" href="/static/images/common/favicon.png" />
</head>
<body style="background:url(http://service.dsxcms.com/background.php);">
<div class="login-wrap">
	<form method="post" id="formlogin" action="<?php echo U('c=login'); ?>">
    <input type="hidden" name="formsubmit" value="yes">
    <input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>">
	<h1 class="title">DSXMALL后台管理中心</h1>
    <div class="err" id="err"></div>
    <div class="item"><input type="text" name="account_<?php echo FORMHASH; ?>" class="input-text" value="<?php echo $_G[username];?>" placeholder="用户名/手机号/邮箱"></div>
    <div class="item"><input type="password" name="password_<?php echo FORMHASH; ?>" class="input-text" placeholder="密码"></div>
    <div class="item"><div class="button" tabindex="1" id="button-login">登录</div></div>
    </form>
</div>
<script type="text/javascript">
(function(){
	var form = $("#formlogin");
	function submitLogin(){
		var password = form.find("input[name=password_<?php echo FORMHASH; ?>]").val();
		if(DSXValidate.IsPassword(password)){
			form.ajaxSubmit({
				dataType:'json',
				success:function(json){
					if(json.errcode === 0){
						DSXUtil.reFresh();
					}else{
						$("#err").text('<?php echo $_lang[password_incorrect];?>').show();
					}
				}
			});
		}else {
			$("#err").text('<?php echo $lang[password_incorrect];?>').show();
		}
	}
	form.find("input").blur(function(e) {
        $("#err").empty().hide();
    }).keydown(function(e) {
        if(e.which === 13){
			submitLogin();
		}
    });
	$("#button-login").click(function(e) {
        return submitLogin();
    });
})();
</script>
<p class="copyright">&copy;2015 <a href="http://www.songdewei.com" target="_blank">贵州大师兄信息技术有限公司</a> 版权所有，并保留所有权利。</p>
</body>
</html>