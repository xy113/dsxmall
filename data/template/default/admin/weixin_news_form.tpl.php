<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><link rel="stylesheet" href="/static/kindeditor/themes/default/default.css" />
<script src="/static/kindeditor/kindeditor-min.js" type="text/javascript"></script>
<script src="/static/kindeditor/lang/zh_CN.js" type="text/javascript"></script>
<div class="console-title">
	<div class="float-right">
       <a href="<?php echo U(); ?>" class="button">返回列表</a>
    </div>
    <h2><?php if($_G[a]=='edit') { ?>编辑图文消息<?php } else { ?>添加图文消息<?php } ?></h2>
</div>
<div class="area">
<form method="post" id="newsForm" action="">
<input type="hidden" name="formsubmit" value="yes" />
<input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>">
<table cellpadding="0" cellspacing="1" width="100%" class="weixin-news-table">
	<tr>
    	<td width="200" class="left">
        	<ul class="thumb-list" id="thumb-list">
            <?php if(is_array($news_item)) { foreach($news_item as $k=>$item) { ?>            <li order_index="<?php echo $k;?>" id="thumb_<?php echo $k;?>"<?php if($item) { ?> style="background-image:url(<?php echo U('c=wxmaterial&a=viewimage&media_id='.$item[thumb_media_id]); ?>);"<?php } ?>>
            	<input type="hidden" name="news_order[]" value="<?php echo $k;?>">
                <div class="title"><?php echo $item[title];?></div>
                <a rel="delnews" data-id="<?php echo $k;?>" class="icon del">&#xf013f;</a>
            </li>
            <?php } } ?>            </ul>
            <?php if($_G[a]=='add') { ?><a class="add-item" id="add-item" onclick="addItem()"><i class="icon">&#xf0175;</i></a><?php } ?>
            <input type="button" class="button publish-button" value="提交并发布" id="publish">
        </td>
        <td class="right">
           <div id="news-item-list">
           <?php if(is_array($news_item)) { foreach($news_item as $k=>$item) { ?>                <div class="news-item" id="news_item_$k">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
                  <tbody>
                    <tr>
                      <td width="65">标题</td>
                      <td width="320"><input type="text" class="input-text w300 news-title" index="<?php echo $k;?>" name="news_item[<?php echo $k;?>][title]" value="<?php echo $item[title];?>"></td>
                      <td class="tips">文章标题，必填</td>
                    </tr>
                    <tr>
                      <td>封面图片</td>
                      <td><input type="text" class="input-text w300 news-thumb" index="<?php echo $k;?>" name="news_item[<?php echo $k;?>][thumb_media_id]" value="<?php echo $item[thumb_media_id];?>"></td>
                      <td class="tips">图文消息的封面图片素材id（必须是永久mediaID）</td>
                    </tr>
                    <tr>
                      <td>作者</td>
                      <td><input type="text" class="input-text w300" name="news_item[<?php echo $k;?>][author]" value="<?php echo $item[author];?>"></td>
                      <td class="tips">文章作者，必填</td>
                    </tr>
                    <tr>
                      <td>摘要</td>
                      <td><textarea name="news_item[<?php echo $k;?>][digest]" class="textarea w300" style="height:80px;"><?php echo $item[digest];?></textarea></td>
                      <td class="tips">图文消息的摘要，仅有单图文消息才有摘要，多图文此处为空</td>
                    </tr>
                    <tr>
                      <td>显示封面</td>
                      <td>
                          <label><input type="radio" name="news_item[<?php echo $k;?>][show_cover_pic]" value="1"<?php if($item[show_cover_pic]) { ?> checked<?php } ?>> 是</label>
                          <label><input type="radio" name="news_item[<?php echo $k;?>][show_cover_pic]" value="0"<?php if(!$item[show_cover_pic]) { ?> checked<?php } ?>> 否</label>
                      </td>
                      <td class="tips">是否显示封面图片，0为false，即不显示，1为true，即显示，必填</td>
                    </tr>
                    <tr>
                      <td>文章内容</td>
                      <td colspan="2"><textarea name="news_item[<?php echo $k;?>][content]" id="kindeditor_<?php echo $k;?>" style="width:100%;height:350px;visibility:hidden; display:none;"><?php echo $item[content];?></textarea></td>
                    </tr>
                    <tr>
                      <td>原文地址</td>
                      <td><input type="text" class="input-text w300" name="news_item[<?php echo $k;?>][content_source_url]" value="<?php echo $item[content_source_url];?>"></td>
                      <td class="tips">图文消息的原文地址，即点击“阅读原文”后的URL，必填</td>
                    </tr>
                </tbody>
              </table>
              </div>
              <script type="text/javascript">
              KindEditor.create('#kindeditor_<?php echo $k;?>', {
					allowFileManager : true,
					items : [
						'justifyleft', 'justifycenter', 'justifyright',
						'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
						'superscript', 'clearhtml', 'quickformat', 'selectall', '|',
						'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
						'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', 'anchor', 'link', 'unlink'
					],
					afterBlur: function () {this.sync();},
					uploadJson : '/?m=common&c=kindeditor&a=upload',
					fileManagerJson:'/?m=common&c=kindeditor&a=manager',
					extraFileUploadParams:{uid:'<?php echo $_G[uid];?>',username:'<?php echo $_G[username];?>',token:'<?php echo $token;?>'}
				});
              </script>
                <?php } } ?>           </div>
        </td>
    </tr>
</table>
</form>    
</div>
<script type="text/x-template" id="J-item-tpl">
<div class="news-item" id="news_item_#k#">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
	<tbody>
	  <tr>
		<td width="65">标题</td>
		<td width="320"><input type="text" class="input-text w300 news-title" index="#k#" name="news_item[#k#][title]" value=""></td>
		<td class="tips">文章标题，必填</td>
	  </tr>
	  <tr>
		<td>封面图片</td>
		<td><input type="text" class="input-text w300 news-thumb" index="#k#" name="news_item[#k#][thumb_media_id]"></td>
		<td class="tips">图文消息的封面图片素材id（必须是永久mediaID）</td>
	  </tr>
	  <tr>
		<td>作者</td>
		<td><input type="text" class="input-text w300" name="news_item[#k#][author]" value=""></td>
		<td class="tips">文章作者，必填</td>
	  </tr>
	  <tr>
		<td>摘要</td>
		<td><textarea name="news_item[#k#][digest]" class="textarea w300" style="height:80px;"></textarea></td>
		<td class="tips">图文消息的摘要，仅有单图文消息才有摘要，多图文此处为空</td>
	  </tr>
	  <tr>
		<td>显示封面</td>
		<td>
			<label><input type="radio" name="news_item[#k#][show_cover_pic]" value="1" checked> 是</label>
			<label><input type="radio" name="news_item[#k#][show_cover_pic]" value="0"> 否</label>
		</td>
		<td class="tips">是否显示封面图片，0为false，即不显示，1为true，即显示，必填</td>
	  </tr>
	  <tr>
		<td>文章内容</td>
		<td colspan="2"><textarea name="news_item[#k#][content]" id="kindeditor_#k#" style="width:100%;height:350px;visibility:hidden; display:none;"></textarea></td>
	  </tr>
	  <tr>
		<td>原文地址</td>
		<td><input type="text" class="input-text w300" name="news_item[#k#][content_source_url]" value=""></td>
		<td class="tips">图文消息的原文地址，即点击“阅读原文”后的URL，必填</td>
	  </tr>
  </tbody>
</table>
</div>
</script>
<script type="text/javascript">
var k = $("#thumb-list li").length;
function addItem(){
	if($("#thumb-list li").length >= 5){
		DSXUI.error('单条消息不能超过5篇文章');
		return false;
	}else {
		var li ='<li order_index="'+k+'" id="thumb_'+k+'"><input type="hidden" name="news_order[]" value="'+k+'">';
		li+= '<a rel="delnews" data-id="'+k+'" class="icon del">&#xf013f;</a><div class="title">标题</div></li>';
		$("#thumb-list").append(li);
		var html = $("#J-item-tpl").html().replace(/#k#/g, k);
		$("#news-item-list").append(html);
		$("#news-item-list .news-item").hide().last().show();
		KindEditor.create('#kindeditor_'+k, {
			allowFileManager : true,
			items : [
				'justifyleft', 'justifycenter', 'justifyright',
				'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
				'superscript', 'clearhtml', 'quickformat', 'selectall', '|',
				'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
				'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', 'anchor', 'link', 'unlink'
			],
			afterBlur: function () {this.sync();},
			uploadJson : '/?m=common&c=kindeditor&a=upload',
			fileManagerJson:'/?m=common&c=kindeditor&a=manager',
			extraFileUploadParams:{uid:'$_G[uid]',username:'$_G[username]',token:'$token'}
		});
		bindEvent();
		setSelectedItem(k); 
		k++;
	}
};
function bindEvent(){
	$("#thumb-list li").off('click').click(function(e) {
		var order_index = $(this).attr('order_index');
        $(this).addClass('cur').siblings().removeClass('cur');
		$("#news_item_"+order_index).show().siblings('.news-item').hide();
    });
	$("[rel=delnews]").off('click').on('click',function(e) {
		DSXUtil.stopPropagation(e);
        var id = $(this).attr('data-id');
		if($("#thumb-list li").length < 2){
			DSXUI.error('至少要保留一篇文章');
			return false;
		}else {
			DSXUI.confirmDialog({
				title:'删除确认',
				text:'你确定要删除吗',
				onConfirm:function(){
					$("#thumb_"+id).remove();
					$("#news_item_"+id).remove();
					setSelectedItem(0);
				}
			});
		}
    });
	
	$(".news-title").blur(function(e) {
        var index = $(this).attr('index');
		if($(this).val()) {
			$("#thumb_"+index).find(".title").html($(this).val());
		}
    });
	$(".news-thumb").blur(function(e) {
        var index = $(this).attr('index');
		if($(this).val()) {
			$("#thumb_"+index).css('background-image','url(/?m=<?php echo $_G[m];?>&c=wxmaterial&a=viewimage&media_id='+$(this).val()+')');
		}
    });
}

function setSelectedItem(index){
	var order_index = 0;
	$("#thumb-list li").each(function(i, element) {
        if(i == index){
			order_index = $(element).attr('order_index');
			$(element).addClass('cur');
		}else {
			$(element).removeClass('cur');
		}
    });
	$("#news_item_"+order_index).show().siblings('.news-item').hide();
}
bindEvent();
setSelectedItem(0);
$("#thumb-list").sortable({item:'li'});
$("#publish").click(function(e) {
	var loading;
    $("#newsForm").ajaxSubmit({
		//dataType:'json',
		beforeSend:function(){
			loading = DSXUI.showloading('正在上传素材...');
		},
		success:function(json){
			loading.close();
			console.log(json);
			if(json.errcode == 0){
				DSXUI.success('素材保存成功', function(){
					window.location.href = '/?m=<?php echo $_G[m];?>&c=<?php echo $_G[c];?>&a=index';	
				});
			}
		}
	});
});
</script>
<?php if($_G[a]=='add') { ?><script>addItem();</script><?php } include template('footer'); ?>