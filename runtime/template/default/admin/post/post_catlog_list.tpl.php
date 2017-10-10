<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="console-title">
    <a href="<?php echo U('c=postcatlog&a=add'); ?>" class="button float-right">添加新分类</a>
    <h2>文章管理 > 分类管理</h2>
</div>
<div class="content-div">
    <form method="post" action="">
        <input type="hidden" name="formsubmit" value="yes" />
        <input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
            <thead>
            <tr>
                <th width="60">ID</th>
                <th width="60" style="text-align: center;">图标</th>
                <th>分类名称</th>
                <th width="100">标识</th>
                <th width="80">显示顺序</th>
                <th width="50" class="align-center">可选</th>
                <th width="50" class="align-center">可用</th>
                <th width="80">选项</th>
            </tr>
            </thead>
            <?php if(is_array($catloglist[0])) { foreach($catloglist[0] as $catid_1=>$catlog_1) { ?>            <tbody id="catlog_<?php echo $catid_1;?>">
            <tr>
                <td width="60"><?php echo $catid_1;?></td>
                <td width="60" style="text-align: center;"><img src="<?php echo image($catlog_1[icon]); ?>" width="30" height="30" rel="pickimage" data-id="<?php echo $catid_1;?>"></td>
                <td><input type="text" title="" class="input-text" name="catloglist[<?php echo $catid_1;?>][name]" value="<?php echo $catlog_1[name];?>" maxlength="10" style="font-weight:bold;"></td>
                <td width="100"><input type="text" title="" class="input-text w100"  name="catloglist[<?php echo $catid_1;?>][identifer]" value="<?php echo $catlog_1[identifer];?>"></td>
                <td width="80"><input type="number" title="" class="input-text w60"  name="catloglist[<?php echo $catid_1;?>][displayorder]" value="<?php echo $catlog_1[displayorder];?>"></td>
                <td width="50" class="center"><input type="checkbox" title="" class="checkbox" name="catloglist[<?php echo $catid_1;?>][enable]" value="1"<?php if($catlog_1[enable]) { ?> checked="checked"<?php } ?>></td>
                <td width="50" class="center"><input type="checkbox" title="" class="checkbox" name="catloglist[<?php echo $catid_1;?>][available]" value="1"<?php if($catlog_1[available]) { ?> checked="checked"<?php } ?>></td>
                <td width="40">
                    <a href="<?php echo U('c=postcatlog&a=edit&catid='.$catid_1); ?>" class="edit">编辑</a>
                    <a href="<?php echo U('c=postcatlog&a=delete&catid='.$catid_1); ?>">删除</a>
                </td>
            </tr>
            </tbody>
            <?php if(is_array($catloglist[$catid_1])) { foreach($catloglist[$catid_1] as $catid_2=>$catlog_2) { ?>            <tbody id="catlog_<?php echo $catid_2;?>">
            <tr>
                <td width="60"><?php echo $catid_2;?></td>
                <td width="60" class="align-center"><img src="<?php echo image($catlog_2[icon]); ?>" width="30" height="30" rel="pickimage" data-id="<?php echo $catid_2;?>"></td>
                <td>
                    <div class="catlog">
                        <input type="text" title="" class="input-text" name="catloglist[<?php echo $catid_2;?>][name]" value="<?php echo $catlog_2[name];?>" maxlength="10">
                    </div>
                </td>
                <td width="100"><input type="text" title="" class="input-text w100"  name="catloglist[<?php echo $catid_2;?>][identifer]" value="<?php echo $catlog_2[identifer];?>"></td>
                <td width="80"><input type="number" title="" class="input-text w60"  name="catloglist[<?php echo $catid_2;?>][displayorder]" value="<?php echo $catlog_2[displayorder];?>"></td>
                <td width="50" class="center"><input type="checkbox" title="" class="checkbox" name="catloglist[<?php echo $catid_2;?>][enable]" value="1"<?php if($catlog_2[enable]) { ?> checked="checked"<?php } ?>></td>
                <td width="50" class="center"><input type="checkbox" title="" class="checkbox" name="catloglist[<?php echo $catid_2;?>][available]" value="1"<?php if($catlog_2[available]) { ?> checked="checked"<?php } ?>></td>
                <td width="40">
                    <a href="<?php echo U('c=postcatlog&a=edit&catid='.$catid_2); ?>">编辑</a>
                    <a href="<?php echo U('c=postcatlog&a=delete&catid='.$catid_2); ?>">删除</a>
                </td>
            </tr>
            </tbody>
            <?php if(is_array($catloglist[$catid_2])) { foreach($catloglist[$catid_2] as $catid_3=>$catlog_3) { ?>            <tbody id="catlog_<?php echo $catid_3;?>">
            <tr>
                <td width="60"><?php echo $catid_3;?></td>
                <td width="60" class="align-center"><img src="<?php echo image($catlog_3[icon]); ?>" width="30" height="30" rel="pickimage" data-id="<?php echo $catid_3;?>"></td>
                <td>
                    <div class="catlog">
                        <div class="catlog">
                            <input type="text" title="" class="input-text" name="catloglist[<?php echo $catid_3;?>][name]" value="<?php echo $catlog_3[name];?>" maxlength="10">
                        </div>
                    </div>
                </td>
                <td width="100"><input type="text" title="" class="input-text w100"  name="catloglist[<?php echo $catid_3;?>][identifer]" value="<?php echo $catlog_3[identifer];?>"></td>
                <td width="80"><input type="number" title="" class="input-text w60"  name="catloglist[<?php echo $catid_3;?>][displayorder]" value="<?php echo $catlog_3[displayorder];?>"></td>
                <td width="50" class="center"><input title="" type="checkbox" class="checkbox" name="catloglist[<?php echo $catid_3;?>][enable]" value="1"<?php if($catlog_3[enable]) { ?> checked="checked"<?php } ?>></td>
                <td width="50" class="center"><input title="" type="checkbox" class="checkbox" name="catloglist[<?php echo $catid_3;?>][available]" value="1"<?php if($catlog_3[available]) { ?> checked="checked"<?php } ?>></td>
                <td width="40">
                    <a href="<?php echo U('c=postcatlog&a=edit&catid='.$catid_3); ?>">编辑</a>
                    <a href="<?php echo U('c=postcatlog&a=delete&catid='.$catid_3); ?>">删除</a>
                </td>
            </tr>
            </tbody>
            <?php } } ?>            <?php } } ?>            <?php } } ?>            <tfoot>
            <tr>
                <td colspan="10">
                    <label><button type="submit" class="button">保存</button></label>
                    <label><button type="button" class="button button-cancel" onclick="DSXUtil.reFresh()">刷新</button></label>
                </td>
            </tr>
            </tfoot>
        </table>
    </form>
</div>
<script type="text/javascript">
    $(function () {
        $("a[rel=delete]").on('click', function () {
            DSXUI.showConfirm('删除分类', '确认要删除分类吗?', function () {
                $.ajax({
                    url:"<?php echo U('c=postcatlog'); ?>"
                });
            });
        });
        $("img[rel=pickimage]").on('click', function () {
            var self = this;
            var catid = $(this).attr('data-id');
            DSXUI.showImagePicker(function (data) {
                $(self).attr('src', data.imageurl);
                $.post("<?php echo U('c=postcatlog&a=seticon'); ?>", {catid:catid,icon:data.image});
            });
        });
    });
</script><?php include template('footer'); ?>