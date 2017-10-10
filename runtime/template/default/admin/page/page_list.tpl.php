<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="console-title">
    <div class="float-right">
        <a href="<?php echo U('c=page&a=add&catid='.$catid); ?>" class="button">添加页面</a>
    </div>
    <h2>页面管理</h2>
</div>

<div class="tabs-container">
    <div class="tabs">
        <div class="tab<?php if(!$catid) { ?> on<?php } ?>"><a href="<?php echo U('c=page'); ?>">全部</a><span>|</span></div>
        <?php if(is_array($categorylist)) { foreach($categorylist as $clist) { ?>        <div class="tab<?php if($catid==$clist[pageid]) { ?> on<?php } ?>"><a href="<?php echo U('c=page&catid='.$clist[pageid]); ?>"><?php echo $clist[title];?></a><span>|</span></div>
        <?php } } ?>    </div>
</div>

<div class="content-div">
    <form method="post" action="" id="listForm">
        <input type="hidden" name="formsubmit" value="yes" />
        <input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
            <thead>
            <tr>
                <th width="40">删?</th>
                <th>标题</th>
                <th>别名</th>
                <th width="80">排序</th>
                <th width="120">发布时间</th>
                <th width="120">最后修改</th>
                <th width="40">编辑</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($pagelist)) { foreach($pagelist as $item) { ?>            <?php $pageid=$item[pageid]; ?>            <tr>
                <td><input type="checkbox" class="checkbox checkmark itemCheckBox" name="delete[]" value="<?php echo $pageid;?>"></td>
                <th><a href="<?php echo U('m=page&c=detail&pageid='.$pageid); ?>" target="_blank"><?php echo $item[title];?></a></th>
                <td><?php echo $item[alias];?></td>
                <td><input type="text" class="input-text w60" name="pagelist[<?php echo $pageid;?>][displayorder]" value="<?php echo $item[displayorder];?>" /></td>
                <td><?php echo @date('Y-m-d H:i',$item[pubtime]); ?></td>
                <td><?php echo @date('Y-m-d H:i',$item[modified]); ?></td>
                <td><a href="<?php echo U('c=page&a=edit&pageid='.$pageid); ?>">编辑</a></td>
            </tr>
            <?php } } ?>            </tbody>
            <tfoot>
            <tr>
                <td colspan="10">
                    <span class="pagination float-right"><?php echo $pagination;?></span>
                    <label><input type="checkbox" class="checkbox checkall"> 全选</label>
                    <label><button type="submit" class="btn">提交</button></label>
                    <label><button type="button" class="btn" onclick="DSXUtil.reFresh()">刷新</button></label>
                </td>
            </tr>
            </tfoot>
        </table>
    </form>
</div>
<script type="text/javascript">
$(function () {
    $("#deleteButton").on('click', function () {
        if ($(".itemCheckBox:checked").length === 0){
            DSXUI.error('请选择项目');
            return false;
        }
        var spinner = null;
        $("#listForm").ajaxSubmit({
            dataType:'json' ,
            beforeSend:function () {
                spinner = DSXUI.showSpinner();
            },success:function (response) {
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
    });
});
</script><?php include template('footer'); ?>