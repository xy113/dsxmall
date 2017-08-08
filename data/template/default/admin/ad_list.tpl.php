<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="console-title">
	<a href="<?php echo U('a=add'); ?>" class="button float-right">添加广告</a>
	<h2>广告管理</h2>
</div>
<div class="content-div">
<form method="post" autocomplete="off">
<input type="hidden" name="formsubmit" value="yes" />
<input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
<thead>
  <tr>
    <th width="30" class="center">删?</th>
    <th>广告名称</th>
    <th width="60">ID</th>
    <th width="100">类型</th>
    <th width="100">开始时间</th>
    <th width="100">结束时间</th>
    <th width="80" class="center">点击数</th>
    <th width="80">状态</th>
    <th width="40">编辑</th>
  </tr>
 </thead>
 <tbody id="mainbody">
  <?php if(is_array($adlist)) { foreach($adlist as $list) { ?>  <tr>
    <td><input type="checkbox" class="checkbox checkmark" name="id[]" value="<?php echo $list[id];?>"></td>
    <td><?php echo $list[title];?></td>
    <td><?php echo $list[id];?></td>
    <td><?php echo $lang[ad_types][$list[type]];?></td>
    <td><?php echo $list[starttime];?></td>
    <td><?php echo $list[endtime];?></td>
    <td class="center"><?php echo $list[clicknum];?></td>
    <td><?php echo $lang[ad_status][$list[status]];?></td>
    <td><a href="<?php echo U("a=edit&id=$list[id]"); ?>">编辑</a></td>
  </tr>
  <?php } } ?>  </tbody>
  <tfoot>
  <tr>
    <td colspan="10">
        <label><input type="checkbox" class="checkbox checkall"> 全选</label>
        <label><input type="radio" class="radio" name="option" value="delete" checked> 删除</label>
        <label><input type="radio" class="radio" name="option" value="enable"> 启用</label>
        <label><input type="radio" class="radio" name="option" value="disable"> 停用</label>
    </td>
  </tr>
  <tr>
      <td colspan="10">
          <span class="pages"><?php echo $pages;?></span>
          <input type="submit" class="button" value="<?php echo $_lang[submit];?>">
          <input type="button" class="button button-cancel" value="<?php echo $_lang[refresh];?>" onclick="window.location.reload()">
      </td>
  </tr>
 </tfoot>
</table>
</form>
</div><?php include template('footer'); ?>