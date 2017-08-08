<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><style type="text/css">
.swithContent{display:none;}
</style>
<div class="console-title">
	<div class="float-right">
    	<a href="<?php echo U('c=postcat'); ?>" class="button">分类管理</a>
        <a href="<?php echo U('a=itemlist'); ?>" class="button">返回列表</a>
    </div>
    <h2>发布文章</h2>
</div>
<div class="content-div">
    <form method="post" id="postForm" action="">
    <input type="hidden" name="formsubmit" value="yes" />
    <input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>">
  	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
    <tr>
      <td><input type="text" class="input-text input-title" placeholder="在这里输入标题" name="newpost[title]" value="<?php echo $article[title];?>" id="postTitle"></td>
    </tr>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
    <tr>
      <td width="80">目录分类</td>
      <td><select name="newpost[catid]" class="w200"><?php echo $categoryoptions;?></select></td>
      <td width="80">文章来源</td>
      <td><input type="text" class="input-text" name="newpost[from]" value="<?php echo $article[from];?>"></td>
      <td rowspan="4" width="160">
        <input type="hidden" id="postImage" name="newpost[image]" value="<?php echo $article[image];?>">
        <div class="post-image-box" title="点击更换图片">
        <img src="<?php echo image($article[image]); ?>" id="postImageView"></div>
      </td>
    </tr>
    <tr>
      <td>文章别名</td>
      <td><input type="text" class="input-text" name="newpost[alias]" value="<?php echo $article[alias];?>"></td>
      <td>来源地址</td>
      <td><input type="text" class="input-text" name="newpost[fromurl]" value="<?php echo $article[fromurl];?>"></td>
      </tr>
    <tr>
      <td>评论设置</td>
      <td><label><input type="checkbox" class="checkbox" name="newpost[allowcomment]" value="1"<?php if($article[allowcomment]) { ?> checked<?php } ?>> 允许评论</label></td>
      <td>文章标签</td>
      <td><input type="text" class="input-text" name="newpost[tags]" value="<?php echo $article[tags];?>"></td>
      </tr>
    <tr>
      <td>文章作者</td>
      <td><input type="text" class="input-text" name="newpost[author]" value="<?php echo $article[author];?>"></td>
      <td>文章形式</td>
      <td>
            <label><input type="radio" class="radio" name="newpost[type]" onclick="switchContent('article')" value="article"<?php if($type=='article') { ?> checked<?php } ?>> 文章</label>
            <label><input type="radio" class="radio" name="newpost[type]" onclick="switchContent('image')" value="image"<?php if($type=='image') { ?> checked<?php } ?>> 相册</label>
            <label><input type="radio" class="radio" name="newpost[type]" onclick="switchContent('video')" value="video"<?php if($type=='video') { ?> checked<?php } ?>> 视频</label>
      </td>
    </tr>
    <tr>
    	<td>阅读价格</td>
        <td><input type="text" class="input-text" name="newpost[price]" value="<?php echo $article[price];?>"></td>
        <td>发布时间</td>
        <td><input type="text" class="input-text" name="newpost[pubtime]" value="<?php echo $article[pubtime];?>"></td>
    </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
    <tr>
      <td width="80">内容摘要</td>
      <td><textarea style="width:100%;" name="newpost[summary]"><?php echo $article[summary];?></textarea></td>
      <td width="200"><input type="submit" class="submit button-publish f-right" value="<?php if($_G[a]=='edit') { ?>更新<?php } else { ?>发布<?php } ?>" id="publishButton"></td>
    </tr>
  </table>
  <?php $editorname='content';; ?>  <?php $editorcontent=$content;; ?>  <div class="swithContent" id="content-article"<?php if($type=='article') { ?> style="display:block;"<?php } ?>>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
    <tr>
      <td><div style="box-sizing:border-box"><?php include template('editor'); ?></div></td>
    </tr>
  </table>
  </div>
  <div class="swithContent" id="content-image"<?php if($type=='image') { ?> style="display:block;"<?php } ?>>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
    <tr>
      <td>
           <div class="post-image-div">
                <div class="post-image-title">
                    仅支持jpg,gif,png格式的图片，大小不要能超过10MB。
                    <div class="upload-button">
                    	<div class="hd">
                        	<div class="swfbutton"><div id="swfuploadButton"></div></div>
                            <div class="button"><i class="icon">&#xf0024;</i>上传照片</div>
                        </div>
                    </div>
                    <div class="button pick-button"><i class="icon">&#xf0199;</i>选择照片</div>
                </div>
                <div class="post-image-container">
                	<div class="post-image-scroll">
                    	<div class="post-image-queue" id="swfuploadqueue">
                        <?php if(is_array($piclist)) { foreach($piclist as $k=>$pic) { ?>                            <div class="item">
                                <div class="box">
                                    <div class="pic"><img src="<?php echo image($pic[image]); ?>"></div>
                                    <input type="hidden" value="<?php echo $pic[thumb];?>" name="piclist[<?php echo $k;?>][thumb]" class="thumb">
                                    <input type="hidden" value="<?php echo $pic[image];?>" name="piclist[<?php echo $k;?>][image]" class="image">
                                    <textarea placeholder="在这里填写图片的说明" name="piclist[<?php echo $k;?>][description]" class="textarea"><?php echo $pic[description];?></textarea>
                                    <a class="icon delete" onclick="removeItem(this)">&#xf013f;</a>
                                </div>
                            </div>
                            <?php } } ?>                        </div>
                    </div>
                </div>
           </div>
      </td>
    </tr>
  </table>
  </div>
  <div class="swithContent" id="content-video"<?php if($type=='video') { ?> style="display:block;"<?php } ?>>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
    <tr>
      <td width="80">视频地址</td>
      <td>
        <input type="text" class="input-text input-title" name="videourl" value="$videodata[original_url]" style="width:100%;">
        <p>请输入QQ视频，优酷网、酷6网、56网的视频播放页链接</p>
      </td>
    </tr>
  </table>
  </div>
  </form>
</div>
<script type="application/x-template" id="J-image-item-tpl">
<div class="item" id="#id#">
	<div class="box">
		<div class="pic"></div>
		<input type="hidden" value="" name="piclist[#k#][thumb]" class="thumb">
		<input type="hidden" value="" name="piclist[#k#][image]" class="image">
		<textarea placeholder="在这里填写图片的说明" name="piclist[#k#][description]" class="textarea"></textarea>
		<a class="icon delete" onclick="removeItem(this)">&#xf013f;</a>
	</div>
</div>
</script>
<script src="/static/js/dsxupload.js" type="text/javascript"></script>
<script type="text/javascript">
var k = 0;
function getTemplate(){
	k--;
	var html = $("#J-image-item-tpl").html();
	html = html.replace(/#k#/g,k);
	return html;
}
var swfu = new DSXUpload({
	multi:true,
	post_params:{uid:'<?php echo $_G[uid];?>',token:'<?php echo md5($_G[uid].formhash()); ?>'},
	button_id:'swfuploadButton',
	button_text:'',
	upload_url : "/?m=jsapi&c=material&a=add_material&type=image&from=swfupload",
	onSelect:function(file){
		try {
			var html = getTemplate();
			html = html.replace(/#id#/g,file.id);
			$("#swfuploadqueue").append(html);
			$(html).attr('id', file.id).hide();
		} catch (ex) {
			this.debug(ex);
		}
	},
	onUploadSuccess:function(file, data, response){
		var json = $.parseJSON(data);
		if(json.errcode == 0) {
			$("#"+file.id).find(".pic").html('<img src="'+json.data.imageurl+'">');
			$("#"+file.id).find(".image").val(json.data.image);
			$("#"+file.id).find(".thumb").val(json.data.thumb);
		}
	},
	onUploadError:function(file, errorCode, errorMsg){
		alert(errorMsg);
	}
});
function switchContent(type){
	$(".swithContent").hide();
	$("#content-"+type).show();
}

function removeItem(o){
	if(confirm('$_lang[confirm_delete]')){
		$(o).parent().parent().remove();
	}
}

$("#postImageView").click(function(e) {
	DSXUI.showImagePickerView({
		onPicked:function(data){
			$("#postImageView").attr('src', data.imageurl);
			$("#postImage").val(data.image);
		}
	});
});

$(".pick-button").click(function(e) {
    DSXUI.showImagePickerView({
		multi:true,
		onPicked:function(data){
			for(var i in data){
				var d = data[i];
				if($('#pick_item_'+d.id).length == 0){
					k--;
					var html = getTemplate();
					html = html.replace(/#id#/g,'pick_item_'+d.id);
					html = html.replace(/#k#/g, k);
					$("#swfuploadqueue").append(html);
					$('#pick_item_'+d.id).find(".pic").html('<img src="'+d.imageurl+'">');
					$('#pick_item_'+d.id).find(".image").val(d.image);
					$('#pick_item_'+d.id).find(".thumb").val(d.thumb);
				}
			}
		}
	});
});

$("#swfuploadqueue").sortable();
;$(function(){
	$("#postForm").submit(function(e) {
        var title = $.trim($("#postTitle").val());
		if(title.length < 1){
			DSXUI.error("$_lang[post_title_required]");
			return false;
		}
		return true;
    });
});
</script><?php include template('footer'); ?>