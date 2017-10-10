<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php $token=sha1($G['uid'].$G['username'].formhash());; ?><textarea name="<?php echo $editorname;?>" id="kindeditor" style="width:100%; height:400px;visibility:hidden; display:none;"><?php echo $editorcontent;?></textarea>
<link rel="stylesheet" href="/static/kindeditor/themes/default/default.css" />
<script src="/static/kindeditor/kindeditor-min.js" type="text/javascript"></script>
<script src="/static/kindeditor/lang/zh_CN.js" type="text/javascript"></script>
<script type="text/javascript">
var editor = KindEditor.create('#kindeditor', {
	allowFileManager : true,
	items : [
	'source', '|', 'undo', 'redo', '|', 'template', 'code', 'cut', 'copy', 'paste',
	'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
	'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
	'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
	'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
	'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'multiimage',
	'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
	'anchor', 'link', 'unlink'
	],
	afterBlur: function () {this.sync();},
	uploadJson : "<?php echo U('m=jsapi&c=kindeditor&a=upload'); ?>",
	fileManagerJson:"<?php echo U('m=jsapi&c=kindeditor&a=manager'); ?>",
	extraFileUploadParams:{uid:'<?php echo $G[uid];?>',username:'<?php echo $G[username];?>',token:'<?php echo $token;?>'}
});
</script>