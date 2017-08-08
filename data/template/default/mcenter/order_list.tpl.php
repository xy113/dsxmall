<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="toolbar">
	<div class="f-right">
    	<form method="get" action="/">
        <input type="hidden" name="m" value="<?php echo $G[m];?>">
        <input type="hidden" name="c" value="<?php echo $G[c];?>">
        <input type="hidden" name="a" value="<?php echo $G[a];?>">
    	<input type="text" name="keyword" class="input-text" placeholder="订单名称，订单号" value="<?php echo $keyword;?>"> 
        <input type="submit" class="button" value="搜索">
        </form>
    </div>
	<ul class="tab">
    	<li<?php if($tab=='all') { ?> class="on"<?php } ?>><a href="<?php echo U('c=order&a=itemlist&tab=all'); ?>">全部订单</a></li>
        <li<?php if($tab=='free') { ?> class="on"<?php } ?>><a href="<?php echo U('c=order&a=itemlist&tab=free'); ?>">免费项目</a></li>
        <li<?php if($tab=='not_free') { ?> class="on"<?php } ?>><a href="<?php echo U('c=order&a=itemlist&tab=not_free'); ?>">付费项目</a></li>
    </ul>
</div>

<div class="content-div">
	<table cellpadding="0" cellspacing="0" width="100%" border="0" class="listtable">
    	<thead>
        	<tr>
            	<th class="head-first">名称 | 订单号 | 卖家账号</th>
                <th width="100">金额</th>
                <th width="120" class="t-right">时间</th>
            </tr>
        </thead>
        <tbody>
        <?php if(is_array($itemlist)) { foreach($itemlist as $order_id => $item) { ?>            <tr>
            	<td>
                	<h3 class="title"><a href="/?m=post&c=detail&id=<?php echo $item[dataid];?>" target="_blank"><?php echo $item[order_name];?></a></h3>
                    <p class="info"><?php echo $item[order_no];?> | <?php echo $userlist[$item[seller_uid]][username];?></p>
                </td>
                <td><?php echo formatAmount($item[order_fee]); ?></td>
                <td class="t-right"><?php echo @date('Y-m-d H:i:s', $item[order_time]); ?></td>
            </tr>
            <?php } } ?>        </tbody>
    </table>
</div>
<div class="pages"><?php echo $pages;?></div><?php include template('footer'); ?>