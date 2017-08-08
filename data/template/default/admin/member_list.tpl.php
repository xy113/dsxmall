<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="console-title">
    <div class="float-right">
        <form method="get" name="search" action="/">
            <input type="hidden" name="m" value="<?php echo $G[m];?>" />
            <input type="hidden" name="c" value="<?php echo $G[c];?>" />
            <input type="hidden" name="a" value="<?php echo $G[a];?>" />
            <select name="field" class="select" style="width: auto;">
                <option class="0">全部</option>
                <option value="uid"<?php if($field=='uid') { ?> selected<?php } ?>>UID</option>
                <option value="username"<?php if($field=='username') { ?> selected<?php } ?>>姓名</option>
                <option value="mobile"<?php if($field=='mobile') { ?> selected<?php } ?>>手机号</option>
                <option value="email"<?php if($field=='email') { ?> selected<?php } ?>>邮箱</option>
            </select>
            <input type="text" class="input-text w200" name="keyword" value="<?php echo $keyword;?>" placeholder="手机号/登录名/邮箱" />
            <input type="submit" class="button" value="搜索" />
            <a href="<?php echo U('a=add'); ?>" class="button">添加用户</a>
        </form>
    </div>
    <h2>用户管理->用户列表</h2>
</div>

<div class="content-div">
<form method="post" action="">
    <input type="hidden" name="formsubmit" value="yes">
    <input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>" />
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
    <thead>
        <tr>
          <th width="20">选</th>
          <th width="30">头像</th>
          <th width="100">姓名</th>
          <th width="100">手机号</th>
          <th>电子邮箱</th>
          <th width="80">用户组</th>
          <th width="130">注册日期</th>
          <th width="130">最后登录</th>
          <th width="70">状态</th>
          <th width="40">编辑</th>
        </tr>
    </thead>
    <tbody id="members">
        <?php if(is_array($memberlist)) { foreach($memberlist as $uid=>$member) { ?>        <?php $isfounder=in_array($uid, C('FOUNDERS'));; ?>        <tr>
          <td><input type="checkbox" class="checkbox checkmark"<?php if($isfounder) { ?> disabled="disabled"<?php } else { ?> name="uid[]" value="<?php echo $uid;?>"<?php } ?> /></td>
          <td><img src="<?php echo $member[avatar][small];?>" width="30" height="30" style="border-radius:100%;"></td>
          <th><a href="/?m=space&uid=<?php echo $uid;?>" target="_blank"><?php echo $member[username];?></a></th>
          <td><?php echo $member[mobile];?></td>
          <td><?php echo $member[email];?></td>
          <td><?php echo $grouplist[$member[gid]][title];?></td>
          <td><a href="http://ip.taobao.com/?ip=<?php echo $member[regip];?>" target="_blank"><?php echo $member[regdate];?></a></td>
          <td><a href="http://ip.taobao.com/?ip=<?php echo $member[lastvisitip];?>" target="_blank"><?php echo $member[lastvisit];?></a></td>
          <td><?php echo $member[status_name];?></td>
          <td><a href="<?php echo U("a=edit&uid=$member[uid]"); ?>">编辑</a></td>
        </tr>
        <?php } } ?>    </tbody>
    <tfoot>
    <tr>
        <td colspan="12">
            <label><input type="checkbox" class="checkbox checkall" /> 全选</label>
            <label><input type="radio" name="option" value="delete" checked> 删除</label>
            <label><input type="radio" name="option" value="move"> 移动</label>
            <label><input type="radio" name="option" value="normal"> 正常</label>
            <label><input type="radio" name="option" value="nologin"> 禁止登录</label>
            <label><input type="radio" name="option" value="nopost"> 禁止发言</label>
        </td>
    </tr>
    <tr>
        <td colspan="12">
            <span class="pagination float-right"><?php echo $pages;?></span>
            <input type="submit" class="button" value="提交" />
            <input type="button" class="button cancel" value="刷新" onclick="window.location.reload()" />
        </td>
    </tr>
    </tfoot>
  </table>
 </form>
</div><?php include template('footer'); ?>