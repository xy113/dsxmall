<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="console-title">
    <div class="float-right">
        <form name="search" action="/?">
            <input type="hidden" name="m" value="<?php echo $_G[m];?>">
            <input type="hidden" name="c" value="<?php echo $_G[c];?>">
            <input type="hidden" name="a" value="<?php echo $_G[a];?>">
            <input type="hidden" name="searchType" value="0">
            <input type="text" title="" class="input-text" name="q" value="<?php echo $q;?>" placeholder="关键字">
            <label><button type="submit" class="button">快速搜索</button></label>
            <label><button type="button" class="button" onclick="$('#search-container').toggle()">高级搜索</button></label>
        </form>
    </div>
    <h2>文章管理->文章列表</h2>
</div>
<script src="/static/DatePicker/WdatePicker.js" type="text/javascript"></script>
<div class="search-container" id="search-container"<?php if(!$searchType) { ?> style="display: none;"<?php } ?>>
    <form method="get" id="searchFrom">
        <input type="hidden" name="m" value="<?php echo $_G[m];?>">
        <input type="hidden" name="c" value="<?php echo $_G[c];?>">
        <input type="hidden" name="a" value="<?php echo $_G[a];?>">
        <input type="hidden" name="searchType" value="1">
        <div class="row">
            <div class="cell">
                <label>文章标题:</label>
                <div class="field"><input type="text" title="" class="input-text" name="title" value="<?php echo $title;?>"></div>
            </div>
            <div class="cell">
                <label>用户:</label>
                <div class="field"><input type="text" title="" class="input-text" name="username" value="<?php echo $username;?>"></div>
            </div>
            <div class="cell">
                <label>目录分类:</label>
                <div class="field">
                    <select name="catid" class="select" title="">
                        <option value="">全部</option>
                        <?php if(is_array($catloglist[0])) { foreach($catloglist[0] as $catid1=>$cat1) { ?>                        <option value="<?php echo $catid1;?>"<?php if($catid==$catid1) { ?> selected<?php } ?>><?php echo $cat1[name];?></option>
                        <?php if(is_array($catloglist[$catid1])) { foreach($catloglist[$catid1] as $catid2=>$cat2) { ?>                        <option value="<?php echo $catid2;?>"<?php if($catid==$catid2) { ?> selected<?php } ?>>|--<?php echo $cat2[name];?></option>
                        <?php if(is_array($catloglist[$catid2])) { foreach($catloglist[$catid2] as $catid3=>$cat3) { ?>                        <option value="<?php echo $catid3;?>"<?php if($catid==$catid3) { ?> selected<?php } ?>>|--|--<?php echo $cat3[name];?></option>
                        <?php } } ?>                        <?php } } ?>                        <?php } } ?>                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="cell">
                <label>审核状态:</label>
                <div class="field">
                    <select name="status" class="select" title="">
                        <option value="">全部</option>
                        <?php if(is_array($_lang[post_status])) { foreach($_lang[post_status] as $k=>$v) { ?>                        <option value="<?php echo $k;?>"<?php if($status=="$k") { ?> selected<?php } ?>><?php echo $v;?></option>
                        <?php } } ?>                    </select>
                </div>
            </div>
            <div class="cell">
                <label>形式:</label>
                <div class="field">
                    <select name="type" class="select" title="">
                        <option value="">全部</option>
                        <?php if(is_array($_lang[post_types])) { foreach($_lang[post_types] as $k=>$v) { ?>                        <option value="<?php echo $k;?>"<?php if($type==$k) { ?> selected<?php } ?>><?php echo $v;?></option>
                        <?php } } ?>                    </select>
                </div>
            </div>
            <div class="cell">
                <label>发布时间:</label>
                <div class="field">
                    <input type="text" title="" class="input-text" name="time_begin" value="<?php echo $time_begin;?>" onclick="WdatePicker()" style="width: 100px;"> -
                    <input type="text" title="" class="input-text" name="time_end" value="<?php echo $time_end;?>" onclick="WdatePicker()" style="width: 100px;">
                </div>
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
    <form method="post" id="listForm">
        <input type="hidden" name="formsubmit" value="yes" />
        <input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>">
        <input type="hidden" name="eventType" id="J_eventType" value="">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
            <thead>
            <tr>
                <th width="40" class="center"><input title="全选" type="checkbox" class="checkbox checkall checkmark"></th>
                <th width="60">图片</th>
                <th>标题</th>
                <th>用户</th>
                <th>分类</th>
                <th>形式</th>
                <th>点击</th>
                <th>时间</th>
                <th>状态</th>
                <th width="45">编辑</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($itemlist)) { foreach($itemlist as $item) { ?>            <?php $aid=$item[aid]; ?>            <?php $type_name=$_lang['post_types'][$item['type']]; ?>            <?php $status_name=$_lang['post_status'][$item['status']]; ?>            <tr>
                <td class="center"><input type="checkbox" class="checkbox checkmark itemCheckBox" name="items[]" value="<?php echo $aid;?>"></td>
                <td><img src="<?php echo image($item[image]); ?>" width="50" height="50" rel="pickimage" data-id="<?php echo $aid;?>"></td>
                <th><a href="<?php echo U('m=post&c=detail&aid='.$aid); ?>" target="_blank"><?php echo $item[title];?></a></th>
                <td><?php echo $item[username];?></td>
                <td><?php echo $item[cat_name];?></td>
                <td><?php echo $type_name;?></td>
                <td><?php echo $item[view_num];?></td>
                <td><?php echo @date('Y-m-d H:i:s',$item[pubtime]); ?></td>
                <td><?php echo $status_name;?></td>
                <td><a href="<?php echo U('c=post&a=edit&aid='.$aid); ?>">编辑</a></td>
            </tr>
            <?php } } ?>            </tbody>
            <tfoot>
            <tr>
                <td colspan="10">
                    <div class="pagination float-right"><?php echo $pagination;?></div>
                    <label><input type="checkbox" class="checkbox checkall checkmark"> <?php echo $_lang[selectall];?></label>
                    <label><button type="button" class="btn btn-action" data-action="delete">删除</button></label>
                    <label><button type="button" class="btn btn-action" data-action="move">移动</button></label>
                    <label><button type="button" class="btn btn-action" data-action="review" data-value="pass">审核通过</button></label>
                    <label><button type="button" class="btn btn-action" data-action="review" data-value="refuse">审核不过</button></label>
                </td>
            </tr>
            </tfoot>
        </table>
    </form>
</div>
<script type="text/template" id="targetTpl">
    <span style="float: left; line-height: 28px;">选择目标分类：</span>
    <select name="target" class="select" title="" id="moveTarget">
        <?php if(is_array($catloglist[0])) { foreach($catloglist[0] as $catid1=>$cat1) { ?>        <option value="<?php echo $catid1;?>"><?php echo $cat1[name];?></option>
        <?php if(is_array($catloglist[$catid1])) { foreach($catloglist[$catid1] as $catid2=>$cat2) { ?>        <option value="<?php echo $catid2;?>">|--<?php echo $cat2[name];?></option>
        <?php if(is_array($catloglist[$catid2])) { foreach($catloglist[$catid2] as $catid3=>$cat3) { ?>        <option value="<?php echo $catid3;?>">|--|--<?php echo $cat3[name];?></option>
        <?php } } ?>        <?php } } ?>        <?php } } ?>    </select>
</script>
<script type="text/javascript">
    $(function () {
        var spinner;
        $("img[rel=pickimage]").on('click', function () {
            var self = this;
            var aid = $(this).attr('data-id');
            DSXUI.showImagePicker(function (data) {
                $(self).attr('src', data.imageurl);
                $.post("<?php echo U('c=post&a=setimage'); ?>", {aid:aid,image:data.image});
            });
        });
        $(".btn-action").on('click', function () {
            if ($(".itemCheckBox:checked").length === 0){
                DSXUI.error('请选择文章');
                return false;
            }
            var action = $(this).attr('data-action');
            if (action === 'delete'){
                DSXUI.showConfirm('删除文章', '确认要删除所选文章吗?', function () {
                    $("#listForm").ajaxSubmit({
                        url:"<?php echo U('c=post&a=delete'); ?>",
                        dataType:'json',
                        beforeSend:function () {
                            spinner = DSXUI.showSpinner();
                        },
                        success:function (response) {
                            setTimeout(function () {
                                spinner.close();
                                if (response.errcode === 0){
                                    DSXUtil.reFresh();
                                }else {
                                    DSXUI.error(response.errmsg);
                                }
                            }, 500);
                        }
                    });
                });
            }
            if (action === 'move'){
                DSXUI.dialog({
                    content:$("#targetTpl").html(),
                    title:'移动文章',
                    onConfirm:function (dlg) {
                        var target = $("#moveTarget").val();
                        dlg.close();
                        $("#listForm").ajaxSubmit({
                            url:"<?php echo U('c=post&a=move'); ?>",
                            dataType:'json',
                            data:{target:target},
                            beforeSend:function () {
                                spinner = DSXUI.showSpinner();
                            },
                            success:function (response) {
                                setTimeout(function () {
                                    spinner.close();
                                    if (response.errcode === 0){
                                        DSXUtil.reFresh();
                                    }else {
                                        DSXUI.error(response.errmsg);
                                    }
                                }, 500);
                            }
                        });
                    }
                });
            }
            if (action === 'review'){
                $("#listForm").ajaxSubmit({
                    url:"<?php echo U('c=post&a=review'); ?>",
                    dataType:'json',
                    data:{event:$(this).attr('data-value')},
                    beforeSend:function () {
                        spinner = DSXUI.showSpinner();
                    },
                    success:function (response) {
                        setTimeout(function () {
                            spinner.close();
                            if (response.errcode === 0){
                                DSXUtil.reFresh();
                            }else {
                                DSXUI.error(response.errmsg);
                            }
                        }, 500);
                    }
                });
            }
        });
    });
</script><?php include template('footer'); ?>