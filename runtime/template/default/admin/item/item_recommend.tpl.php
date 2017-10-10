<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="navigation">
    <a>后台管理</a>
    <span>></span>
    <a>商品管理</a>
    <span>></span>
    <a>首页推荐</a>
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
                <th>宝贝名称</th>
                <th>价格</th>
                <th>销量</th>
                <th width="80">状态</th>
                <th width="140">创建时间</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($itemlist)) { foreach($itemlist as $item) { ?>            <?php $itemid=$item[itemid]; ?>            <tr id="row_<?php echo $id;?>">
                <td><input type="checkbox" class="checkbox checkmark" name="items[]" value="<?php echo $itemid;?>"></td>
                <td><a href="<?php echo U('m=item&c=item&itemid='.$itemid); ?>" target="_blank"><div class="bg-cover" style="background-image: url(<?php echo image($item[thumb]); ?>); width: 80px; height: 80px;"></div></a></td>
                <td><h3 class="title"><a href="<?php echo U('m=item&c=item&itemid='.$itemid); ?>" target="_blank"><?php echo $item[title];?></a></h3></td>
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
                    <label><button type="button" class="btn" id="deleteButton">删除</button></label>
                    <label><button type="button" class="btn" id="addButton">添加宝贝</button></label>
                </td>
            </tr>
            </tfoot>
        </table>
    </form>
</div>
<script type="text/javascript">
    $(function () {
        $("#deleteButton").on('click', function () {
            if ($(".checkmark:checked").length === 0){
                DSXUI.error('请选择商品');
                return false;
            }
            DSXUI.showConfirm('删除商品','确认要删除所选商品吗?', function () {
                $("#listForm").submit();
            });
        });
        $("#addButton").on('click', function () {
            var content = '<div style="text-align: center; padding: 20px;">' +
                '<span>商品ID: </span>' +
                '<input type="text" class="input-text" id="J_itemId"> ' +
                '</div>';
            DSXUI.dialog({
                title:'添加推荐商品',
                content:content,
                hideFooter:false,
                onConfirm:function (dlg) {
                    var itemid = $("#J_itemId").val();
                    if (!itemid) {
                        DSXUI.error('请填写商品ID');
                        return false;
                    }
                    $.ajax({
                        type:'POST',
                        data:{itemid:itemid},
                        url:"<?php echo U('c=item&a=add_recommend'); ?>",
                        dataType:'json',
                        success:function (response) {
                            dlg.close();
                            if (response.errcode == 0){
                                DSXUI.success('宝贝添加成功');
                            }
                        }
                    });
                }
            });
        });
    });
</script><?php include template('footer'); ?>