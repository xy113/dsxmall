<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="wellcome-div">
    <div class="txt"><?php echo $G[username];?>, 欢迎你!</div>
    <a href="/?m=<?php echo $G[m];?>&c=wallet&a=recharge" class="button btn-recharge">我要充值</a>
</div>
<div class="mcenter-content-div" style="height:120px;">
	<div class="headimg-div">
    	<div class="avatar"><img src="<?php echo avatar($G[uid]); ?>"></div>
        <div class="a-setting"><a href="/?m=<?php echo $G[m];?>&c=setting&a=modiinfo">设置头像</a></div>
    </div>
    <div class="user-account">
    	<div class="row">
        	<div class="item">账户余额：<i><?php echo formatAmount($wallet[balance]); ?></i></div>
            <div class="item">可用积分：<i><?php echo formatAmount($wallet[score]); ?></i></div>
           	<div class="item">账户状态：<i>正常</i></div>
        </div>
        <div class="row">
        	<div class="item"><a href="/?m=<?php echo $G[m];?>&c=setting&a=modiinfo"><span class="icon">&#xf0199;</span>修改个人资料</a></div>
            <div class="item"><span class="icon">&#xf00a2;</span>手机已绑定</div>
           	<div class="item"><span class="icon">&#xf0138;</span>邮箱已绑定</div>
        </div>
    </div>
</div>

<div class="mcenter-content-div">
	<div class="console-title"><strong>每日任务</strong></div>
</div>

<div class="mcenter-content-div">
	<div class="console-title"><strong>邀请好友</strong></div>
</div>

<div class="mcenter-task-div">
	<div class="mcenter-task-box">
    	<div class="box" style="background-color:#6ACF59;">
            <span class="icon">&#xf0029;</span>
            <div class="con">
                <h3>账户充值</h3>
                <p>发表文章赚取积分</p>
            </div>
        </div>
    </div>
    
    <div class="mcenter-task-box">
    	<div class="box" style="background-color:#FFAD30;">
            <span class="icon">&#xf0199;</span>
            <div class="con">
                <h3>发表文章</h3>
                <p>发表文章赚取积分</p>
            </div>
        </div>
    </div>
    
    <div class="mcenter-task-box">
    	<div class="box" style="background-color:#FF4B57;">
            <span class="icon">&#xf00b0;</span>
            <div class="con">
                <h3>账户认证</h3>
                <p>发表文章赚取积分</p>
            </div>
        </div>
    </div>
    
    <div class="mcenter-task-box">
    	<div class="box" style="background-color:#51AAF2;">
            <span class="icon">&#xf00af;</span>
            <div class="con">
                <h3>站长推荐</h3>
                <p>发表文章赚取积分</p>
            </div>
        </div>
    </div>
    
    <div class="mcenter-task-box">
    	<div class="box" style="background-color:#B97CC1;">
            <span class="icon">&#xf0159;</span>
            <div class="con">
                <h3>更多</h3>
                <p>更多惊喜，敬请期待</p>
            </div>
        </div>
    </div>
</div><?php include template('footer'); ?>