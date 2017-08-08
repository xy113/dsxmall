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
    <h2>订单列表</h2>
</div>

<div class="table-wrap">
    <form method="post">
    <input type="hidden" name="formsubmit" value="yes" />
    <input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
    <thead>
      <tr>
        <th width="20" class="center">选?</th>
        <th>名称 | 订单号 | 卖家</th>
        <th width="100">用户</th>
        <th width="100">金额</th>
        <th width="140">时间</th>
      </tr>
     </thead>
     <tbody>
      <?php if(is_array($itemlist)) { foreach($itemlist as $order_id=>$item) { ?>      <tr>
        <td class="center"><input type="checkbox" class="checkbox checkmark" name="order_id[]" value="<?php echo $order_id;?>"></td>
        <th>
        	<a href="/?m=post&c=detail&id=<?php echo $item[dataid];?>" target="_blank"><?php echo $item[order_name];?></a>
            <p style="font-weight:300; font-size:11px; color:#999;"><?php echo $item[order_no];?> | <?php echo $userlist[$item[seller_uid]][username];?></p>
        </th>
        <td><?php echo $userlist[$item[uid]][username];?></td>
        <td><?php echo formatAmount($item[order_fee]); ?></td>
        <td><?php echo @date('Y-m-d H:i:s',$item[order_time]); ?></td>
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
              <input type="button" class="button button-cancel" value="<?php echo $_lang[refresh];?>" onclick="window.location.reload()">
          </td>
      </tr>
     </tfoot>
    </table>
    </form>
</div><?php include template('footer'); ?>