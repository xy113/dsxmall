<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="console-title">
	<div class="f-right">
    	<form name="search" action="/?">
          <input type="hidden" name="m" value="<?php echo $G[m];?>">
          <input type="hidden" name="c" value="<?php echo $G[c];?>">
          <input type="hidden" name="a" value="<?php echo $G[a];?>">
          <input type="hidden" name="type" value="<?php echo $type;?>">
          <input type="text" class="input-text" name="keyword" value="<?php echo $keyword;?>" placeholder="请输入关键字">
          <input type="submit" class="submit" value="<?php echo $lang[search];?>">
          <div class="button material-add-button"><span>添加素材</span><div class="swfbutton" id="swfbutton"></div></div>
      </form>
        
    </div>
    <h2>素材管理</h2>
</div>
<div class="toolbar">
    <?php if(is_array($lang[material_types])) { foreach($lang[material_types] as $k=>$v) { ?>    <a href="<?php echo U("type=$k"); ?>" class="baritem<?php if($type==$k) { ?> baritem-on<?php } ?>"><?php echo $v;?></a>
    <?php } } ?></div>
<div class="table-wrap">
    <form method="post" autocomplete="off" id="materialForm">
    <input type="hidden" name="formsubmit" value="yes" />
    <input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
    <thead>
      <tr>
        <th width="20" class="center">选?</th>
        <th width="50">图片</th>
        <th>名称</th>
        <th width="160">所属用户</th>
        <th width="80">大小</th>
        <th width="140">上传时间</th>
      </tr>
     </thead>
     <tbody>
      <?php if(is_array($itemlist)) { foreach($itemlist as $id=>$item) { ?>      <tr>
        <td class="center"><input type="checkbox" class="checkbox checkmark" name="id[]" value="<?php echo $item[id];?>"></td>
        <td>
        	<?php if($type=='image') { ?>
        	<img src="<?php echo image($item[thumb]); ?>" width="50" height="50">
            <?php } elseif($type=='video') { ?>
            <img src="/static/images/common/video.png" width="50" height="50">
            <?php } elseif($type=='voice') { ?>
            <img src="/static/images/common/audio.png" width="50" height="50">
            <?php } elseif($type=='doc') { ?>
            <img src="/static/images/common/doc.png" width="50" height="50">
            <?php } else { ?>
            <img src="/static/images/common/file.png" width="50" height="50">
            <?php } ?>
        </td>
        <td><?php echo $item[name];?></td>
        <td><?php echo $userlist[$item[uid]][username];?></td>
        <td><?php echo formatSize($item[size]); ?></td>
        <td><?php echo formatTime($item[dateline],'Y-m-d H:i:s'); ?></td>
      </tr>
      <?php } } ?>      </tbody>
      <tfoot>
      <tr>
        <td colspan="10">
            <label><input type="checkbox" class="checkbox checkall"> <?php echo $lang[selectall];?></label>
            <label><input type="radio" class="radio" name="option" value="delete" checked> 删除</label>
        </td>
      </tr>
      <tr>
          <td colspan="10">
              <span class="pages"><?php echo $pages;?></span>
              <input type="button" class="button" value="<?php echo $lang[submit];?>" id="submitButton">
              <input type="button" class="button cancel" value="<?php echo $lang[refresh];?>" onclick="window.location.reload()">
          </td>
      </tr>
     </tfoot>
    </table>
    </form>
</div><?php $token=md5($G[uid].FORMHASH);; ?><script type="text/javascript">
var spinner;
$("#submitButton").click(function(e) {
    if($("input.checkmark:checked").length > 0){
		$("#materialForm").ajaxSubmit({
			dataType:'json',
			beforeSend:function(){
				spinner = DSXUI.showSpinner();
			},
			success:function(json){
				setTimeout(function(){
					spinner.close();
					if(json.errcode == 0){
						DSXUtil.reFresh();
					}
				}, 1500);
			}
		});
	}else {
		DSXUI.error('请至少选择一个选项');
	}
});

var swfu = new DSXUpload({
	multi:false,
	upload_url : "/?m=jsapi&c=material&a=add_material&type=<?php echo $type;?>&from=swfupload",
	post_params:{uid:'$G[uid]',token:'$token'},
	file_types : '$file_types',
	button_id:'swfbutton',
	button_text:'',
	button_class:'swfbutton',
	button_width:'80',
	button_height:'28',
	onSelect:function(file){
		try {
			spinner = DSXUI.showSpinner();
		} catch (ex) {
			this.debug(ex);
		}
	},
	onUploadSuccess:function(file, data, response){
		//console.log(data);
		var json = $.parseJSON(data);
		setTimeout(function(){
			spinner.close();
			if(json.errcode == 0){
				DSXUtil.reFresh();
			}else {
				DSXUI.error(json.errmsg);
			}
		},1000);
	}
});
/*
$("#add_material").click(function(e) {
    var type = $(this).attr('data-type');
	var html = '<div class="ui-dialog-upload">';
	html+='<div class="title-bar"><div class="ui-button btn"><span>选择文件</span><div class="swfbutton" id="ui-dialog-swfbutton"></div></div></div>';
	html+='<div class="upload-div"><div class="scrollView"><div class="queue" id="ui-dialog-queue"></div></div></div>';
	html+='</div>';
	DSXUI.dialog({
		title:'添加素材',
		width:750,
		html:html,
		afterShow:function(dlg){
			var swfu = new DSXUpload({
				multi:true,
				upload_url : "/?m=jsapi&c=material&a=add_material&type="+type+"&from=swfupload",
				post_params:{},
				file_types : '*.*',
				button_id:'ui-dialog-swfbutton',
				button_text:'',
				button_class:'swfbutton',
				button_width:'80',
				button_height:'30',
				onSelect:function(file){
					try {
						var fileitem = '<div id="f_'+file.id+'" class="file-item"><div class="name">'+file.name+'</div>';
						fileitem+= '<div class="progress"><div class="bar"></div></div>';
						fileitem+= '<a class="icon cancel" title="取消上传">&#xf0155;</a><a class="icon success">&#xf0156;</a></div>';
						$("#ui-dialog-queue").append(fileitem).show();
						$("#f_"+file.id).find(".cancel").click(function(e) {
						   swfu.cancelUpload(file.id, false);
							//$("#f_"+file.id).fadeOut('slow', function(){$(this).remove();});
					   });
					} catch (ex) {
						this.debug(ex);
					}
				},
				onProgress:function(file, bytesLoaded, bytesTotal, percentage, averageSpeed){
					$("#f_"+file.id).find(".progress .bar").css('width',percentage+'%');
				},
				onUploadSuccess:function(file, data, response){
					//console.log(data);
					var json = $.parseJSON(data);
					$("#dialog-upload-queue").hide();
					if(json.errcode == 0) {
						var row = '<a id="file_'+json.data.attachid+'" attachid="'+json.data.attachid+'" attachurl="'+json.data.attachurl+'" attachment="'+json.data.attachment+'">'+json.data.attachname+'</a>';
						row = '<tr><td class="name">'+row+'</td><td width="80" class="size">'+json.data.formated_size+'</td></tr>';
						$("#file-list-table").prepend(row);
						$("#file_"+json.data.attachid).click(function(e) {
							if(opts.onPicked) opts.onPicked(json.data);
							 dlg.close();
						});
					}
					//loadFiles({type:current_type});
				},
				onUploadError:function(file, errorCode, errorMsg){
					alert(errorMsg);
				},
				onCancel:function(){
					$("#dialog-upload-queue").hide();
				}
			});
			
			
		},
		onConfirm:function(dlg){
			
		}
	});
});
*/
</script><?php include template('footer'); ?>