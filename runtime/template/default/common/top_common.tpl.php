<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><div class="top">
    <div class="area">
        <div class="right">
            <ul>
                <li><a href="<?php echo U('/'); ?>">粗耕首页</a></li>
                <li class="pipe">|</li>
                <li><a href="<?php echo U('m=member&c=index'); ?>">我的粗耕</a></li>
                <li class="pipe">|</li>
                <li>
                    <a href="<?php echo U('m=cart&c=index'); ?>">
                        <span class="iconfont icon-cartfill"></span>
                        <span>购物车</span>
                    </a>
                </li>
                <li class="pipe">|</li>
                <li><a href="<?php echo U('m=member&c=collection'); ?>"><span class="iconfont icon-favorfill"></span> <span>收藏夹</span></a></li>
                <li class="pipe">|</li>
                <li>
                    <a>
                        <span>商品分类</span>
                    </a>
                </li>
                <li class="pipe">|</li>
                <li><a href="<?php echo U('m=seller&c=index'); ?>">卖家中心</a></li>
                <li class="pipe">|</li>
                <li><a>联系客服</a></li>
            </ul>
        </div>
        <?php if($_G[islogin]) { ?>
        <span>Hi <a href="<?php echo U('m=member&c=index'); ?>" style="color: #f40;"><?php echo $_G[username];?></a>, 欢迎回来</span>
        <a href="<?php echo U('m=account&c=logout'); ?>">[退出登录]</a>
        <?php } else { ?>
        <span>Hi 欢迎回来</span>
        <a href="<?php echo U('m=account&c=login'); ?>">[登录]</a>
        <a href="<?php echo U('m=account&c=register'); ?>">[免费注册]</a>
        <?php } ?>
    </div>
</div>