<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><script type="text/javascript">
$("img[rel=setimage]").setImage(function(o,data){
	var url = $(o).attr('data-action');
	url = typeof(url) !== 'undefined' ? url : '/?m=$G[m]&c=$G[c]&a=setimage';
	var requestData = $(o).attr("data-json");
	requestData = typeof(requestData) !== 'undefined' ? eval('('+requestData+')') : {};
	if(typeof requestData !== 'object') requestData = {};
	requestData.image = data.image;
	$.ajax({
		url:url,
		data:requestData,
		dataType:"json",
		success: function(json){
			if(json.errcode == 0) $(o).attr('src', data.imageurl);
		}
	});
});
$("img[rel=pickimage]").pickImage({multi:false,
	onPicked:function(o,data){
		var url = $(o).attr('data-action');
		url = typeof(url) !== 'undefined' ? url : '/?m=$G[m]&c=$G[c]&a=setimage';
		var requestData = $(o).attr("data-json");
		requestData = typeof(requestData) !== 'undefined' ? eval('('+requestData+')') : {};
		if(typeof requestData !== 'object') requestData = {};
		requestData.image = data.image;
		$.ajax({
			url:url,
			data:requestData,
			dataType:"json",
			success: function(json){
				if(json.errcode == 0) o.src = data.imageurl;
			}
		});
	}
});
$(".checkall").click(function(e) {
	var marker = $(this).attr('marker');
	if(typeof(marker) === 'undefined'){
		marker = 'input.checkmark';
	}
	$(marker).attr('checked', $(this).is(":checked"));
});
</script>
<div id="footer">
  <p></p>
  <p>©2015-<?php echo date('Y',time());; ?> <a href="http://www.songdewei.com" target="_blank">贵州大师兄信息技术有限公司</a> 版权所有，并保留所有权利。</p>
</div>
<div class="blank"></div>
</body>
</html>