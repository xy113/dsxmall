<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="area main-body-div">
	<div class="sign-box-div">
		<h3>快速注册</h3>
        <div class="sign-content">
        	<form method="post" action="<?php echo U('m=member&c=register'); ?>" id="registerForm" autocomplete="off">
    		<input type="hidden" name="formsubmit" value="yes">
    		<input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>">
            <div class="err-tips" id="err-tips"></div>
        	<div class="input-div">
            	<div class="ico-box"><i class="icon">&#xf012d;</i></div>
                <div class="input-box"><input type="text" class="text" name="username_<?php echo FORMHASH; ?>" placeholder="昵称,中文字母数字或下划线"></div>
            </div>
            <div class="input-div">
            	<div class="ico-box"><i class="icon">&#xf00a2;</i></div>
                <div class="input-box"><input type="text" class="text" name="mobile_<?php echo FORMHASH; ?>" placeholder="手机号,11位有效号码"></div>
            </div>
            <div class="input-div">
            	<div class="ico-box"><i class="icon">&#xf00c9;</i></div>
                <div class="input-box"><input type="password" class="text" name="password_<?php echo FORMHASH; ?>" placeholder="密码,6-20位"></div>
            </div>
            <div class="input-div">
            	<div class="ico-box"><i class="icon">&#xf00b0;</i></div>
                <div class="input-box">
                	<input type="text" name="captchacode" class="text" placeholder="验证码">
                    <img src="/?m=common&c=captcha" onclick="this.src='/?m=common&c=captcha&'+Math.random()" title="点击更换图片" class="captcha">
                </div>
            </div>
            <div class="sign-button-div"><button type="submit" class="sign-button">注册</button></div>
            <div class="sign-link" style="text-align:center;">
                <a href="/?m=member&c=login">已有账号, 点此登录</a>
            </div>
            </form>
        </div>
	</div>
</div>
<script type="text/javascript">
$("#registerForm").submit(function(e) {
	var username = $(this).find("[name=username_<?php echo FORMHASH; ?>]").val();
	var mobile   = $(this).find("[name=mobile_<?php echo FORMHASH; ?>]").val();
	var password = $(this).find("[name=password_<?php echo FORMHASH; ?>]").val();
	if(!DSXUtil.IsUserName(username)){
		$("#err-tips").text('<?php echo $lang[username_incorrect];?>').show();
		return false;
	}
	if(!DSXUtil.IsMobile(mobile)){
		$("#err-tips").text('<?php echo $lang[mobile_incorrect];?>').show();
		return false;
	}
	if(!DSXUtil.IsPassword(password)){
		$("#err-tips").text('<?php echo $lang[password_incorrect];?>').show();
		return false;
	}
	var checkflag = true;
	$.ajax({
		url:"{url 'a=checkusername'}",
		data:{username:username},
		dataType:"json",
		async:false,
		success: function(json){
			if(json.errno != 0){
				checkflag = false;
			}
		}
	});
	var captcha = $(this).find("[name=captchacode]").val();
	if(captcha.length != 4){
		$("#err-tips").text('<?php echo $lang[captchacode_incorrect];?>').show();
		return false;
	}
	if(!checkflag){
		$("#err-tips").text('<?php echo $lang[username_be_occupied];?>').show();
		return false;
	}
	$.ajax({
		url:"{url 'a=checkmobile'}",
		data:{mobile:mobile},
		dataType:"json",
		async:false,
		success: function(json){
			if(json.errno != 0){
				checkflag = false;
			}
		}
	});
	if(!checkflag){
		$("#err-tips").text('<?php echo $lang[mobile_be_occupied];?>').show();
		return false;
	}
    return true;
});
</script><?php include template('footer'); ?>