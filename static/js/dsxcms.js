// JavaScript Document
$("[favorite]").click(function(e) {
    var dataid = $(this).attr('data-id');
	var datatype = $(this).attr('data-type');
	if(!dataid || !datatype) {
		return;
	}else {
		if(DSXUI.checkLogin()) {
			$.ajax({
				type:'POST',
				url:'/?m=jsapi&c=favorite&a=add_favorite',
				dataType:'json',
				data:{dataid:dataid,datatype:datatype},
				success: function(json){
					if(json.errcode == 0) DSXUI.success('添加收藏成功');
				}
			});
		}
	}
});