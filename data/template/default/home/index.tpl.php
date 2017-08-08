<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header_common'); ?><div class="area">
    <div class="category-panel">
        <ul class="cat-list">
            <li><a><span>蔬菜</span></a></li>
            <li><a><span>水果</span></a></li>
            <li><a><span>生鲜</span></a></li>
            <li><a><span>干货</span></a></li>
            <li><a><span>调料</span></a></li>
            <li><a><span>矿泉水</span></a></li>
            <li><a><span>蔬菜</span></a></li>
            <li><a><span>水果</span></a></li>
            <li><a><span>生鲜</span></a></li>
            <li><a><span>干货</span></a></li>
            <li><a><span>调料</span></a></li>
            <li><a><span>矿泉水</span></a></li>
        </ul>
    </div>
    <div class="home-main">
        <div class="swiper-div" id="swiper-div">
            <div class="swiper" id="swiper">
                <ul class="swiper-wrapper">
                    <li class="swiper-slide"><img src="/static/images/cugeng/larou.jpg"></li>
                    <li class="swiper-slide"><img src="/static/images/cugeng/larou.jpg"></li>
                </ul>
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
                    <?php $itemlist=post_get_item_list(0,10); ?>                    <?php if(is_array($itemlist)) { foreach($itemlist as $item) { ?>                    <li><a href="/?m=post&c=detail&id=<?php echo $item[id];?>">&bull; <?php echo $item[title];?></a></li>
                    <?php } } ?>                </ul>
            </div>
        </div>
        
        <ul class="best-goods">
            <li><div class="bd"><img src="/static/images/cugeng/best-goods.jpg"></div></li>
            <li><div class="bd"><img src="/static/images/cugeng/best-goods.jpg"></div></li>
            <li><div class="bd"><img src="/static/images/cugeng/best-goods.jpg"></div></li>
            <li><div class="bd"><img src="/static/images/cugeng/best-goods.jpg"></div></li>
        </ul>
    </div>
</div>
<div class="blank10"></div>
<div class="area">
    <div class="home-tegong">
        <h3>今日特供</h3>
        <div class="pic"><img src="/static/images/cugeng/tegong.jpg"></div>
    </div>
    <div class="home-youxuan">
        <ul class="tabs">
            <li class="cur">爆品抢购</li>
            <li>优选推荐</li>
            <li>精品速递</li>
            <li>好评单品</li>
            <li>猜你喜欢</li>
        </ul>
        <ul class="glist">
            <li>
                <div class="bd">
                    <div class="pic"><img src="/static/images/cugeng/danpin.jpg"></div>
                    <div class="name">紫皮大蒜</div>
                    <div class="price">
                        <strong class="shop-price">￥:5.00</strong>
                        <span class="market-price"><s>市场价:8.00</s></span>
                    </div>
                    <div class="buynow">
                        <a class="btn">立即购买</a>
                    </div>
                </div>
            </li>

            <li>
                <div class="bd">
                    <div class="pic"><img src="/static/images/cugeng/danpin.jpg"></div>
                    <div class="name">紫皮大蒜</div>
                    <div class="price">
                        <strong class="shop-price">￥:5.00</strong>
                        <span class="market-price"><s>市场价:8.00</s></span>
                    </div>
                    <div class="buynow">
                        <a class="btn">立即购买</a>
                    </div>
                </div>
            </li>

            <li>
                <div class="bd">
                    <div class="pic"><img src="/static/images/cugeng/danpin.jpg"></div>
                    <div class="name">紫皮大蒜</div>
                    <div class="price">
                        <strong class="shop-price">￥:5.00</strong>
                        <span class="market-price"><s>市场价:8.00</s></span>
                    </div>
                    <div class="buynow">
                        <a class="btn">立即购买</a>
                    </div>
                </div>
            </li>

            <li>
                <div class="bd">
                    <div class="pic"><img src="/static/images/cugeng/danpin.jpg"></div>
                    <div class="name">紫皮大蒜</div>
                    <div class="price">
                        <strong class="shop-price">￥:5.00</strong>
                        <span class="market-price"><s>市场价:8.00</s></span>
                    </div>
                    <div class="buynow">
                        <a class="btn">立即购买</a>
                    </div>
                </div>
            </li>

            <li>
                <div class="bd">
                    <div class="pic"><img src="/static/images/cugeng/danpin.jpg"></div>
                    <div class="name">紫皮大蒜</div>
                    <div class="price">
                        <strong class="shop-price">￥:5.00</strong>
                        <span class="market-price"><s>市场价:8.00</s></span>
                    </div>
                    <div class="buynow">
                        <a class="btn">立即购买</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
<div class="blank10"></div><?php include template('footer_common'); ?> 