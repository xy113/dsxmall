<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="toolbar">
	<ul class="tab">
    	<li class="on"><a href="/?m=<?php echo $G[m];?>&c=<?php echo $G[c];?>&a=goods&tab=all">商品</a></li>
        <li><a href="/?m=<?php echo $G[m];?>&c=<?php echo $G[c];?>&a=shop&tab=all">店铺</a></li>
        <li><a href="/?m=<?php echo $G[m];?>&c=<?php echo $G[c];?>&a=article&tab=all">文章</a></li>
    </ul>
</div><?php include template('footer'); ?>