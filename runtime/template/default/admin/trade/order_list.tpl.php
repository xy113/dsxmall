<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><script src="/static/DatePicker/WdatePicker.js" type="text/javascript"></script>
<div class="navigation">
    <a>后台管理</a>
    <span>></span>
    <a>订单管理</a>
    <span>></span>
    <a>订单列表</a>
</div>
<div class="search-container">
    <form method="get" id="searchFrom">
        <input type="hidden" name="m" value="<?php echo $_G[m];?>">
        <input type="hidden" name="c" value="<?php echo $_G[c];?>">
        <input type="hidden" name="a" value="<?php echo $_G[a];?>" id="J_a">
        <div class="row">
            <div class="cell">
                <label>商品ID:</label>
                <div class="field"><input type="text" class="input-text" name="itemid" value="<?php echo $itemid;?>"></div>
            </div>
            <div class="cell">
                <label>订单编号:</label>
                <div class="field"><input type="text" class="input-text" name="order_no" value="<?php echo $order_no;?>"></div>
            </div>
            <div class="cell">
                <label>买家昵称:</label>
                <div class="field"><input type="text" class="input-text" name="buyer_name" value="<?php echo $buyer_name;?>"></div>
            </div>
        </div>
        <div class="row">
            <div class="cell">
                <label>订单状态:</label>
                <div class="field">
                    <select class="select" name="order_status">
                        <option value="0">全部</option>
                        <option value="1"<?php if($order_status==1) { ?> selected<?php } ?>>等待买家付款</option>
                        <option value="2"<?php if($order_status==2) { ?> selected<?php } ?>>买家已付款</option>
                        <option value="3"<?php if($order_status==3) { ?> selected<?php } ?>>卖家已发货</option>
                        <option value="4"<?php if($order_status==4) { ?> selected<?php } ?>>交易成功</option>
                        <option value="5"<?php if($order_status==5) { ?> selected<?php } ?>>买家已评价</option>
                        <option value="6"<?php if($order_status==6) { ?> selected<?php } ?>>退款中的订单</option>
                        <option value="7"<?php if($order_status==7) { ?> selected<?php } ?>>退款完成</option>
                    </select>
                </div>
            </div>
            <div class="cell">
                <label>支付方式:</label>
                <div class="field">
                    <select class="select" name="pay_type">
                        <option value="0">全部</option>
                        <option value="1"<?php if($pay_type==1) { ?> selected<?php } ?>>在线支付</option>
                        <option value="2"<?php if($pay_type==2) { ?> selected<?php } ?>>货到付款</option>
                    </select>
                </div>
            </div>
            <div class="cell">
                <label>物流状态:</label>
                <div class="field">
                    <select class="select" name="wuliu_status">
                        <option value="0">全部</option>
                        <option value="1"<?php if($wuliu_status==1) { ?> selected<?php } ?>>未发货</option>
                        <option value="2"<?php if($wuliu_status==2) { ?> selected<?php } ?>>已发货</option>
                        <option value="3"<?php if($wuliu_status==3) { ?> selected<?php } ?>>已收货</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="cell">
                <label>宝贝名称:</label>
                <div class="field"><input type="text" class="input-text" name="title"></div>
            </div>
            <div class="cell" style="width: auto;">
                <label>交易时间:</label>
                <div class="field">
                    <input type="text" class="input-text" name="time_begin" onclick="WdatePicker()" value="<?php echo $time_begin;?>"> -
                    <input type="text" class="input-text" name="time_end" onclick="WdatePicker()" value="<?php echo $time_end;?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="cell">
                <label></label>
                <div class="field">
                    <button type="button" class="button" id="btn-search">搜索订单</button>
                    <button type="button" class="button button-cancel" id="btn-export">批量导出</button>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="tabs-container">
    <div class="tabs">
        <div class="tab<?php if($tab=='all') { ?> on<?php } ?>"><a href="<?php echo U('c=order&a=itemlist&tab=all'); ?>">全部订单</a><span>|</span></div>
        <div class="tab<?php if($tab=='waitPay') { ?> on<?php } ?>"><a href="<?php echo U('c=order&a=itemlist&tab=waitPay'); ?>">等待买家付款</a><span>|</span></div>
        <div class="tab<?php if($tab=='waitSend') { ?> on<?php } ?>"><a href="<?php echo U('c=order&a=itemlist&tab=waitSend'); ?>">等待卖家发货</a><span>|</span></div>
        <div class="tab<?php if($tab=='send') { ?> on<?php } ?>"><a href="<?php echo U('c=order&a=itemlist&tab=send'); ?>">卖家已发货</a><span>|</span></div>
        <div class="tab<?php if($tab=='received') { ?> on<?php } ?>"><a href="<?php echo U('c=order&a=itemlist&tab=received'); ?>">买家已收货</a><span>|</span></div>
        <div class="tab<?php if($tab=='reviewed') { ?> on<?php } ?>"><a href="<?php echo U('c=order&a=itemlist&tab=reviewed'); ?>">买家已评价</a><span>|</span></div>
        <div class="tab<?php if($tab=='refunding') { ?> on<?php } ?>"><a href="<?php echo U('c=order&a=itemlist&tab=refunding'); ?>">退款中</a></div>
        <div class="tab<?php if($tab=='closed') { ?> on<?php } ?>"><a href="<?php echo U('c=order&a=itemlist&tab=closed'); ?>">已关闭的订单</a></div>
    </div>
</div>
<div class="content-div">
    <form method="post" id="listForm">
        <input type="hidden" name="formsubmit" value="yes" />
        <input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>">
        <input type="hidden" name="eventType" value="" id="J_eventType">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
            <thead>
            <tr>
                <th width="40" class="center">选?</th>
                <th width="60">图片</th>
                <th>商品名称 | 订单号 | 卖家账号</th>
                <th>买家账号</th>
                <th>金额</th>
                <th>下单时间</th>
                <th>订单状态</th>
                <th width="60">详情</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($order_list)) { foreach($order_list as $order_id=>$order) { ?>            <tr>
                <td class="center"><input type="checkbox" class="checkbox checkmark" name="orders[]" value="<?php echo $order_id;?>"></td>
                <td><img src="<?php echo image($order[thumb]); ?>" width="50" height="50"></td>
                <td>
                    <h3 class="title"><a href="<?php echo U('m=item&c=item&itemid='.$order[itemid]); ?>" target="_blank"><?php echo $order[title];?></a></h3>
                    <p class="subtitle">
                        <span><?php echo $order[order_no];?> |</span>
                        <a href="<?php echo U('m=shop&c=viewshop&shop_id='.$order[shop_id]); ?>" target="_blank"><?php echo $order[seller_name];?></a>
                    </p>
                </td>
                <td><?php echo $order[buyer_name];?></td>
                <td><?php echo formatAmount($order[order_fee]); ?></td>
                <td><?php echo @date('Y-m-d H:i:s',$order[create_time]); ?></td>
                <td><?php echo $order[order_status];?></td>
                <td><a href="<?php echo U('c=order&a=detail&order_id='.$order[order_id]); ?>" target="_blank">查看</a></td>
            </tr>
            <?php } } ?>            </tbody>
            <tfoot>
            <tr>
                <td colspan="15">
                    <div class="pagination float-right"><?php echo $pages;?></div>
                    <label><input type="checkbox" class="checkbox checkall"> <?php echo $_lang[selectall];?></label>
                    <label><button type="button" class="btn" id="deleteOrderButton">删除订单</button></label>
                    <label><button type="button" class="btn" onclick="DSXUtil.reFresh()">刷新</button></label>
                </td>
            </tr>
            </tfoot>
        </table>
    </form>
</div>
<iframe id="J_frame" src="" style="display: none;"></iframe>
<script type="text/javascript">
    var waiting = null;
    function downloadOrder() {
        $("#searchFrom").ajaxSubmit({
            dataType:'json',
            success:function (response) {
                if (response.errcode == 0){
                    setTimeout(function () {
                        downloadOrder();
                    }, 500);
                }else {
                    waiting.close();
                    $("#J_frame").attr('src', "<?php echo U('c=order&a=get_excel'); ?>");
                }
            }
        });
    }
    $(function () {
        $(function () {
            $("#btn-search").on('click', function () {
                $("#J_a").val('index');
                $("#searchFrom").submit();
            });
            $("#btn-export").on('click', function () {
                DSXUI.showConfirm('导出订单','订单下载过程可能需要花费几分钟，在此期间请不要关闭页面。',function () {
                    waiting = DSXUI.showloading('正在导出数据...');
                    $("#J_a").val('download');
                    downloadOrder();
                });
            });
        });

        $("#deleteOrderButton").on('click', function () {
            var spinner = null;
            if ($("input.checkmark:checked").length == 0){
                DSXUI.error('请选择订单');
                return false;
            }
            DSXUI.showConfirm('删除订单','确认要删除所选订单吗?', function () {
                $("#J_eventType").val('delete');
                $("#listForm").ajaxSubmit({
                    beforeSend:function () {
                         spinner = DSXUI.showSpinner();
                    },
                    success:function (response) {
                        setTimeout(function () {
                            spinner.close();
                            DSXUtil.reFresh();
                        }, 500);
                    }
                });
            });
        });
    });
</script><?php include template('footer'); ?>