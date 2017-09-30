<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header_common'); ?><div class="area">
    <div class="category-panel">
        <ul class="cat-list" id="cat-list" style="height: 496px;">
            <?php if(is_array($item_catlog_list[0])) { foreach($item_catlog_list[0] as $cat) { ?>            <li><a href="<?php echo U('m=item&c=search&catid='.$cat[catid]); ?>"><span><?php echo $cat[name];?></span></a></li>
            <?php } } ?>        </ul>
        <div class="childs-panel" id="childs-panel">
            <?php if(is_array($item_catlog_list[0])) { foreach($item_catlog_list[0] as $cat) { ?>            <div class="cat-group">
                <h3><a href="<?php echo U('m=item&c=search&catid='.$cat[catid]); ?>" class="more">更多 >></a> <?php echo $cat[name];?></h3>
                <ul>
                    <?php if(is_array($item_catlog_list[$cat[catid]])) { foreach($item_catlog_list[$cat[catid]] as $child) { ?>                    <li><a href="<?php echo U('m=item&c=search&catid='.$child[catid]); ?>"><?php echo $child[name];?></a></li>
                    <?php } } ?>                </ul>
            </div>
            <?php } } ?>        </div>
    </div>
    <div class="home-main">
        <div class="swiper-div" id="swiper-div">
            <div class="swiper" id="swiper">
                <ul class="swiper-wrapper">
                    <?php $slide_list=block_get_cache(1); ?>                    <?php if(is_array($slide_list)) { foreach($slide_list as $sd) { ?>                    <li class="swiper-slide"><a href="<?php echo $sd[url];?>" target="_blank"><img src="<?php echo image($sd[image]); ?>"></a></li>
                    <?php } } ?>                </ul>
                <div class="swiper-pagination"></div>
            </div>
        </div>
        <script type="text/javascript">
            (function(){
                var swiper = new Swiper('#swiper',
                        {loop:true,pagination:'.swiper-pagination',autoplay:2500});
            })();
        </script>
        <div class="news">
            <div class="content">
                <h3>农产品资讯</h3>
                <ul>
                    <?php if(is_array($newPostList)) { foreach($newPostList as $item) { ?>                    <li><a href="<?php echo U('m=post&c=detail&aid='.$item[aid]); ?>" target="_blank">&bull; <?php echo $item[title];?></a></li>
                    <?php } } ?>                </ul>
            </div>
        </div>
        
        <div class="best-goods-wrap">
            <ul class="best-goods">
                <?php $best_list=block_get_cache(2); ?>                <?php if(is_array($best_list)) { foreach($best_list as $item) { ?>                <li><div class="bd"><a href="<?php echo $item[url];?>"><img src="<?php echo image($item[image]); ?>"></a></div></li>
                <?php } } ?>            </ul>
        </div>
    </div>
</div>
<script type="text/javascript">
$(function () {
    $("#cat-list li").mouseenter(function (e) {
        var self = this;
        $(this).addClass('cur').siblings().removeClass('cur');
        $("#childs-panel").show();
        $("#childs-panel .cat-group").eq($(this).index()).show().siblings('.cat-group').hide();
        $(document).mousemove(function (e) {
            $("#childs-panel").hide();
            $(self).removeClass('cur');
        });
    }).mousemove(function (e) {
        DSXUtil.stopPropagation(e);
    });
    $("#childs-panel").mousemove(function (e) {
        DSXUtil.stopPropagation(e);
    });
});
</script>
<div class="blank10"></div>
<div class="area">
    <div class="home-tegong">
        <h3>今日特供</h3>
        <?php $tegong=block_get_item(array('id'=>8)); ?>        <div class="pic"><a href="<?php echo $tegong[url];?>"><img src="<?php echo image($tegong[image]); ?>"></a></div>
    </div>
    <div class="home-youxuan">
        <ul class="tabs" id="tabs">
            <li class="cur">爆品抢购</li>
            <li>优选推荐</li>
            <li>精品速递</li>
            <li>好评单品</li>
            <li>猜你喜欢</li>
        </ul>
        <div id="glist-wrap">
            <ul class="glist" style="display: block;">
                <?php if(is_array($item_list['baopin'])) { foreach($item_list['baopin'] as $item) { ?>                <li>
                    <div class="bd">
                        <div class="pic bg-cover asyncload" data-original="<?php echo image($item[thumb]); ?>">
                            <a href="<?php echo U('m=item&c=item&itemid='.$item[itemid]); ?>" target="_blank"></a>
                        </div>
                        <div class="name"><a href="<?php echo U('m=item&c=item&itemid='.$item[itemid]); ?>" target="_blank"><?php echo $item[title];?></a></div>
                        <div class="price">
                            <strong class="shop-price">￥:<?php echo $item[price];?></strong>
                            <span class="market-price"><s>￥:<?php echo $item[market_price];?></s></span>
                        </div>
                        <div class="buynow">
                            <a href="<?php echo U('m=item&c=item&itemid='.$item[itemid]); ?>" target="_blank" class="btn">立即购买</a>
                        </div>
                    </div>
                </li>
                <?php } } ?>            </ul>
            <ul class="glist">
                <?php if(is_array($item_list['youxuan'])) { foreach($item_list['youxuan'] as $item) { ?>                <li>
                    <div class="bd">
                        <div class="pic bg-cover asyncload" data-original="<?php echo image($item[thumb]); ?>">
                            <a href="<?php echo U('m=item&c=item&itemid='.$item[itemid]); ?>" target="_blank"></a>
                        </div>
                        <div class="name"><a href="<?php echo U('m=item&c=item&itemid='.$item[itemid]); ?>" target="_blank"><?php echo $item[title];?></a></div>
                        <div class="price">
                            <strong class="shop-price">￥:<?php echo $item[price];?></strong>
                            <span class="market-price"><s>￥:<?php echo $item[market_price];?></s></span>
                        </div>
                        <div class="buynow">
                            <a href="<?php echo U('m=item&c=item&itemid='.$item[itemid]); ?>" target="_blank" class="btn">立即购买</a>
                        </div>
                    </div>
                </li>
                <?php } } ?>            </ul>
            <ul class="glist">
                <?php if(is_array($item_list['jingpin'])) { foreach($item_list['jingpin'] as $item) { ?>                <li>
                    <div class="bd">
                        <div class="pic bg-cover asyncload" data-original="<?php echo image($item[thumb]); ?>">
                            <a href="<?php echo U('m=item&c=item&itemid='.$item[itemid]); ?>" target="_blank"></a>
                        </div>
                        <div class="name"><a href="<?php echo U('m=item&c=item&itemid='.$item[itemid]); ?>" target="_blank"><?php echo $item[title];?></a></div>
                        <div class="price">
                            <strong class="shop-price">￥:<?php echo $item[price];?></strong>
                            <span class="market-price"><s>￥:<?php echo $item[market_price];?></s></span>
                        </div>
                        <div class="buynow">
                            <a href="<?php echo U('m=item&c=item&itemid='.$item[itemid]); ?>" target="_blank" class="btn">立即购买</a>
                        </div>
                    </div>
                </li>
                <?php } } ?>            </ul>
            <ul class="glist">
                <?php if(is_array($item_list['haoping'])) { foreach($item_list['haoping'] as $item) { ?>                <li>
                    <div class="bd">
                        <div class="pic bg-cover asyncload" data-original="<?php echo image($item[thumb]); ?>">
                            <a href="<?php echo U('m=item&c=item&itemid='.$item[itemid]); ?>" target="_blank"></a>
                        </div>
                        <div class="name"><a href="<?php echo U('m=item&c=item&itemid='.$item[itemid]); ?>" target="_blank"><?php echo $item[title];?></a></div>
                        <div class="price">
                            <strong class="shop-price">￥:<?php echo $item[price];?></strong>
                            <span class="market-price"><s>￥:<?php echo $item[market_price];?></s></span>
                        </div>
                        <div class="buynow">
                            <a href="<?php echo U('m=item&c=item&itemid='.$item[itemid]); ?>" target="_blank" class="btn">立即购买</a>
                        </div>
                    </div>
                </li>
                <?php } } ?>            </ul>
            <ul class="glist">
                <?php if(is_array($item_list['xihuan'])) { foreach($item_list['xihuan'] as $item) { ?>                <li>
                    <div class="bd">
                        <div class="pic bg-cover asyncload" data-original="<?php echo image($item[thumb]); ?>">
                            <a href="<?php echo U('m=item&c=item&itemid='.$item[itemid]); ?>" target="_blank"></a>
                        </div>
                        <div class="name"><a href="<?php echo U('m=item&c=item&itemid='.$item[itemid]); ?>" target="_blank"><?php echo $item[title];?></a></div>
                        <div class="price">
                            <strong class="shop-price">￥:<?php echo $item[price];?></strong>
                            <span class="market-price"><s>￥:<?php echo $item[market_price];?></s></span>
                        </div>
                        <div class="buynow">
                            <a href="<?php echo U('m=item&c=item&itemid='.$item[itemid]); ?>" target="_blank" class="btn">立即购买</a>
                        </div>
                    </div>
                </li>
                <?php } } ?>            </ul>
        </div>
    </div>
</div>
<script type="text/javascript">
   $(function () {
        $("#tabs li").on('mouseenter', function () {
            $(this).addClass('cur').siblings().removeClass();
            $("#glist-wrap ul").eq($(this).index()).show().siblings('ul').hide();
        });
   });
</script>
<div class="blank"></div>
<div class="area home">
    <div class="yingyangcan-title">
        <a href="<?php echo U('m=item&c=search'); ?>" class="more">更多>></a>
        <strong>营养餐</strong>
    </div>
    <div class="yingyangcan-list">
        <ul>
            <?php if(is_array($item_list['new'])) { foreach($item_list['new'] as $item) { ?>            <li>
                <div class="bd">
                    <div class="pic bg-cover asyncload" data-original="<?php echo image($item[thumb]); ?>">
                        <a href="<?php echo U('m=item&c=item&itemid='.$item[itemid]); ?>" target="_blank"></a>
                    </div>
                    <div class="name"><a><?php echo $item[title];?></a></div>
                    <div class="price">
                        <span>￥</span>
                        <strong><?php echo formatAmount($item[price]); ?></strong>
                        <i>起</i>
                    </div>
                </div>
            </li>
            <?php } } ?>        </ul>
    </div>
</div>
<div class="blank"></div>
<div class="area home">
    <div class="qiyedianpu-title">
        <a href="<?php echo U('m=shop&c=index'); ?>" class="more">更多>></a>
        <strong>企业店铺</strong>
    </div>
    <div class="qiyedianpu-wrap">
        <div class="shop-list">
            <ul>
                <?php if(is_array($shop_list)) { foreach($shop_list as $shop) { ?>                <li>
                    <div class="bd">
                        <div class="pic bg-cover asyncload" data-original="<?php echo image($shop[shop_logo]); ?>">
                            <a href="<?php echo U('m=shop&c=viewshop&shop_id='.$shop[shop_id]); ?>" target="_blank"></a>
                        </div>
                        <div class="name"><a href="<?php echo U('m=shop&c=viewshop&shop_id='.$shop[shop_id]); ?>" target="_blank"><?php echo $shop[shop_name];?></a></div>
                    </div>
                </li>
                <?php } } ?>            </ul>
        </div>

        <div class="remai">
            <h3 class="hot-sale">掌柜热卖</h3>
            <ul>
                <?php if(is_array($item_list['hot'])) { foreach($item_list['hot'] as $item) { ?>                <li>
                    <div class="pic bg-cover asyncload" data-original="<?php echo image($item[thumb]); ?>">
                        <a href="<?php echo U('m=item&c=item&itemid='.$item[itemid]); ?>" target="_blank"></a>
                    </div>
                    <div class="g-info">
                        <p class="name"><a href="<?php echo U('m=item&c=item&itemid='.$item[itemid]); ?>" target="_blank"><?php echo $item[title];?></a></p>
                        <p class="market-price"><s>￥<?php echo formatAmount($item[market_price]); ?></s></p>
                        <p class="shop-price">￥<?php echo formatAmount($item[price]); ?></p>
                    </div>
                </li>
                <?php } } ?>            </ul>
        </div>
    </div>
</div>
<script src="/static/js/DSXDialog.js" type="text/javascript"></script>
<script type="text/javascript">
   $(".hot-sale").on('click', function () {
       var dlg = new DSXDialog2();
   })
</script><?php include template('footer_common'); ?> 