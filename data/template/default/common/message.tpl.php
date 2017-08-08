<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header_common'); ?><div class="area sysmessage">
	<h3 class="$type"><?php echo $msg;?></h3>
    <?php if($autoredirect) { ?>
    <div class="tips"><?php echo $_lang[auto_redirect];?></div>
    <?php } else { ?>
    <div class="tips"><?php echo $_lang[message_tips];?></div>
    <?php } ?>
    <div class="links">
        <?php if($links) { ?>
        <?php if(is_array($links)) { foreach($links as $link) { ?>        <a href="<?php echo $link[url];?>"<?php if($link[target]) { ?> target="<?php echo $link[target];?>"<?php } ?>><?php echo $link[text];?></a>
       <?php } } ?>       <?php } else { ?>
       <a href="$forward"><?php echo $lang[go_back];?></a>
       <a href="/"><?php echo $lang[go_home];?></a>
       <?php } ?>
    </div>
</div> 
<?php if($autoredirect) { ?>
<script type="text/javascript">
var second = 5;
var timeid = setInterval(function(){
	second--;
	if(second<1){
		clearTimeout(timeid);
		window.location = '<?php echo $forward;?>';
	}else {
		$("#timer").text(second);
	}
},1000);
</script>
<?php } include template('footer_common'); ?>