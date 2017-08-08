<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="toolbar">
	<div class="f-right">
    	<form method="get" action="/">
        <input type="hidden" name="m" value="<?php echo $G[m];?>">
        <input type="hidden" name="c" value="<?php echo $G[c];?>">
        <input type="hidden" name="a" value="<?php echo $G[a];?>">
    	<input type="text" name="keyword" class="input-text" placeholder="关键字"> 
        <input type="submit" class="button" value="搜索">
        </form>
    </div>
	<ul class="tab">
    	<li class="on"><a href="<?php echo U('a='.$G[a].'&tab=all'); ?>">收藏夹</a></li>
    </ul>
</div>

<div class="content-div">
	<table cellpadding="0" cellspacing="0" width="100%" border="0" class="listtable">
    	<thead>
        	<tr>
            	<th width="60">图片</th>
            	<th>标题</th>
                <th width="200">时间</th>
                <th width="55">选项</th>
            </tr>
        </thead>
        <tbody>
        <?php if(is_array($itemlist)) { foreach($itemlist as $favid=>$item) { ?>            <tr id="favorite-item-<?php echo $favid;?>">
            	<td><div class="pic"><a href="/?m=post&c=detail&id=<?php echo $item[dataid];?>" target="_blank"><img src="<?php echo image($item[image]); ?>"></a></div></td>
            	<td>
                	<h3 class="title"><a href="/?m=post&c=detail&id=<?php echo $item[dataid];?>" target="_blank"><?php echo $item[title];?></a></h3>
                </td>
                <td><?php echo @date('Y-m-d H:i:s', $item[dateline]); ?></td>
                <td><a rel="a-remove-favorite" data-id="<?php echo $favid;?>">取消收藏</a></td>
            </tr>
            <?php } } ?>        </tbody>
    </table>
</div>
<div class="pages">$pages</div>
<script type="text/javascript">
$("a[rel=a-remove-favorite]").confirm({
	text:'确定要取消收藏吗?',
	onConfirm:function(view,o){
		var favid = $(o).attr('data-id');
		$.ajax({
			url:'<?php echo U("m=mcenter&c=favorite&a=remove"); ?>',
			data:{favid:favid},
			dataType:"json",
			success: function(json){
				if(json.errcode == 0){
					$("#favorite-item-"+favid).remove();
					DSXUI.success('取消收藏成功');
				}
			}
		});
	}
});
</script><?php include template('footer'); ?>