<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="navigation">
    <a>后台管理</a>
    <span>></span>
    <a>商品管理</a>
    <span>></span>
    <a>商品列表</a>
</div>
<div class="search-container">
    <form method="get" id="searchFrom">
        <input type="hidden" name="m" value="<?php echo $_G[m];?>">
        <input type="hidden" name="c" value="<?php echo $_G[c];?>">
        <input type="hidden" name="a" value="<?php echo $_G[a];?>" id="J_a">
        <div class="row">
            <div class="cell">
                <label>店铺名称:</label>
                <div class="field"><input type="text" title="" class="input-text" name="shop_name" value="<?php echo $shop_name;?>"></div>
            </div>
            <div class="cell">
                <label>卖家账号:</label>
                <div class="field"><input type="text" title="" class="input-text" name="seller_name" value="<?php echo $seller_name;?>"></div>
            </div>
            <div class="cell">
                <label>销售状态:</label>
                <div class="field">
                    <select title="" class="select" name="sale_status">
                        <option value="0">全部</option>
                        <option value="on_sale"<?php if($sale_status=='on_sale') { ?> selected<?php } ?>>出售中</option>
                        <option value="off_sale"<?php if($sale_status=='off_sale') { ?> selected<?php } ?>>已下架</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="cell">
                <label>产品名称:</label>
                <div class="field"><input type="text" title="" class="input-text" name="title" value="<?php echo $title;?>"></div>
            </div>
            <div class="cell" style="width: auto;">
                <label>价格区间:</label>
                <div class="field">
                    <input type="text" title="" class="input-text" name="min_price" value="<?php echo $min_price;?>"> -
                    <input type="text" title="" class="input-text" name="max_price" value="<?php echo $max_price;?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="cell">
                <label>商品ID:</label>
                <div class="field"><input type="text" title="" class="input-text" name="itemid" value="<?php echo $itemid;?>"></div>
            </div>
        </div>
        <div class="row">
            <div class="cell">
                <label></label>
                <div class="field">
                    <button type="submit" class="button">搜索</button>
                    <button type="reset" class="button button-cancel">重置</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="content-div">
    <form method="post" id="listForm" autocomplete="off">
        <input type="hidden" name="formsubmit" value="yes">
        <input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>">
        <input type="hidden" name="eventType" value="" id="J_eventType">
        <table cellpadding="0" cellspacing="0" border="0" width="100%" class="listtable">
            <thead>
            <tr>
                <th width="20"><input type="checkbox" class="checkbox checkall"></th>
                <th width="80">图片</th>
                <th>商品名称|卖家</th>
                <th>价格</th>
                <th>销量</th>
                <th width="80">状态</th>
                <th width="140">上架时间</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($itemlist)) { foreach($itemlist as $item) { ?>            <?php $itemid=$item[itemid]; ?>            <tr id="row_<?php echo $id;?>">
                <td><input type="checkbox" class="checkbox checkmark" name="items[]" value="<?php echo $itemid;?>"></td>
                <td><a href="<?php echo U('m=item&c=item&itemid='.$itemid); ?>" target="_blank"><div class="bg-cover" style="background-image: url(<?php echo image($item[thumb]); ?>); width: 80px; height: 80px;"></div></a></td>
                <td>
                    <h3 class="title"><a href="<?php echo U('m=item&c=item&itemid='.$itemid); ?>" target="_blank"><?php echo $item[title];?></a></h3>
                    <p class="subtitle"><a href="<?php echo U('m=shop&c=viewshop&shop_id='.$item['shop_id']); ?>" target="_blank"><?php echo $item[shop_name];?></a></p>
                </td>
                <td><p><strong style="color: #f40;"><?php echo $item[price];?></strong></p></td>
                <td><?php echo $item[sold];?></td>
                <td>
                    <?php if($item[on_sale]) { ?>
                    出售中
                    <?php } else { ?>
                    已下架
                    <?php } ?>
                </td>
                <td><?php echo @date('Y-m-d H:i:s',$item[create_time]); ?></td>
            </tr>
            <?php } } ?>            </tbody>
            <tfoot>
            <tr>
                <td colspan="20">
                    <div class="pagination float-right"><?php echo $pages;?></div>
                    <label><input type="checkbox" class="checkbox checkall"> 全选</label>
                    <label><button type="button" class="btn btn-action" data-action="delete">删除</button></label>
                    <label><button type="button" class="btn btn-action" data-action="on_sale">上架</button></label>
                    <label><button type="button" class="btn btn-action" data-action="off_sale">下架</button></label>
                    <label><button type="button" class="btn btn-action" data-action="recommend">首页推荐</button></label>
                </td>
            </tr>
            </tfoot>
        </table>
    </form>
</div>
<script type="text/javascript">
    $(function () {
        $(".btn-action").on('click', function () {
            if ($(".checkmark:checked").length === 0){
                DSXUI.error('请选择商品');
                return false;
            }
            var spinner = null;
            var eventType = $(this).attr('data-action');
            var submitForm = function () {
                $("#listForm").ajaxSubmit({
                    dataType:'json',
                    beforeSend:function () {
                        spinner = DSXUI.showSpinner();
                    },
                    success:function (response) {
                        setTimeout(function () {
                            spinner.close();
                            if (response.errcode == 0){
                                DSXUtil.reFresh();
                            }else {
                                DSXUI.error(response.errmsg);
                            }
                        }, 500);
                    }
                });
            }
            $("#J_eventType").val(eventType);
            if (eventType === 'delete'){
                DSXUI.showConfirm('删除商品','确认要删除所选商品吗?', function () {
                     submitForm();
                });
            }else {
                submitForm();
            }
        });
    });
</script><?php include template('footer'); ?>