<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="console-title">
	<div class="float-right">
    	<form name="search" action="/?">
          <input type="hidden" name="m" value="<?php echo $_G[m];?>">
          <input type="hidden" name="c" value="<?php echo $_G[c];?>">
          <input type="hidden" name="a" value="<?php echo $_G[a];?>">
          <input type="hidden" name="status" value="<?php echo $status;?>">
          <span>输入关键字：</span>
          <input type="text" class="input-text" name="keyword" value="<?php echo $keyword;?>">
          <input type="submit" class="button" value="<?php echo $_lang[search];?>">
      </form>
    </div>
    <h2>交易记录</h2>
</div>

<div class="table-wrap">
    <form method="post">
    <input type="hidden" name="formsubmit" value="yes" />
    <input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
    <thead>
      <tr>
        <th width="40" class="center">选?</th>
        <th width="50">头像</th>
        <th>名称 | 流水 | 对方账户</th>
        <th width="100">用户</th>
        <th width="100">金额</th>
        <th width="140">时间</th>
        <th width="60">状态</th>
      </tr>
     </thead>
     <tbody>
      <?php if(is_array($itemlist)) { foreach($itemlist as $trade_id=>$item) { ?>      <tr>
        <td class="center"><input type="checkbox" class="checkbox checkmark" name="trade_id[]" value="<?php echo $trade_id;?>"></td>
        <td><img src="<?php echo avatar($item[uid]); ?>" width="30" height="30"></td>
        <th>
        	<a><?php echo $item[trade_name];?></a>
            <p><?php echo $item[trade_no];?>|<?php echo $userlist[$item[recip_uid]][username];?></p>
        </th>
        <td><?php echo $userlist[$item[uid]][username];?></td>
        <td><?php echo formatAmount($item[trade_fee]); ?></td>
        <td><?php echo @date('Y-m-d H:i:s',$item[trade_time]); ?></td>
        <td><?php echo $_lang[trade_status][$item[trade_status]];?></td>
      </tr>
      <?php } } ?>      </tbody>
      <tfoot>
      <tr>
        <td colspan="10">
            <label><input type="checkbox" class="checkbox checkall"> <?php echo $_lang[selectall];?></label>
            <label><input type="radio" class="radio" name="option" value="delete" checked> 删除</label>
        </td>
      </tr>
      <tr>
          <td colspan="10">
              <span class="pages"><?php echo $pages;?></span>
              <input type="submit" class="button" value="<?php echo $_lang[submit];?>">
              <input type="button" class="button cancel" value="<?php echo $_lang[refresh];?>" onclick="window.location.reload()">
          </td>
      </tr>
     </tfoot>
    </table>
    </form>
</div><?php include template('footer'); ?>