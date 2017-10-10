<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><script src="/static/DatePicker/WdatePicker.js" type="text/javascript"></script>
<div class="navigation">
    <a>后台管理</a>
    <span>></span>
    <a>会员管理</a>
    <span>></span>
    <a>会员列表</a>
</div>
<div class="search-container">
    <form method="get" id="searchFrom">
        <input type="hidden" name="m" value="<?php echo $_G[m];?>">
        <input type="hidden" name="c" value="<?php echo $_G[c];?>">
        <input type="hidden" name="a" value="<?php echo $_G[a];?>" id="J_a">
        <div class="row">
            <div class="cell">
                <label>用户名:</label>
                <div class="field"><input type="text" title="" class="input-text" name="username" value="<?php echo $username;?>"></div>
            </div>
            <div class="cell">
                <label>手机号:</label>
                <div class="field"><input type="text" title="" class="input-text" name="mobile" value="<?php echo $mobile;?>"></div>
            </div>
            <div class="cell">
                <label>邮箱:</label>
                <div class="field"><input type="text" title="" class="input-text" name="email" value="<?php echo $email;?>"></div>
            </div>
        </div>
        <div class="row">
            <div class="cell">
                <label>会员ID:</label>
                <div class="field"><input type="text" title="" class="input-text" name="uid" value="<?php echo $uid;?>"></div>
            </div>
            <div class="cell">
                <label>注册日期:</label>
                <div class="field">
                    <input type="text" title="" class="input-text" name="reg_time_begin" onclick="WdatePicker()" value="<?php echo $reg_time_begin;?>" style="width: 100px;"> -
                    <input type="text" title="" class="input-text" name="reg_time_end" onclick="WdatePicker()" value="<?php echo $reg_time_end;?>" style="width: 100px;">
                </div>
            </div>
            <div class="cell">
                <label>最后登录:</label>
                <div class="field">
                    <input type="text" title="" class="input-text" name="last_visit_begin" onclick="WdatePicker()" value="<?php echo $last_visit_begin;?>" style="width: 100px;"> -
                    <input type="text" title="" class="input-text" name="last_visit_end" onclick="WdatePicker()" value="<?php echo $last_visit_end;?>" style="width: 100px;">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="cell">
                <label></label>
                <div class="field">
                    <button type="submit" class="button" id="btn-search">搜索</button>
                    <button type="button" class="button button-cancel" id="btn-export">重置</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="content-div">
    <form method="post" id="listForm" action="">
        <input type="hidden" name="formsubmit" value="yes">
        <input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>" />
        <input type="hidden" name="eventType" value="" id="J_eventType">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
            <thead>
            <tr>
                <th width="20">选</th>
                <th width="30">头像</th>
                <th>姓名</th>
                <th>手机号</th>
                <th>电子邮箱</th>
                <th>用户组</th>
                <th>注册日期</th>
                <th>最后登录</th>
                <th>状态</th>
            </tr>
            </thead>
            <tbody id="members">
            <?php if(is_array($memberlist)) { foreach($memberlist as $uid=>$member) { ?>            <?php $uid=$member[uid]; ?>            <?php $status_name=$_lang[member_status][$member[status]]; ?>            <?php $isfounder=in_array($uid, C('FOUNDERS'));; ?>            <tr>
                <td><input title="" type="checkbox" class="checkbox checkmark"<?php if($isfounder) { ?> disabled="disabled"<?php } else { ?> name="members[]" value="<?php echo $uid;?>"<?php } ?> /></td>
                <td><img src="<?php echo avatar($uid,'small'); ?>" width="30" height="30" style="border-radius:100%;"></td>
                <th><a><?php echo $member[username];?></a></th>
                <td><?php echo $member[mobile];?></td>
                <td><?php echo $member[email];?></td>
                <td><?php echo $grouplist[$member[gid]][title];?></td>
                <td><a href="http://ip.taobao.com/?ip=<?php echo $member[regip];?>" target="_blank"><?php echo @date('Y-m-d H:i:s',$member[regdate]); ?></a></td>
                <td><a href="http://ip.taobao.com/?ip=<?php echo $member[lastvisitip];?>" target="_blank"><?php echo @date('Y-m-d H:i:s',$member[lastvisit]); ?></a></td>
                <td><?php echo $status_name;?></td>
            </tr>
            <?php } } ?>            </tbody>
            <tfoot>
            <tr>
                <td colspan="12">
                    <div class="pagination float-right"><?php echo $pagination;?></div>
                    <label><input type="checkbox" class="checkbox checkall" /> 全选</label>
                    <label><button type="button" class="btn btn-action" data-action="delete">删除</button></label>
                    <label><button type="button" class="btn btn-action" data-action="allow">允许登录</button></label>
                    <label><button type="button" class="btn btn-action" data-action="forbiden">禁止登录</button></label>
                </td>
            </tr>
            </tfoot>
        </table>
    </form>
</div>
<script type="text/javascript">
    $(function () {
        $(".btn-action").on('click', function () {
            var spinner = null;
            var action = $(this).attr('data-action');
            var submitForm = function () {
                $("#listForm").ajaxSubmit({
                    dataType:'json',
                    beforeSend:function () {
                        spinner = DSXUI.showSpinner();
                    },success:function (response) {
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
            $("#J_eventType").val(action);
            if (action === 'delete'){
                DSXUI.showConfirm('删除会员', '确认要删除所选会员吗?', function () {
                    submitForm();
                });
            }else {
                submitForm();
            }
        });
    });
</script><?php include template('footer'); ?>