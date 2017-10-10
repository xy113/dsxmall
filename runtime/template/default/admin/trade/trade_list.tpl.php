<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><script src="/static/DatePicker/WdatePicker.js" type="text/javascript"></script>
<div class="navigation">
    <a>后台管理</a>
    <span>></span>
    <a>交易管理</a>
    <span>></span>
    <a>交易记录</a>
</div>
<div class="search-container">
    <form method="get" id="searchFrom">
        <input type="hidden" name="m" value="<?php echo $_G[m];?>">
        <input type="hidden" name="c" value="<?php echo $_G[c];?>">
        <input type="hidden" name="a" value="<?php echo $_G[a];?>" id="J_a">
        <div class="row">
            <div class="cell">
                <label>交易名称:</label>
                <div class="field"><input type="text" class="input-text" name="trade_name" value="<?php echo $trade_name;?>"></div>
            </div>
            <div class="cell">
                <label>付款方:</label>
                <div class="field"><input type="text" class="input-text" name="payer_name" value="<?php echo $payer_name;?>"></div>
            </div>
            <div class="cell">
                <label>收款方:</label>
                <div class="field"><input type="text" class="input-text" name="payee_name" value="<?php echo $payee_name;?>"></div>
            </div>
        </div>
        <div class="row">
            <div class="cell">
                <label>付款状态:</label>
                <div class="field">
                    <select class="select" name="pay_status">
                        <option value="0">全部</option>
                        <option value="PAID"<?php if($pay_status=='PAID') { ?> selected<?php } ?>>已支付</option>
                        <option value="UNPAID"<?php if($pay_status=='UNPAID') { ?> selected<?php } ?>>未支付</option>
                    </select>
                </div>
            </div>
            <div class="cell">
                <label>付款金额:</label>
                <div class="field">
                    <input type="text" class="input-text" name="min_fee" value="<?php echo $min_fee;?>" style="width: 100px;"> -
                    <input type="text" class="input-text" name="max_fee" value="<?php echo $max_fee;?>" style="width: 100px;">
                </div>
            </div>
            <div class="cell">
                <label>支付方式:</label>
                <div class="field">
                    <select class="select" name="pay_type">
                        <option value="0">全部</option>
                        <option value="balance"<?php if($pay_type=='balance') { ?> selected<?php } ?>>余额支付</option>
                        <option value="wxpay"<?php if($pay_type=='wxpay') { ?> selected<?php } ?>>微信支付</option>
                        <option value="alipay"<?php if($pay_type=='alipay') { ?> selected<?php } ?>>支付宝支付</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="cell">
                <label>交易流水:</label>
                <div class="field"><input type="text" class="input-text" name="trade_no" value="<?php echo $trade_no;?>"></div>
            </div>
            <div class="cell" style="width: auto;">
                <label>交易时间:</label>
                <div class="field">
                    <input type="text" class="input-text" name="time_begin" onclick="WdatePicker()" value="<?php echo $time_begin;?>" style="width: 100px;"> -
                    <input type="text" class="input-text" name="time_end" onclick="WdatePicker()" value="<?php echo $time_end;?>" style="width: 100px;">
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
        <div class="tab<?php if($tab=='all') { ?> on<?php } ?>"><a href="<?php echo U('c=trade&a=itemlist&tab=all'); ?>">全部</a><span>|</span></div>
        <div class="tab<?php if($tab=='paid') { ?> on<?php } ?>"><a href="<?php echo U('c=trade&a=itemlist&tab=paid'); ?>">已支付</a><span>|</span></div>
        <div class="tab<?php if($tab=='unpaid') { ?> on<?php } ?>"><a href="<?php echo U('c=trade&a=itemlist&tab=unpaid'); ?>">未支付</a></div>
    </div>
</div>

<div class="content-div">
    <form method="post" id="listForm" autocomplete="off">
        <input type="hidden" name="formsubmit" value="yes" />
        <input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>">
        <input type="hidden" name="eventType" id="J_eventType" value="delete">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
            <thead>
            <tr>
                <th width="40" class="center">选?</th>
                <th width="50">头像</th>
                <th>名称 | 流水 | 收款方账户</th>
                <th>付款账户</th>
                <th width="100">金额</th>
                <th width="140">时间</th>
                <th width="60">状态</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($itemlist)) { foreach($itemlist as $item) { ?>            <?php $trade_id=$item[trade_id]; ?>            <tr>
                <td class="center"><input type="checkbox" class="checkbox checkmark" name="trades[]" value="<?php echo $trade_id;?>"></td>
                <td><img src="<?php echo avatar($item[payer_uid]); ?>" width="30" height="30"></td>
                <td>
                    <h3 class="title"><?php echo $item[trade_name];?></h3>
                    <p class="subtitle">
                        <span><?php echo $item[trade_no];?> |</span>
                        <a href="<?php echo U('m=shop&c=viewshop&uid='.$item['payee_uid']); ?>" target="_blank"><?php echo $item[payee_name];?></a>
                    </p>
                </td>
                <td><?php echo $item[payer_name];?></td>
                <td><?php echo formatAmount($item[trade_fee]); ?></td>
                <td><?php echo @date('Y-m-d H:i:s',$item[trade_time]); ?></td>
                <td><?php echo $_lang[trade_status][$item[trade_status]];?></td>
            </tr>
            <?php } } ?>            </tbody>
            <tfoot>
            <tr>
                <td colspan="10">
                    <span class="pagination float-right"><?php echo $pages;?></span>
                    <label><input type="checkbox" class="checkbox checkall"> <?php echo $_lang[selectall];?></label>
                    <label><input type="button" class="btn" value="删除" id="btn-delete"></label>
                    <label><input type="button" class="btn" value="刷新" onclick="DSXUtil.reFresh()"></label>
                </td>
            </tr>
            </tfoot>
        </table>
    </form>
</div>
<iframe id="J_frame" src="" style="display: none;"></iframe>
<script type="text/javascript">
    $(function () {
        $("#btn-search").on('click', function () {
            $("#J_a").val('itemlist');
            $("#searchFrom").submit();
        });
        $("#btn-export").on('click', function () {
            var waiting = null;
            DSXUI.showConfirm('下载交易记录', '交易记录下载过程可能需要几分钟时间，在此期间请不要关闭页面', function () {
                $("#J_a").val('export');
                $("#searchFrom").ajaxSubmit({
                    beforeSend:function () {
                        waiting = DSXUI.showloading('正在导出数据...');
                    },
                    success:function (response) {
                        if (response.errcode === 0){
                            waiting.close();
                            $("#J_frame").attr('src', "<?php echo U('c=trade&a=download'); ?>");
                        }
                    }
                });
            });
        });
        $("#btn-delete").on('click', function () {
            if ($("input.checkmark:checked").length === 0){
                DSXUI.error('请选择记录');
                return false;
            }
            DSXUI.showConfirm('删除记录', '确认要删除所选记录吗?', function () {
                var spinner = null;
                $("#J_eventType").val('delete');
                $("#listForm").ajaxSubmit({
                    beforeSend:function () {
                        spinner = DSXUI.showSpinner();
                    },success:function (response) {
                        setTimeout(function () {
                            if (response.errcode === 0){
                                spinner.close();
                                DSXUtil.reFresh();
                            }
                        }, 500);
                    }
                });
            });
        });
    });
</script><?php include template('footer'); ?>