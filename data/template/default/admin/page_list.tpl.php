<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="console-title">
	<div class="float-right">
        <a href="<?php echo U('a=add&catid='.$catid); ?>" class="button">添加页面</a>
    </div>
    <h2>页面管理</h2>
</div>
<div class="toolbar">
	<a href="" class="baritem" style="margin-left:0;">全部</a>
    <?php if(is_array($categorylist)) { foreach($categorylist as $clist) { ?>    <a href="<?php echo U('catid='.$clist[pageid]); ?>" class="baritem"><?php echo $clist[title];?></a>
    <?php } } ?></div>
<div class="table-wrap">
<form method="post" action="">
    <input type="hidden" name="formsubmit" value="yes" />
    <input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
    <thead>
      <tr>
        <th width="20">删?</th>
        <th>标题</th>
        <th>别名</th>
        <th width="80">排序</th>
        <th width="120">发布时间</th>
        <th width="120">最后修改</th>
        <th width="40">编辑</th>
      </tr>
     </thead>
     <tbody>
      <?php if(is_array($pagelist)) { foreach($pagelist as $item) { ?>      <?php $pageid=$item[pageid]; ?>      <tr>
        <td><input type="checkbox" class="checkbox checkmark" name="delete[]" value="<?php echo $pageid;?>"></td>
        <th><a href="<?php echo U('m=page&c=detail&pageid='.$pageid); ?>" target="_blank"><?php echo $item[title];?></a></th>
        <td><?php echo $item[alias];?></td>
        <td><input type="text" class="input-text w60" name="pagelist[<?php echo $pageid;?>][displayorder]" value="<?php echo $item[displayorder];?>" /></td>
        <td><?php echo @date('Y-m-d H:i',$item[pubtime]); ?></td>
        <td><?php echo @date('Y-m-d H:i',$item[modified]); ?></td>
        <td><a href="<?php echo U('a=edit&pageid='.$pageid); ?>">编辑</a></td>
      </tr>
      <?php } } ?>      </tbody>
      <tfoot>
        <tr>
            <td colspan="10">
            <label><input type="checkbox" class="checkbox checkall"> 全选</label>
            </td>
        </tr>
        <tr>
          <td colspan="10">
              <span class="pages"><?php echo $pages;?></span>
              <input type="submit" class="button" value="提交">
              <input type="button" class="button cancel" value="刷新" onclick="window.location.reload()">
          </td>
        </tr>
     </tfoot>
</table>
</form>
</div><?php include template('footer'); ?>