<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="console-title">
	<a href="<?php echo U('a=memberlist'); ?>" class="submit f-right">用户列表</a>
    <h2>用户分组管理</h2>
</div>
<div class="table-wrap">
<form method="post" autocomplete="off">
    <input type="hidden" name="formsubmit" value="yes" />
    <input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>" />
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
    <thead>
    <tr>
      <th width="20" class="center">删?</th>
      <th width="30">GID</th>
      <th width="100">组名称</th>
      <th width="100">积分下线</th>
      <th width="110">积分上限</th>
      <th width="60">类型</th>
      <th>组权限</th>
    </tr>
    </thead>
    <tbody id="grouplist">
    <?php if(is_array($usergrouplist[system])) { foreach($usergrouplist[system] as $gid=>$group) { ?>    <tr>
      <td><input type="checkbox" class="checkbox" disabled="disabled" /></td>
      <td><?php echo $gid;?></td>
      <td><input type="text" class="input-text w100" name="grouplist[<?php echo $gid;?>][title]" value="<?php echo $group[title];?>" maxlength="10"></td>
      <td><input type="text" class="input-text w100" name="grouplist[<?php echo $gid;?>][creditslower]" value="<?php echo $group[creditslower];?>" maxlength="10"></td>
      <td><input type="text" class="input-text w100" name="grouplist[<?php echo $gid;?>][creditshigher]" value="<?php echo $group[creditshigher];?>" maxlength="10"></td>
      <td>系统</td>
      <td style="line-height:1.5;">
        <?php $permission=$group[perm]; ?>        <?php if(is_array($lang[member_perms])) { foreach($lang[member_perms] as $k=>$v) { ?>        <label>
        <input type="checkbox" value="1" name="{grouplist[$gid][perm][$k]}"<?php if($permission[$k]) { ?> checked="checked"<?php } ?>> <?php echo $v;?>
        </label>
        <?php } } ?>      </td>
    </tr>
    <?php } } ?>    <?php if(is_array($usergrouplist[member])) { foreach($usergrouplist[member] as $gid=>$group) { ?>    <tr>
      <td><input type="checkbox" class="checkbox" disabled="disabled" /></td>
      <td><?php echo $gid;?></td>
      <td><input type="text" class="input-text w100" name="{grouplist[$gid][title]}" value="<?php echo $group[title];?>" maxlength="10"></td>
      <td><input type="text" class="input-text w100" name="{grouplist[$gid][creditslower]}" value="<?php echo $group[creditslower];?>" maxlength="10"></td>
      <td><input type="text" class="input-text w100" name="{grouplist[$gid][creditshigher]}" value="<?php echo $group[creditshigher];?>" maxlength="10"></td>
      <td>用户</td>
      <td style="line-height:1.5;">
        <?php $permission=$group[perm]; ?>        <?php if(is_array($lang[member_perms])) { foreach($lang[member_perms] as $k=>$v) { ?>        <label>
        <input type="checkbox" value="1" name="grouplist[<?php echo $gid;?>][perm][<?php echo $k;?>]"<?php if($permission[$k]) { ?> checked="checked"<?php } ?>> <?php echo $v;?>
        </label>
        <?php } } ?>      </td>
    </tr>
    <?php } } ?>    <?php if(is_array($usergrouplist[custom])) { foreach($usergrouplist[custom] as $gid=>$group) { ?>    <tr>
      <td><input type="checkbox" class="checkbox" name="delete[]" value="<?php echo $gid;?>" /></td>
      <td><?php echo $gid;?></td>
      <td><input type="text" class="input-text w100" name="grouplist[<?php echo $gid;?>][title]" value="<?php echo $group[title];?>" maxlength="10"></td>
      <td><input type="text" class="input-text w100" name="grouplist[<?php echo $gid;?>][creditslower]" value="<?php echo $group[creditslower];?>" maxlength="10"></td>
      <td><input type="text" class="input-text w100" name="grouplist[<?php echo $gid;?>][creditshigher]" value="<?php echo $group[creditshigher];?>" maxlength="10"></td>
      <td>自定义</td>
      <td style="line-height:1.5;">
      <?php $permission=$group[perm]; ?>      <?php if(is_array($lang[member_perms])) { foreach($lang[member_perms] as $k=>$v) { ?>      <label>
      <input type="checkbox" value="1" name="grouplist[<?php echo $gid;?>][perm][<?php echo $k;?>]"<?php if($permission[$k]) { ?> checked="checked"<?php } ?>> <?php echo $v;?>
      </label>
      <?php } } ?>      </td>
    </tr>
    <?php } } ?>    </tbody>
    <tfoot>
    <tr>
        <td colspan="10"><a href="javascript:;" id="addgroup"><i class="icon">&#xf0154;</i>添加新分组</a></td>
    </tr>
    <tr>
        <td colspan="10">
            <input type="submit" class="button" value="提交" />
            <input type="button" class="button cancel" value="刷新" onclick="window.location.reload()" />
        </td>
    </tr>
    </tfoot>
  </table>
 </form>
 </div>
<script type="text/html" id="rowtpl">
<tr>
  <td></td>
  <td><input type="hidden" name="grouplist[nkey][type]" value="custom"></td>
  <td><input type="text" class="input-text w100" name="grouplist[nkey][title]" value="" maxlength="10"></td>
  <td><input type="text" class="input-text w100" name="grouplist[nkey][creditslower]" value="" maxlength="10"></td>
  <td><input type="text" class="input-text w100" name="grouplist[nkey][creditshigher]" value="" maxlength="10"></td>
  <td>自定义</td>
  <td>
  <?php if(is_array($lang[member_perms])) { foreach($lang[member_perms] as $k=>$v) { ?><input type="checkbox" value="1" name="newgroup[nkey][perm][<?php echo $k;?>]"> <?php echo $v;?> <?php } } ?>  </td>
</tr>
</script>
<script type="text/javascript">
var nkey = 0;
$("#addgroup").click(function(){
	nkey--;
	$("#grouplist").append($("#rowtpl").html().replace(/nkey/g,nkey));
});
</script><?php include template('footer'); ?>