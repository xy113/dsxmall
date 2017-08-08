<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="toolbar">
	<ul class="tab">
    	<li<?php if($tab=='all') { ?> class="on"<?php } ?>><a href="/?m=<?php echo $G[m];?>&c=<?php echo $G[c];?>&a=<?php echo $G[a];?>&tab=all">全部广告</a></li>
        <li<?php if($tab=='normal') { ?> class="on"<?php } ?>><a href="/?m=<?php echo $G[m];?>&c=<?php echo $G[c];?>&a=<?php echo $G[a];?>&tab=normal">正常</a></li>
        <li<?php if($tab=='pending') { ?> class="on"<?php } ?>><a href="/?m=<?php echo $G[m];?>&c=<?php echo $G[c];?>&a=<?php echo $G[a];?>&tab=pending">待审核</a></li>
        <li<?php if($tab=='unaudit') { ?> class="on"<?php } ?>><a href="/?m=<?php echo $G[m];?>&c=<?php echo $G[c];?>&a=<?php echo $G[a];?>&tab=unaudit">审核未过</a></li>
    </ul>
</div><?php include template('footer'); ?>