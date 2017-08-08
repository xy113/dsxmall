<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="console-title">
	<div class="float-right">
        <a class="button" id="add_<?php echo $type;?>">添加素材</a>
    </div>
    <h2>微信素材管理</h2>
</div>
<div class="toolbar">
	<?php if($type=='image') { ?>
    <span class="f-right">图片不超过2M，支持bmp/png/jpeg/jpg/gif格式</span>
    <?php } elseif($type=='video') { ?>
    <span class="f-right">声音不超过2M，播放长度不超过60s，mp3/wma/wav/amr格式</span>
    <?php } else { ?>
    <span class="f-right">视频不超过10MB，支持MP4格式</span>
    <?php } ?>
    <?php if(is_array($_lang[weixin_material_types])) { foreach($_lang[weixin_material_types] as $k=>$v) { ?>    <a href="<?php echo U('type='.$k); ?>" class="baritem<?php if($type==$k) { ?> baritem-on<?php } ?>"><?php echo $v;?></a>
    <?php } } ?></div>
<div class="table-wrap">
    <form method="post" autocomplete="off">
    <input type="hidden" name="formsubmit" value="yes" />
    <input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
    <thead>
      <tr>
        <th width="20" class="center">选?</th>
        <th width="50">图片</th>
        <th width="200">名称</th>
        <th width="350">media_id</th>
        <th>URL</th>
      </tr>
     </thead>
     <tbody>
      <?php if(is_array($itemlist)) { foreach($itemlist as $item) { ?>      <tr>
        <td class="center"><input type="checkbox" class="checkbox checkmark" name="media_id[]" value="<?php echo $item[media_id];?>"></td>
        <td>
        	<?php if($type=='image') { ?>
        	<img src="<?php echo U('a=viewimage&media_id='.$item[media_id]); ?>" width="50" height="50">
            <?php } elseif($type=='video') { ?>
            <img src="/static/images/common/video.png" width="50" height="50">
            <?php } else { ?>
            <img src="/static/images/common/audio.png" width="50" height="50">
            <?php } ?>
        </td>
        <td><?php echo $item[name];?></td>
        <td><?php echo $item[media_id];?></td>
        <td><?php echo $item[url];?></td>
      </tr>
      <?php } } ?>      </tbody>
      <tfoot>
      <tr>
        <td colspan="10">
            <label><input type="checkbox" class="checkbox checkall"> <?php echo $_lang[selectall];?></label>
            <label><input type="radio" class="radio" name="option" value="delete" checked> 删除</label>
        </td>
      </tr>
      <tr>
          <td colspan="10">
              <span class="pages"><?php echo $pages;?></span>
              <input type="submit" class="button" value="<?php echo $_lang[submit];?>">
              <input type="button" class="button cancel" value="<?php echo $_lang[refresh];?>" onclick="window.location.reload()">
          </td>
      </tr>
     </tfoot>
    </table>
    </form>
</div>
<script type="text/x-template" id="J-add-video-tpl">
<div style="padding:20px; display:block;">
<form method="post" id="J-video-form">
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="formtable">
	<tbody>
        <tr>
        	<td width="40">视频</td>
            <td><input type="hidden" name="media" id="J-video-media"><input type="text" class="input-text w300" id="J-video-pick" readonly></td>
			<td class="tips">视频不超过10MB，支持MP4格式<td>
        </tr>
		<tr>
        	<td>标题</td>
            <td><input type="text" class="input-text w300" name="title" id="J-video-title"></td>
			<td class="tips">标题，不超过30个字<td>
        </tr>
		<tr>
        	<td>简介</td>
            <td><textarea class="textarea w300" name="introduction" id="J-video-introduction"></textarea></td>
			<td class="tips">视频简介，不超过120个字<td>
        </tr>
    </tbody>
</table>
</form>
</div>
</script>
<script type="text/javascript">
$("#add_image").click(function(e) {
	var loading;
    imagePickerView({
		multi:false,
		onPicked:function(data){
			$.ajax({
				type:'POST',
				url:"<?php echo U('a=add&type=image'); ?>",
				data:{media:data.image},
				beforeSend: function(){
					loading = DSXUI.showloading('正在上传素材..');
				},
				success: function(json){
					setTimeout(function(){
						loading.close();
						if(json.errcode == 0){
							DSXUI.success('素材添加成功', DSXUtil.reFresh);
						}else {
							DSXUI.error('素材添加失败');
						}
					},1000)
				}
			});
		}
	});
});

$("#add_video").click(function(e) {
    DSXUI.dialog({
		title:'添加视频',
		width:600,
		html:$("#J-add-video-tpl").html(),
		afterShow:function(){
			$("#J-video-pick").click(function(e) {
                filePickerView({
					onPicked:function(data){
						$("#J-video-media").val(data.attachment);
						$("#J-video-pick").val(data.attachname);
						if(!$("#J-video-title").val()) $("#J-video-title").val(data.attachname);
					}
				});
            });
		},
		onConfirm:function(dlg){
			var media = $("#J-video-media").val();
			if(!media) {
				DSXUI.error('请选择视频文件');
				return false;
			}
			var title = $("#J-video-title").val();
			if(!title){
				DSXUI.error('请填写视频名称');
				return false;
			}
			var introduction = $("#J-video-introduction").val();
			if(!introduction){
				DSXUI.error('请填写视频简介');
				return false;
			}
			var loading;
			$("#J-video-form").ajaxSubmit({
				url:"/?m=$_G[m]&c=$_G[c]&a=add&type=video",
				beforeSend: function(){
					dlg.close();
					loading = DSXUI.showloading('正在上传素材..');
				},
				success: function(json){
					setTimeout(function(){
						loading.close();
						if(json.errcode == 0){
							DSXUI.success('素材添加成功', DSXUtil.reFresh);
						}else {
							DSXUI.error('素材添加失败');
						}
					},1000)
				}
			});
		}
	});
});

$("#add_voice").click(function(e) {
	var loading;
    filePickerView({
		post_params:{uid:'<?php echo $_G[uid];?>',token:'<?php echo md5($_G[uid].FORMHASH); ?>'},
		onPicked:function(data){
			$.ajax({
				type:'POST',
				url:"<?php echo U('a=add&type=voice'); ?>",
				data:{media:data.name},
				beforeSend: function(){
					loading = DSXUI.showloading('正在上传素材..');
				},
				success: function(json){
					setTimeout(function(){
						loading.close();
						if(json.errcode == 0){
							DSXUI.success('素材添加成功', DSXUtil.reFresh);
						}else {
							DSXUI.error('素材添加失败');
						}
					},1000)
				}
			});
		}
	});
});
</script><?php include template('footer'); ?>