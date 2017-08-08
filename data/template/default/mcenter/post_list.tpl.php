<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="toolbar">
	<a href="/?m=<?php echo $G[m];?>&c=<?php echo $G[c];?>&a=publish" class="button f-right">发布文章</a>
	<ul class="tab">
    	<li class="on"><a>我的文章</a></li>
    </ul>
</div>
<div class="content-div">
	<table cellpadding="0" cellspacing="0" width="100%" border="0" class="listtable">
    	<thead>
        	<tr>
            	<th class="head-first" width="50">图片</th>
                <th>标题</th>
                <th width="140">发布时间</th>
                <th width="40">点击</th>
                <th width="60" class="t-right">状态</th>
            </tr>
        </thead>
        <tbody>
        <?php if(is_array($itemlist)) { foreach($itemlist as $order_id => $item) { ?>            <tr>
            	<td><img src="<?php echo image($item[image]); ?>" width="50" height="50"></td>
            	<td><h3 class="title"><a href="/?m=post&c=detail&id=<?php echo $item[id];?>" target="_blank"><?php echo $item[title];?></a></h3></td>                
                <td><?php echo @date('Y-m-d H:i:s', $item[pubtime]); ?></td>
                <td><?php echo $item[viewnum];?></td>
                <td class="t-right"><?php echo $lang[post_status][$item[status]];?></td>
            </tr>
            <?php } } ?>        </tbody>
    </table>
</div>
<div class="pages"><?php echo $pages;?></div><?php include template('footer'); ?>