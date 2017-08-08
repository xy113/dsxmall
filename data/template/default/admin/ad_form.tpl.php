<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><script src="/static/DatePicker/WdatePicker.js" type="text/javascript"></script>
<div class="console-title">
	<a href="<?php echo U('a=itemlist'); ?>" class="submit f-right">返回列表</a>
    <h2>添加广告</h2>
</div>
<div class="area">
<form method="post" enctype="multipart/form-data" onSubmit="return checkSubmit();">
<input type="hidden" name="formsubmit" value="yes">
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
<tbody>
<tr><th colspan="2">广告名称</th></tr>
<tr>
  <td width="320"><input type="text" class="input-text w300" name="adnew[title]" value="<?php echo $ad[title];?>" id="title"></td>
  <td class="tips">区分不同广告位的名称</td>
</tr>
<tr><th colspan="2">开始时间</th></tr>
<tr>
  <td><input type="text" class="input-text w300" name="adnew[starttime]" value="<?php echo $ad[starttime];?>" onclick="WdatePicker()"></td>
  <td class="tips">广告开始有效时间</td>
</tr>
<tr><th colspan="2">结束时间</th></tr>
<tr>
  <td><input type="text" class="input-text w300" name="adnew[endtime]" value="<?php echo $ad[endtime];?>" onclick="WdatePicker()"></td>
  <td class="tips">广告失效时间</td>
</tr>
<tr><th colspan="2">广告类型</th></tr>
<tr>
  <td>
      <select name="adnew[type]" class="w300" onChange="changeType(this.value)">
          <?php if(is_array($lang[ad_types])) { foreach($lang[ad_types] as $k => $v) { ?>          <option value="<?php echo $k;?>"<?php if($ad[type]==$k) { ?> selected<?php } ?>><?php echo $v;?></option>
          <?php } } ?>      </select>
  </td>
  <td class="tips"></td>
</tr>
</tbody>
<tbody id="adtext" class="adtype" style="display:none;">
    <tr><th colspan="2">文字</th></tr>
    <tr>
      <td><input type="text" class="input-text w300" name="addata[text][text]" value="<?php echo $addata[text][text];?>"></td>
      <td class="tips"></td>
    </tr>
    <tr><th colspan="2">链接</th></tr>
    <tr>
      <td><input type="text" class="input-text w300" name="addata[text][link]" value="<?php echo $addata[text][link];?>"></td>
      <td class="tips"></td>
    </tr>
</tbody>
<tbody id="adimage" class="adtype" style="display:none;">
    <tr><th colspan="2">图片</th></tr>
    <tr>
      <td>
          <?php if($addata[image][image]) { ?>
          <p><img src="<?php echo $addata[image][image];?>" style="width:100%; display:block;"></p>
          <?php } ?>
          <input type="file" name="filedata">
          <input type="hidden" name="addata[image][image]" value="<?php echo $addata[image][image];?>">
      </td>
      <td class="tips">上传新图片将会替换原有图片</td>
    </tr>
    <tr><th colspan="2">宽度(可选)</th></tr>
    <tr>
      <td><input type="text" class="input-text w300" name="addata[image][width]" value="<?php echo $addata[image][width];?>"></td>
      <td class="tips">图片显示宽度</td>
    </tr>
    <tr><th colspan="2">高度(可选)</th></tr>
    <tr>
      <td><input type="text" class="input-text w300" name="addata[image][height]" value="<?php echo $addata[image][height];?>"></td>
      <td class="tips">图片显示高度</td>
    </tr>
    <tr><th colspan="2">链接</th></tr>
    <tr>
      <td><input type="text" class="input-text w300" name="addata[image][link]" value="<?php echo $addata[image][link];?>"></td>
      <td class="tips">图片链接</td>
    </tr>
</tbody>
<tbody id="adcode" class="adtype" style="display:none;">
    <tr><th colspan="2">广告代码</th></tr>
    <tr>
      <td><textarea class="textarea w300" name="addata[code]"><?php echo $addata[code];?></textarea></td>
      <td class="tips">广告HTML代码</td>
    </tr>
</tbody>
<tfoot>
<tr>
  <td colspan="2">
      <input type="submit" class="button" value="提交">
      <input type="button" class="button cancel" value="刷新" onclick="window.location.reload()">
  </td>
</tr>
</tfoot>
</table>
</form>
</div>
<script type="text/javascript">
changeType('<?php echo $ad[type];?>');
function changeType(type){
	if(!type) type = 'text';
	$(".adtype").hide();
	$("#ad"+type).show();
}
function checkSubmit(){
	if(!$("#title").val()){
		alert('标题不能为空');
		return false;
	}
	return true;
}
</script><?php include template('footer'); ?>