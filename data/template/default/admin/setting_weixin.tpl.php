<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="console-title">
  <h2>系统设置->微信设置</h2>
</div>
<div class="content-div">
<form method="post" id="settingForm" action="<?php echo U('a=save'); ?>">
<input type="hidden" name="formsubmit" value="yes">
<input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>">
<table class="formtable" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody id="weixin">
<tr>
  <td class="cell-name" width="140">公众号APPID:</td>
  <td width="320"><input name="settingnew[wx_appid]" class="input-text w300" value="<?php echo $setting[wx_appid];?>" type="text"></td>
  <td>微信公众号appID</td>
</tr>
<tr>
  <td class="cell-name">公众号APPSECRET:</td>
  <td><input name="settingnew[wx_appsecret]" class="input-text w300" value="<?php echo $setting[wx_appsecret];?>" type="text"></td>
  <td>微信公众号appSecret</td>
</tr>
<tr>
  <td class="cell-name">微信支付商户号:</td>
  <td><input name="settingnew[wx_mch_id]" class="input-text w300" value="<?php echo $setting[wx_mch_id];?>"></td>
  <td>微信支付商户ID</td>
</tr>
<tr>
  <td class="cell-name">微信支付API安全秘钥:</td>
  <td><input name="settingnew[wx_mch_key]" class="input-text w300" value="<?php echo $setting[wx_mch_key];?>"></td>
  <td>微信支付API安全秘钥，不超过32位</td>
</tr>
<tr>
  <td class="cell-name">被关注自动回复:</td>
  <td>
   		<label><input type="radio" name="settingnew[wx_subscribe_msgtype]" value="1"<?php if($setting[wx_subscribe_msgtype]==1) { ?> checked<?php } ?>> 文字消息</label>
        <label><input type="radio" name="settingnew[wx_subscribe_msgtype]" value="2"<?php if($setting[wx_subscribe_msgtype]==2) { ?> checked<?php } ?>> 图文消息</label>
  </td>
  <td>自动回复</td>
</tr>
<tr>
  <td class="cell-name">被关注自动回复内容:</td>
  <td><textarea name="settingnew[wx_subscribe_message]" class="textarea w300"><?php echo $setting[wx_subscribe_message];?></textarea></td>
  <td>公众号被关注时自动回复的内容，若为图文消息请填写素材的media_id</td>
</tr>
</tbody>
<tfoot>
  <tr>
    <td></td>
    <td colspan="2"><input class="button submit" value="更新配置" type="submit"></td>
  </tr>
</tfoot>
</table>
</form>
</div><?php include template('footer'); ?>