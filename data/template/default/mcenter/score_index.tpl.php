<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="contect-div">
	<h3>当前拥有积分: <?php echo $wallet[score];?></h3>
</div>
<div class="content-div">
	<table cellpadding="0" cellspacing="0" border="0" width="100%" class="listtable">
        <tbody>
        <?php if(is_array($itemlist)) { foreach($itemlist as $id => $item) { ?>        	<tr>
            	<td class="time"><span><?php echo @date('Y.m.d', $item[dateline]); ?></span></td>
               	<td class="name">
               		<h3><?php echo $item[subject];?></h3>
               	</td>
               <td class="amount"><span><?php if($item[type]=='INCOME') { ?>+<?php } else { ?>-<?php } ?><?php echo $item[score];?></span></td>
               <td class="status"><?php echo $item[recip_uid];?></td>
            </tr>
            <?php } } ?>        </tbody>
    </table>
</div><?php include template('footer'); ?>