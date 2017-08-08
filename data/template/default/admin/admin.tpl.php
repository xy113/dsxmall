<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="wellcome-div">
    <div class="txt"><?php echo $_G[username];?>, 欢迎你!</div>
</div>
<div class="mcenter-content-div" style="height:120px;">
    <div class="headimg-div">
        <div class="avatar"><img src="<?php echo avatar($_G[uid]); ?>"></div>
        <div class="a-setting"><a href="/?m=$_G[m]&c=setting&a=modiinfo">设置头像</a></div>
    </div>
    <div class="user-account">
        <div class="row">
            <div class="item">用户角色：<i><?php echo $_G[group][title];?></i></div>
            <div class="item">上次登录：<i><?php echo @date('Y-m-d H:i:s', $last_login[dateline]); ?></i></div>
            <div class="item">账户状态：<i>正常</i></div>
        </div>
        <div class="row">
            <div class="item"><a href="/?m=<?php echo $_G[m];?>&c=setting&a=userinfo"><span class="icon">&#xf0199;</span>修改个人资料</a></div>
            <div class="item"><a href="/?m=usercenter&c=setting&a=security"><span class="icon">&#xf00a2;</span>手机已绑定</a></div>
            <div class="item"><a href="/?m=usercenter&c=setting&a=security"><span class="icon">&#xf0138;</span>邮箱已绑定</a></div>
        </div>
    </div>
</div>

<div class="mcenter-content-div">
    <div class="console-title"><strong>每日任务</strong></div>
</div>

<div class="content-div">
    <table cellpadding="0" cellspacing="0" width="100%" class="tasktable">
        <tbody>
        <tr>
            <td>未定位电梯: <a class="n"><?php echo $lift_unlocation_count;?></a></td>
            <td>即将到期电梯: <a class="n"><?php echo $lift_due_count;?></a></td>
            <td>即将到期合同: <a class="n">0</a></td>
            <td>即将到期保险: <a class="n">0</a></td>
        </tr>
        </tbody>
    </table>
</div><?php include template('footer'); ?>