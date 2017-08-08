<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="toolbar">
	<ul class="tab">
    	<li class="on"><a href="/?m=<?php echo $G[m];?>&c=<?php echo $G[c];?>&a=index">账户余额</a></li>
        <li><a href="/?m=<?php echo $G[m];?>&c=trade&a=itemlist">交易明细</a></li>
    </ul> 
</div>
<div class="account-balance-div">当前余额: <span><?php echo formatAmount($wallet[balance]); ?></span></div><?php include template('footer'); ?>