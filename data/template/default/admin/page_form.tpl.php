<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="console-title">
    <div class="float-right">
        <a href="<?php echo U('a=category'); ?>" class="button">分类管理</a>
        <a href="<?php echo U("a=itemlist&catid=$catid"); ?>" class="button">返回列表</a>
    </div>
    <h2><?php if($G[a]=='add') { ?>添加页面<?php } else { ?>编辑页面<?php } ?></h2>
</div>
<div class="area">
    <form method="post" action="">
    <input type="hidden" name="formsubmit" value="yes" />
    <input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
    <tr>
      <td>标题</td>
      <td><input type="text" class="input-text w300" name="newpage[title]" value="<?php echo $page[title];?>"></td>
      <td>别名</td>
      <td><input type="text" class="input-text w300" name="newpost[alias]" value="<?php echo $page[alias];?>"></td>
    </tr>
    <tr>
      <td width="60">分类</td>
      <td>
            <select name="newpage[catid]" class="w300">
            <?php if(is_array($categorylist)) { foreach($categorylist as $clist) { ?>            <option value="<?php echo $clist[pageid];?>"<?php if($page[catid]==$clist[pageid]) { ?> selected<?php } ?>><?php echo $clist[title];?></option>
            <?php } } ?>            </select>
      </td>
      <td width="60">模板</td>
      <td><input type="text" class="input-text w300" name="newpage[template]" value="<?php echo $page[template];?>"></td>
    </tr>      
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
    <tr>
      <td width="60">摘要</td>
      <td><textarea style="width:100%;" name="newpage[summary]"><?php echo $page[summary];?></textarea></td>
      <td width="200"><input type="submit" class="submit button-publish f-right" value="<?php if($G[a]=='edit') { ?>更新<?php } else { ?>发布<?php } ?>" id="publishButton"></td>
    </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
    <tr>
      <td><div style="box-sizing:border-box"><?php include template('editor'); ?></div></td>
    </tr>
  </table>
  </form>
</div><?php include template('footer'); ?>