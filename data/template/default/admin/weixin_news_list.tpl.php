<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="console-title">
	<div class="float-right">
    	<a href="<?php echo U('a=add'); ?>" class="button">添加消息</a>
    </div>
    <h2>图文消息管理</h2>
</div>
<div class="content-div">
    <form method="post" autocomplete="off">
    <input type="hidden" name="formsubmit" value="yes" />
    <input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
    <thead>
      <tr>
        <th width="20" class="center">选?</th>
        <th width="50">图片</th>
        <th width="300">标题</th>
        <th width="340">media_id</th>
        <th width="60">文章数</th>
        <th width="140">创建时间</th>
        <th width="40" style="text-align:center;">编辑</th>
      </tr>
     </thead>
     <tbody>
      <?php if(is_array($itemlist)) { foreach($itemlist as $item) { ?>      <tr>
        <td class="center"><input type="checkbox" class="checkbox checkmark" name="media_id[]" value="<?php echo $item[media_id];?>"></td>
        <td width="50"><img src="<?php echo U('c=wxmaterial&a=viewimage&media_id='.$item[thumb_media_id]); ?>" width="50" height="50"></td>
        <td><?php echo $item[title];?></td>
        <td><?php echo $item[media_id];?></td>
        <td><?php echo $item[item_count];?></td>
        <td><?php echo @date('Y-m-d H:i:s', $item[update_time]); ?></td>
        <td style="text-align:center;"><a href="<?php echo U('a=edit&media_id='.$item[media_id]); ?>">编辑</a></td>
      </tr>
      <?php } } ?>      </tbody>
      <tfoot>
      <tr><td colspan="10">提示:正在使用中的消息无法被删除</td></tr>
      <tr>
        <td colspan="10">
            <label><input type="checkbox" class="checkbox checkall"> <?php echo $_lang[selectall];?></label>
            <label><input type="radio" class="radio" name="option" value="delete" checked> 删除</label>
            <label></label>
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