<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="toolbar">
	<ul class="tab">
    	<li class="on"><a href="/?m=<?php echo $G[m];?>&c=<?php echo $G[c];?>&a=userinfo">基本信息</a></li>       
        <li><a href="/?m=<?php echo $G[m];?>&c=<?php echo $G[c];?>&a=security">安全设置</a></li>
        <li><a href="/?m=<?php echo $G[m];?>&c=<?php echo $G[c];?>&a=verify">实名认证</a></li>
    </ul>  
</div>
<div class="blank"></div>
<div class="avatar-div">
	<form method="post" enctype="multipart/form-data" id="upload-avatar-form" action="/?m=<?php echo $G[m];?>&c=<?php echo $G[c];?>&a=uploadavatar">
	<div class="avatar"><img id="avatar-image" src="<?php echo avatar($G[uid]); ?>"></div>
    <div class="avatar-content">
    	<a class="button upload-button">
    	<span>上传头像</span>
    	<input type="file" id="J-file" name="filedata">
        </a>
    </div>
    <div class="avatar-content">支持JPG,JPEG,GIF,PNG格式</div>
    </form>
</div>
<div class="userinfo-div">
	<form method="post" id="userinfoForm">
    <input type="hidden" name="formsubmit" value="yes">
    <input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>">
	<table width="100%" cellpadding="0" cellspacing="0" border="0" class="formtable">
    	<tr>
        	<td width="64">性别</td>
            <td>
            <?php if(is_array($lang[sex_items])) { foreach($lang[sex_items] as $k=>$v) { ?>            	<input type="radio" value="$k" name="userinfo[usersex]"<?php if($k==$userinfo[usersex]) { ?> checked="checked"<?php } ?><?php if($userinfo[locked]) { ?> disabled="disabled"<?php } ?>> $v
            <?php } } ?>            </td>
            <td width="40">生日</td>
            <td><input type="text" class="input-text" name="userinfo[birthday]" onclick="WdatePicker()" value="<?php echo $userinfo[birthday];?>" readonly></td>
        </tr>
        <tr>
        	<td>星座</td>
            <td>
            	<select class="input-select" name="userinfo[star]">
                  <?php if(is_array($lang[star_items])) { foreach($lang[star_items] as $k=>$v) { ?>                <option value="<?php echo $k;?>"<?php if($k==$userinfo[star]) { ?> selected="selected"<?php } ?>><?php echo $v;?></option>
                <?php } } ?>            	</select>
            </td>
            <td>血型</td>
            <td>
            	<select class="input-select" name="userinfo[blood]">
                <?php if(is_array($lang[blood_items])) { foreach($lang[blood_items] as $k=>$v) { ?>                <option value="<?php echo $k;?>"<?php if($k==$userinfo[blood]) { ?> selected="selected"<?php } ?>><?php echo $v;?></option>
                <?php } } ?>            	</select>
            </td>
        </tr>
        <tr>
        	<td>QQ</td>
            <td><input type="text" class="input-text" name="userinfo[qq]" value="<?php echo $userinfo[qq];?>"></td>
            <td>微信</td>
            <td><input type="text" class="input-text" name="userinfo[weixin]" value="<?php echo $userinfo[weixin];?>"></td>
        </tr>
        <tr>
        	<td>所在地</td>
            <td colspan="3">
            	  <select class="input-select dist select" id="province" name="userinfo[province]" style="width:auto;">
                    <option value="">请选择</option>
                  </select>
                  <select class="input-select dist select" id="city" name="userinfo[city]" style="width:auto;">
                      <option value="">请选择</option>
                  </select>
                  <select class="input-select dist select" id="county" name="userinfo[county]" style="width:auto;">
                      <option value="">请选择</option>
                  </select>
            </td>
        </tr>
        <tr>
        	<td>个人描述</td>
            <td colspan="3"><textarea name="userinfo[introduction]" class="textarea" draggable="false" style="width:500px; height:80px;"><?php echo $userinfo[introduction];?></textarea></td>
        </tr>
        <tr>
        	<td></td>
            <td colspan="3"><button type="button" class="button" id="update-info-button">更新资料</button></td>
        </tr>
    </table>
    </form>
</div>
<script type="text/javascript">
DSXUtil.bindDistrict("#province", 0, '<?php echo $userinfo[province];?>', '', function(province){
	DSXUtil.bindDistrict("#city", province, '<?php echo $userinfo[city];?>', '', function(city){
		DSXUtil.bindDistrict("#county", city, '<?php echo $userinfo[county];?>', '');
	});
});
$("#update-info-button").click(function(e) {
    $("#userinfoForm").ajaxSubmit({
		dataType:'json',
		success:function(json){
			if(json.errcode == 0){
				DSXUI.success('资料更新成功');
			}else {
				DSXUI.error(json.errmsg);
			}
		}
	});
});
$("#J-file").change(function(){
	var loading;
	$("#upload-avatar-form").ajaxSubmit({
		dataType:'json',
		beforeSend:function(){
			loading = DSXUI.showloading('照片上传中...');
		},
		success:function(json){
			if(json.errcode == 0){
				loading.close();
				$("#avatar-image").attr('src', json.data.avatar+'#'+Math.random());
			}
		}
	});
});
</script><?php include template('footer'); ?>