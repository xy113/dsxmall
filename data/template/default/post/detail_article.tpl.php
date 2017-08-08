<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header_common'); ?><div class="area post-detail-div">
	<div class="main-frame">
    	<h1 class="post-title"><?php echo $article[title];?></h1> 
    	 <div class="post-info">        
            <span><?php echo @date('Y年m月d日 H:i',$article[pubtime]); ?></span>
            <span>阅读:<?php echo $article[viewnum];?></span>
            <a>评论:(<?php echo $article[commentnum];?>)</a>
            <a favorite="true" data-id="$article[id]" data-type="article">收藏本文</a>
            <?php if($G[account][adminid]) { ?><a href="javascript:;" onclick="deletePost($article[id])">删除</a><?php } ?>
            <?php if($G[account][adminid]||$article[uid]==$G[uid]) { ?><a href="/?m=$G[m]&c=$G[c]&a=edit&id=$article[id]">编辑</a><?php } ?>
            <?php if($G[account][adminid]) { ?><a href="javascript:;" onclick="setPostState($article[id],0)">通过审核</a> <a href="javascript:;" onclick="setPostState($article[id],2)">取消审核</a><?php } ?>
       </div>
       
       <div class="post-body"><?php echo $content[content];?></div>
       <?php if($article[tags]) { ?>
      <div class="post-tags">标签:
            <?php if(is_array($article[tags])) { foreach($article[tags] as $tag) { ?>          <a href="/?mod=post&act=search&tag=$tag"><?php echo $tag;?></a>
          <?php } } ?>      </div>
      <?php } ?>
    </div>
    
    <div class="right-frame">
    	<div class="content-div">
        	<h3 class="title">热点文章</h3>
            <ul class="itemlist">
            <?php $itemlist=post_get_item_list(0,10) ?>                <?php if(is_array($itemlist)) { foreach($itemlist as $item) { ?>                <li><a href="/?m=post&c=detail&id=<?php echo $item[id];?>"><?php echo $item[title];?></a></li>
                <?php } } ?>            </ul>
        </div>
        <div class="blank"></div>
        <div class="content-div">
        	<h3 class="title">热点图文</h3>
            <ul class="picitemlist">
            <?php $itemlist=post_get_item_list(0,5) ?>                <?php if(is_array($itemlist)) { foreach($itemlist as $item) { ?>                <li>
                	<div class="imgbox"><a href="/?m=post&c=detail&id=<?php echo $item[id];?>"><img src="<?php echo image($item[image]); ?>"></a></div>
                    <div class="title"><a href="/?m=post&c=detail&id=<?php echo $item[id];?>"><?php echo $item[title];?></a></div>
                </li>
                <?php } } ?>            </ul>
        </div>
    </div>
</div><?php include template('footer_common'); ?>