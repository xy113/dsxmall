<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="console-title">
	<h2>链接管理</h2>
</div>
<div class="table-wrap">
<form method="post" action="">
<input type="hidden" name="formsubmit" value="yes" />
<input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
<thead>
    <tr>
      <th width="20">删?</th>
      <th width="40">图片</th>
      <th width="300">名称</th>
      <th width="60">显示顺序</th>
      <th>网址</th>
    </tr>
</thead><?php if(is_array($categorylist)) { foreach($categorylist as $cat) { ?><?php $catid=$cat[id]; ?><tbody id="tbcontent_$catid">
<tr>
  <td><input type="checkbox" class="checkbox checkmark" name="delete[]" value="<?php echo $catid;?>" /></td>
  <td colspan="2">
    <input type="text" class="input-text" name="linklist[$catid][title]" value="<?php echo $cat[title];?>" maxlength="10"> 
    <a href="javascript:;" onclick="addLink(<?php echo $catid;?>)"><i class="icon">&#xf0154;</i>添加链接</a>
  </td>
  <td colspan="2"><input type="text" class="input-text w60" name="linklist[$catid][displayorder]" value="<?php echo $cat[displayorder];?>" maxlength="4"></td>
</tr><?php if(is_array($linklist[$catid])) { foreach($linklist[$catid] as $id=>$link) { ?><tr>
  <td><input type="checkbox" class="checkbox checkmark" name="delete[]" value="<?php echo $id;?>" /></td>
  <td><img src="$link[image]" width="40" height="40" rel="setimage" data="{id:<?php echo $id;?>}"></td>
  <td><input type="text" class="input-text" name="linklist[$id][title]" value="<?php echo $link[title];?>" maxlength="10"></td>
  <td><input type="text" class="input-text w60" name="linklist[$id][displayorder]" value="<?php echo $link[displayorder];?>" maxlength="4"></td>
  <td><input type="text" class="input-text w300" name="linklist[$id][url]" value="<?php echo $link[url];?>"></td>
</tr><?php } } ?></tbody><?php } } ?><tbody id="tbclass"></tbody>
<tfoot>
<tr>
    <td colspan="5">
    <label><input type="checkbox" class="checkbox checkall" /> 全选</label>
    <a href="javascript:;" onclick="addClass()"><i class="icon">&#xf0154;</i>添加分类</a></td>
</tr>
<tr>
    <td colspan="5">
        <span class="pages"><?php echo $pages;?></span>
        <input type="submit" class="button" value="提交" />
        <input type="button" class="button button-cancel" value="刷新" onclick="window.location.reload()" />
    </td>
</tr>
</tfoot>
</table>
</form>
</div>
<script type="text/template" id="tplLink">
<tr>
<td><input type="hidden" name="linklist[#k#][catid]" value="#catid#" /></td>
<td><input type="hidden" name="linklist[#k#][type]" value="item" /></td>
<td><input type="text" class="input-text" name="linklist[#k#][title]" value="新链接" maxlength="10"></td>
<td><input type="text" class="input-text w60" name="linklist[#k#][displayorder]" value="0" maxlength="4"></td>
<td><input type="text" class="input-text w300" name="linklist[#k#][url]" value=""></td>
</tr>
</script>
<script type="text/template" id="tplClass">
<tr class="white">
  <td><input type="hidden" name="linklist[#k#][type]" value="category" /></td>
  <td colspan="2"><input type="text" class="input-text" name="linklist[#k#][title]" value="新分类" maxlength="10"></td>
  <td colspan="2"><input type="text" class="input-text w60" name="linklist[#k#][displayorder]" value="0" maxlength="4"></td>
</tr>
</script>
<script type="text/javascript">
var k = 0;
function addClass(){
	k--;
	var html = $("#tplClass").html().replace(/#k#/g, k);
	$("#tbclass").append(html);
}
function addLink(catid){
	k--;
	var html = $("#tplLink").html().replace(/#catid#/g,catid).replace(/#k#/g, k);
	$("#tbcontent_"+catid).append(html);
}
</script><?php include template('footer'); ?>