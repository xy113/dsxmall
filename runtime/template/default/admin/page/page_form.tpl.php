<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="console-title">
    <div class="float-right">
        <a href="<?php echo U('c=page&a=category'); ?>" class="button">分类管理</a>
        <a href="<?php echo U("c=page&a=itemlist&catid=$catid"); ?>" class="button">返回列表</a>
    </div>
    <h2><?php if($G[a]=='add') { ?>添加页面<?php } else { ?>编辑页面<?php } ?></h2>
</div>
<div class="content-div">
    <form method="post" action="" id="pageForm">
        <input type="hidden" name="formsubmit" value="yes" />
        <input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
            <tr>
                <td width="60">标题</td>
                <td><input type="text" title="" id="title" class="input-text w300" name="newpage[title]" value="<?php echo $page[title];?>"></td>
                <td width="60">别名</td>
                <td><input type="text" title="" class="input-text w300" name="newpage[alias]" value="<?php echo $page[alias];?>"></td>
            </tr>
            <tr>
                <td>分类</td>
                <td>
                    <select name="newpage[catid]" class="select w300" title="">
                        <?php if(is_array($categorylist)) { foreach($categorylist as $clist) { ?>                        <option value="<?php echo $clist[pageid];?>"<?php if($page[catid]==$clist[pageid]) { ?> selected<?php } ?>><?php echo $clist[title];?></option>
                        <?php } } ?>                    </select>
                </td>
                <td>模板</td>
                <td><input type="text" title="" class="input-text w300" name="newpage[template]" value="<?php echo $page[template];?>"></td>
            </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
            <tr>
                <td width="60">摘要</td>
                <td><textarea style="width:100%;" name="newpage[summary]"><?php echo $page[summary];?></textarea></td>
             </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
            <tr>
                <td width="60">内容</td>
                <td><div style="box-sizing:border-box"><?php include template('editor'); ?></div></td>
            </tr>
            <tr>
                <td></td>
                <td><button type="submit" class="button button-long">发布</button></td>
            </tr>
        </table>
    </form>
</div>
<script type="text/javascript">
    $("#pageForm").on('submit', function () {
        var title = $.trim($("#title").val());
        if (!title){
            DSXUI.error('请填写标题');
            return false;
        }
    });
</script><?php include template('footer'); ?>