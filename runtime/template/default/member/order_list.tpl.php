<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="console-title">
	<div class="float-right">
    	<form method="get" action="/">
        <input type="hidden" name="m" value="<?php echo $_G[m];?>">
        <input type="hidden" name="c" value="<?php echo $_G[c];?>">
        <input type="hidden" name="a" value="<?php echo $_G[a];?>">
    	<input type="text" name="q" value="<?php echo $q;?>" class="input-text" placeholder="订单号">
        <input type="submit" class="button" value="搜索">
        </form>
    </div>
	<ul class="tab">
    	<li<?php if($tab=='all') { ?> class="on"<?php } ?>><a href="<?php echo U('c=order&a=itemlist&tab=all'); ?>">全部订单</a></li>
        <li<?php if($tab=='waitPay') { ?> class="on"<?php } ?>><a href="<?php echo U('c=order&a=itemlist&tab=waitPay'); ?>">待付款</a></li>
        <li<?php if($tab=='waitSend') { ?> class="on"<?php } ?>><a href="<?php echo U('c=order&a=itemlist&tab=waitSend'); ?>">待发货</a></li>
        <li<?php if($tab=='waitConfirm') { ?> class="on"<?php } ?>><a href="<?php echo U('c=order&a=itemlist&tab=waitConfirm'); ?>">待收货</a></li>
        <li<?php if($tab=='waitRate') { ?> class="on"<?php } ?>><a href="<?php echo U('c=order&a=itemlist&tab=waitRate'); ?>">待评价</a></li>
    </ul>
</div>

<div class="content-div">
	<table class="order-title-table" cellpadding="0" cellspacing="0" width="100%">
        <tbody>
            <tr>
                <td>宝贝</td>
                <td width="80">单价</td>
                <td width="60">数量</td>
                <td width="100">商品操作</td>
                <td width="100">实付款</td>
                <td width="100">交易状态</td>
                <td width="100">交易操作</td>
            </tr>
        </tbody>
    </table>
    <?php if(is_array($order_list)) { foreach($order_list as $order_id=>$order) { ?>    <div class="order-item-wrap" id="order-item-<?php echo $order_id;?>">
        <table class="order-item-table" cellspacing="0" cellpadding="0" width="100%">
            <thead>
            <tr>
                <th>
                    <span class="wrap-checkbox"><input type="checkbox"></span>
                    <span class="wrap-time"><?php echo @date('Y-m-d',$order[create_time]); ?></span>
                    <span class="wrap-order-no"><?php echo $order[order_no];?></span>
                </th>
                <th colspan="2">
                    <h3>
                        <a href="<?php echo U('m=shop&c=viewshop&shop_id='.$order[shop_id]); ?>" title="<?php echo $order[shop_name];?>" target="_blank">
                            <?php echo $item[shop_short_name];?></a>
                    </h3>
                </th>
                <th></th>
                <th colspan="3" style="text-align: right;"><a class="iconfont icon-deletefill delete-order" title="删除订单" rel="delete" data-id="<?php echo $order_id;?>"></a></th>
            </tr>
            </thead>
            <tbody>
                <?php $index=0; ?>                <?php if(is_array($order[items])) { foreach($order[items] as $itemid=>$item) { ?>                <?php $index++; ?>                <tr>
                    <td class="col1">
                        <div class="goods-pic">
                            <a href="<?php echo U('m=item&c=item&id='.$itemid); ?>" target="_blank"><img src="<?php echo image($item[thumb]); ?>"></a>
                        </div>
                        <div style="margin-left: 90px; overflow: hidden;">
                            <div class="goods-name"><a href="<?php echo U('m=item&c=item&id='.$itemid); ?>" target="_blank"><?php echo $item[title];?></a></div>
                            <div class="goods-attr">产品属性</div>
                        </div>
                    </td>
                    <td class="col2">
                        <?php if($item[market_price]) { ?><p><s>￥<?php echo formatAmount($item[market_price]); ?></s></p><?php } ?>
                        <p>￥<?php echo formatAmount($item[price]); ?></p>
                    </td>
                    <td class="col3"><?php echo $item[quantity];?></td>
                    <td class="col4">
                        <?php if($index==1) { ?>
                        <?php if($order[pay_status] && !$order[is_closed]) { ?>
                            <?php if($order[receive_status]) { ?>
                            <p><a>申请售后</a></p>
                            <?php } else { ?>
                                <?php if($order[refund_status]==0) { ?>
                                    <p><a href="<?php echo U('m=refund&c=apply&order_id='.$order_id); ?>" target="_blank">退款/退货</a></p>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>

                        <p><a>投诉卖家</a></p>
                        <?php } ?>
                    </td>
                    <td class="col5">
                        <?php if($index==1) { ?>
                        <p><strong style="color: #FF0000;">￥<?php echo formatAmount($order[total_fee]); ?></strong></p>
                        <p style="font-size: 11px;">(含运费:￥<?php echo formatAmount($order[shipping_fee]); ?>)</p>
                        <?php } ?>
                    </td>
                    <td class="col6">
                        <?php if($index==1) { ?>
                            <?php if($order[pay_type]==2) { ?>
                                <?php if($order[shipping_status]) { ?>
                                <p>需求提交成功</p>
                                <?php } else { ?>
                                <p>需求已提交</p>
                                <?php } ?>
                            <?php } else { ?>
                                <?php if($order[trade_status]==4||$order[trade_status]==5) { ?>
                                <p>交易成功</p>
                                <?php } else { ?>
                                <p><?php echo $order[trade_status_tips];?></p>
                                <?php } ?>
                            <?php } ?>
                        <p><a href="<?php echo U('c=order&a=detail&order_id='.$order_id); ?>" target="_blank">订单详情</a></p>
                        <?php if($order[shipping_status]) { ?>
                        <p>查看物流</p>
                        <?php } ?>
                        <?php } ?>
                    </td>
                    <td class="col7">
                        <?php if($index==1) { ?>
                            <?php if($order[pay_type]==1) { ?>
                                <?php if($order[trade_status]==1) { ?>
                                <a href="<?php echo U('m=buy&c=pay&order_id='.$order_id); ?>" target="_blank" class="button btn">立即支付</a>
                                <p style="margin: 3px 0;"><a rel="closeOrder" data-id="<?php echo $order_id;?>">取消订单</a></p>
                                <?php } elseif($order[trade_status]==2) { ?>
                                <a>提醒卖家发货</a>
                                <?php } elseif($order[trade_status]==3) { ?>
                                <a href="<?php echo U('c=order&a=detail&order_id='.$order_id.'#receipt'); ?>" class="button btn" target="_blank">确认收货</a>
                                <?php } elseif($order[trade_status]==4) { ?>
                                <p><a>立即评价</a></p>
                                <?php } elseif($order[trade_status]==5) { ?>
                                <p><a>申请退货</a></p>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </td>
                </tr>
                <?php } } ?>            </tbody>
        </table>
    </div>
    <?php } } ?></div>
<div class="pagination"><?php echo $pages;?></div>
<script type="text/javascript">
    $(document).ready(function () {
        $("a[rel=delete]").on('click', function () {
            var order_id = $(this).attr('data-id');
            DSXUI.showConfirm('删除订单','确认要删除此订单吗?', function () {
                var spinner = null;
                $.ajax({
                    url:"<?php echo U('c=order&a=delete'); ?>",
                    data:{order_id:order_id},
                    dataType:'json',
                    beforeSend:function () {
                        spinner = DSXUI.showSpinner();
                    },
                    success:function (response) {
                        setTimeout(function () {
                            spinner.close();
                            if (response.errcode == 0){
                                $("#order-item-"+order_id).remove();
                            }else {
                                DSXUI.error('系统繁忙,请稍后再试');
                            }
                        }, 500);
                    }
                });
            });
        });

        $("[rel=closeOrder]").on('click', function () {
            var order_id = $(this).attr('data-id');
            DSXUI.dialog({
                title:'关闭订单',
                iframe:"<?php echo U('m=member&c=order&a=frame_close&order_id='); ?>"+order_id,
                hideFooter:true,
                height:'260px',
                width:'550px',
                afterShow:function (dlg) {
                    window.afterCloseOrder = function () {
                        dlg.close();
                        DSXUtil.reFresh();
                    }
                }
            });
        });
    })
</script><?php include template('footer'); ?>