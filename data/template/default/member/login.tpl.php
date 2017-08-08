<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="area main-body-div">
	<div class="sign-box-div">
		<h3>快速登录</h3>
        <div class="sign-content">
        	<form method="post" action="<?php echo U('m=member&c=login'); ?>" id="loginForm" autocomplete="off">
    		<input type="hidden" name="formsubmit" value="yes">
    		<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
            <div class="err-tips" id="err-tips"></div>
        	<div class="input-div">
            	<div class="ico-box"><i class="icon">&#xf012d;</i></div>
                <div class="input-box"><input type="text" class="text" name="account_<?php echo FORMHASH;?>" placeholder="用户名/手机号/邮箱"></div>
            </div>
            <div class="input-div">
            	<div class="ico-box"><i class="icon">&#xf00c9;</i></div>
                <div class="input-box"><input type="password" class="text" name="password_<?php echo FORMHASH;?>" placeholder="密码" maxlength="20"></div>
            </div>
            <div class="input-div">
            	<div class="ico-box"><i class="icon">&#xf00b0;</i></div>
                <div class="input-box">
                	<input type="text" name="captchacode" class="text" placeholder="验证码" maxlength="4">
                    <img src="/?m=common&c=captcha" onclick="this.src='/?m=common&c=captcha&'+Math.random()" title="点击更换图片" class="captcha">
                </div>
            </div>
            <div class="sign-button-div"><button type="submit" class="sign-button">登录</button></div>
            <div class="sign-link">
            	<span><a href="">忘记密码?</a></span>
                <a href="/?m=member&c=register">注册新账号</a>
            </div>
            </form>
        </div>
	</div>
</div>
<script type="text/javascript">
$("#loginForm").submit(function(e) {
	var account = $(this).find("[name=account_<?php echo FORMHASH;?>]").val();
	if(!DSXUtil.IsUserName(account) && !DSXUtil.IsMobile(account) && !DSXUtil.IsEmail(account)){
		$("#err-tips").text('<?php echo $lang[account_incorrect];?>').show();
		return false;
	}
	var password = $(this).find("[name=password_<?php echo FORMHASH;?>]").val();
	if(!DSXUtil.IsPassword(password)){
		$("#err-tips").text('<?php echo $lang[password_incorrect];?>').show();
		return false;
	}
	var captcha = $(this).find("[name=captchacode]").val();
	if(captcha.length != 4){
		$("#err-tips").text('<?php echo $lang[captchacode_incorrect];?>').show();
		return false;
	}
	$.ajax({
		type:'POST',
		url:"<?php echo U('m=member&c=login&inajax=1'); ?>",
		async:false,
		dataType:"json",
		data:$("#loginForm").serializeArray(),
		success: function(json){
			if(json.errcode == 0){
				window.location = window.location.href;
			}else {
				$(".captcha").attr('src','/?m=common&c=captcha&'+Math.random());
				$("#err-tips").text(json.errmsg).show();
			}
		}
	});
    return false;
});
</script><?php include template('footer'); ?>