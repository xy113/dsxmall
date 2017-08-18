// JavaScript Document
//对话框
function DSXDialog(settings){
    var option = $.extend({
        title:'窗口',
        yesBtn:'确定',
        noBtn:'取消',
        fixed:true,
        width:500,
        hideTitle:false,
        hideBottom:false
    },settings);
    var self = this;
    var header  = $('<div class="dialog-title"><strong>'+option.title+'</strong><span class="close">×</span></div>');
    var footer  = $('<div class="dialog-footer"><div class="ui-button ui-button-yes" tabindex="1">'+option.yesBtn+'</div>' +
        '<div class="ui-button ui-button-no" tabindex="1">'+option.noBtn+'</div></div>');
    var dialogCount = DSXDialog.__count;
    this.id = option.id ? option.id : 'ui-dialog-'+dialogCount;
    this.zIndex  = option.zIndex ? option.zIndex : dialogCount+1000;
    this.content = $('<div class="dialog-content"></div>');
    this.window  = $('<div id="'+this.id+'" class="ui-dialog"></div>').width(option.width).css({'z-index':this.zIndex+1});
    this.overLayer = $('<div id="ui-overlayer-'+dialogCount+'" class="ui-overlayer"></div>').css({'z-index':this.zIndex});
    option.hideBottom = option.hideFooter ? option.hideFooter : option.hideBottom;

    this.setContent = function(){
        if(option.html) {
            self.content.html(option.html);
        }else if(option.iframe) {
            self.ifameid = option.iframeid ? option.iframeid : self.id+'_iframe';
            self.content.html('<iframe id="'+self.ifameid+'" frameborder="0" style="width:100%; height:100%; display:block;" src="'+option.iframe+'"></iframe>');
        }else if(option.url) {
            $.ajax({
                url:option.url,
                dataType:'html',
                async:false,
                beforeSend: function(){
                    self.content.html('<div class="ui-ajax-loading"></div>');
                },
                success: function(c){
                    self.content.html(c);
                    self.setPosition();
                    if(option.afterLoad) option.afterLoad(self);
                }
            });
        }else if(option.selector){
            self.content.html($(option.selector).html());
        }
        self.setPosition();
    }

    this.setPosition = function(){
        var left = ($(window).width() - self.window.outerWidth()) / 2;
        var top = ($(window).height() - self.window.outerHeight()) / 2;
        if(option.fixed){
            self.window.css({top:top,left:left});
        }else{
            self.window.css({top:top+$(document).scrollTop(),left:left+$(document).scrollLeft()});
        }
    }

    this.close = function(){
        if(option.beforeClose) option.beforeClose(self);
        self.overLayer.remove();
        self.window.remove();
        if(option.afterClose) option.afterClose(self);
    }

    var init = function(){
        $(document.body).append(self.overLayer);
        $(document.body).append(self.window);
        if(!option.hideTitle) self.window.append(header);
        self.window.append(self.content);
        if(!option.hideBottom) self.window.append(footer);
        if(option.height) self.content.height(option.height);
        self.setPosition();
        self.setContent();

        var mouse={x:0,y:0};
        function moveDialog(event){
            var e = window.event || event;
            var top = parseInt(self.window.css('top')) + (e.clientY - mouse.y);
            var left = parseInt(self.window.css('left')) + (e.clientX - mouse.x);
            self.window.css({top:top,left:left});
            mouse.x = e.clientX;
            mouse.y = e.clientY;
        };
        self.window.find('.dialog-title').mousedown(function(event){
            var e = window.event || event;
            mouse.x = e.clientX;
            mouse.y = e.clientY;
            $(document).bind('mousemove',moveDialog);
            $(this).css('cursor','move');
        });
        $(document).mouseup(function(event){
            $(document).unbind('mousemove', moveDialog);
            self.window.find('.dialog-title').css('cursor','default');
        });

        /* 绑定一些相关事件。 */
        self.window.find('.close').on('click', self.close);
        self.window.find('.ui-button-yes').on('click', function(e){
            if(option.onConfirm) option.onConfirm(self);
        });
        self.window.find('.ui-button-no').on('click', function(e){
            if(option.onCancel) option.onCancel(self);
            self.close();
        });
        if(option.afterShow) option.afterShow(self);
    }
    init.call(this);
    DSXDialog.__count++;
}
DSXDialog.__count = 1;

function filePickerView(settings){
    var opts = $.extend({
        post_params:{},
        file_types:'*.mp3;*.wma;*.wav;*.amr;*.mp4;*.zip;*.gz;*.7z;*.doc;*.pdf'
    }, settings);
    var html = '<div class="ui-pickerview">';
    html+= '<div class="sider"><ul class="group-list" id="dialog-group-list"></ul></div>';
    html+= '<div class="pickerview-content"><div class="title-bar">';
    html+= '<div class="ui-button swfbtn"><a class="txt">上传文件</a><div id="dialog-upload-file"></div></div></div>';
    html+= '<div class="pickerview-scroll-hd"><div class="pickerview-scroll"><div class="file-list" id="dialog-file-list"></div></div>';
    html+= '<div class="dialog-upload-queue" id="dialog-upload-queue"></div>';
    html+= '</div></div></div>';
    var isLoading = false;
    var current_type = 'all';
    var dialog = new DSXDialog({
        title:'选择文件',
        width:850,
        html:html,
        hideBottom:true,
        afterShow:function(dlg){
            var file_types = '<li data-type="all"><a>全部</a></li>';
            file_types+= '<li data-type="video"><a>视频</a></li>';
            file_types+= '<li data-type="voice"><a>声音</a></li>';
            file_types+= '<li data-type="doc"><a>文档</a></li>';
            file_types+= '<li data-type="file"><a>其他</a></li>';
            $("#dialog-group-list").append(file_types);
            $("#dialog-group-list li").click(function(e) {
                current_type = $(this).attr('data-type');
                loadFiles({type:current_type});
            });
            var loadFiles = function(data){
                if(!data) data = {};
                if(isLoading) {
                    return false;
                }else {
                    isLoading = true;
                }
                $.ajax({
                    url:'/?m=jsapi&c=material&a=batchget_material&count=100&type='+current_type,
                    data:data,
                    dataType:"json",
                    success: function(json){
                        isLoading = false;
                        if(json.errcode == 0){
                            var table = '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="file-list-table" id="file-list-table">';
                            //table+= '<tr><th>名称</th><th class="type">类型</th><th class="size">大小</th></tr>';
                            //$(json.data).each(function(i, o) {
                            //     table+= '<tr><td>'+o.attachname+'</td><td>'+o.attachtype+'</td><td>'+o.formated_size+'</td></tr>';
                            // });
                            for(var i in json.data){
                                var o = json.data[i];
                                var link = '<a rel="file" fileid="'+o.id+'" url="'+o.url+'" name="'+o.name+'">'+o.name+'</a>';
                                table+= '<tr><td class="name">'+link+'</td><td width="80" class="size">'+o.formatted_size+'</td></tr>';
                            }
                            table+='</table>';
                            $("#dialog-file-list").html(table);
                            $("#file-list-table").find("a[rel=file]").click(function(e) {
                                var fileid = $(this).attr("fileid");
                                var filedata = json.data[fileid];
                                if(opts.onPicked) opts.onPicked(filedata);
                                dlg.close();
                            });
                        }
                    }
                });
            }
            loadFiles();
            //上传文件
            var uploadFiles = function(){
                var swfu = new DSXUpload({
                    multi:false,
                    upload_url : "/?m=jsapi&c=material&a=add_material&type="+current_type+"&from=swfupload",
                    post_params:opts.post_params,
                    file_types : opts.file_types,
                    button_id:'dialog-upload-file',
                    button_text:'',
                    button_class:'swf',
                    button_width:'80',
                    button_height:'30',
                    onSelect:function(file){
                        try {
                            var fileitem = '<div id="f_'+file.id+'" class="file-upload-item"><div class="name">'+file.name+'</div>';
                            fileitem+= '<div class="progress"><div class="bar"></div></div>';
                            fileitem+= '<a class="icon cancel" title="取消上传">&#xf0155;</a><a class="icon success">&#xf0156;</a></div>';
                            $("#dialog-upload-queue").html(fileitem).show();
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
                        console.log(data);
                        var json = $.parseJSON(data);
                        $("#dialog-upload-queue").hide();
                        if(json.errcode == 0) {
                            var row = '<a id="file_'+json.data.id+'" fileid="'+json.data.id+'" url="'+json.data.url+'" name="'+json.data.name+'">'+json.data.name+'</a>';
                            row = '<tr><td class="name">'+row+'</td><td width="80" class="size">'+json.data.formatted_size+'</td></tr>';
                            $("#file-list-table").prepend(row);
                            $("#file_"+json.data.id).click(function(e) {
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
            }
            uploadFiles();
        }
    });
    return dialog;
}

function createAlbumDialog(post_data, callback){
    var html = '<div class="dialog-create-album">';
    html+= '<form method="post" id="dialog-create-album-form" method="post">';
    html+= '	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="ui-table">';
    html+= '		<tbody>';
    html+= '		<tr>';
    html+= '			<td>相册名称:</td>';
    html+= '			<td><input type="text" class="ui-textfield" name="title"></td>';
    html+= '			<td>1-20个汉字、英文字母、数字或下划线</td>';
    html+= '		</tr>';
    html+= '		<tr>';
    html+= '			<td>是否公开:</td>';
    html+= '			<td>';
    html+= '				<label><input type="radio" class="ui-radio" value="1" name="isopen" checked onclick="$(\'#tbody-password\').hide()"> 是 </label>&nbsp;&nbsp;';
    html+= '				<label><input type="radio" class="ui-radio" value="0" name="isopen" onclick="$(\'#tbody-password\').show()"> 否</label>';
    html+= '			</td>';
    html+= '			<td>&nbsp;</td>';
    html+= '		</tr>';
    html+= '		</tbody>';
    html+= '		<tbody id="tbody-password" style="display:none;">';
    html+= '			  <tr>';
    html+= '				<td>查看密码:</td>';
    html+= '				<td><input type="password" class="ui-textfield" name="password"></td>';
    html+= '				<td>6-20个英文字母、数字或符合组合</td>';
    html+= '			  </tr>';
    html+= '		</tbody>';
    html+= '	</table>';
    html+= '</form>';
    html+= '</div>';
    return new DSXUI.dialog({
        width:550,
        title:'创建相册',
        html:html,
        hideBottom:false,
        //提交
        onConfirm:function(dlg){
            var form = $("#dialog-create-album-form");
            var title = form.find("input[name=title]").val();
            if(!$.trim(title)){
                DSXUI.error('请输入相册名称');
                return false;
            }
            if(!/^[a-zA-Z0-9_\u4e00-\u9fa5]{1,20}$/.test(title)){
                DSXUI.error('相册名称输入错误');
                return false;
            }
            var isopen = form.find("input[name=isopen]:checked").val();
            var password = form.find("input[name=password]").val();
            if(isopen == '0'){
                if(!DSXUtil.IsPassword(password)){
                    DSXUI.error('相册密码输入错误');
                    return false;
                }
            }
            if(!post_data) post_data = {};
            post_data = $.extend(post_data,{
                title:title,
                isopen:isopen,
                password:password
            });
            $.ajax({
                url:'/?m=jsapi&c=album&a=add_album',
                dataType:'json',
                type:'POST',
                data:post_data,
                success:function(json){
                    dlg.close();
                    if(json.errcode == 0){
                        DSXUI.success('相册创建成功',function(){
                            if(callback) callback(json.data);
                        });
                    }else {
                        DSXUI.error(json.errmsg);
                    }
                }
            });
        }
    });
}

function imagePickerView(settings){
    var opts = $.extend({
        multi:false
    },settings);
    var html = '<div class="ui-pickerview">';
    html+= '<div class="sider"><ul class="group-list" id="dialog-album-list"></ul>';
    html+= '<ul class="group-list"><li><a id="dialog-add-album"><i class="icon">&#xf0175;</i>创建分组</a></li></ul></div>';
    html+= '<div class="pickerview-content"><div class="title-bar">';
    html+= '<form method="post" autocomplete="off" enctype="multipart/form-data" id="dialog-upload-form">';
    html+= '<a class="ui-button btn">上传图片<input type="file" name="filedata" class="filedata" id="dialog-filedata"></a></form></div>'
    html+= '<div class="pickerview-scroll-hd"><div class="pickerview-scroll"><div class="image-list" id="dialog-image-list"></div></div>';
    html+= '<div class="ajax-loader" id="dialog-ajax-loader"></div>';
    html+= '</div></div></div>';
    var current_albumid = 0;
    var selectedImages = [];
    var imageList = [];
    var isLoading = false;
    return new DSXDialog({
            width:'850',
            title:'选择图片',
            hideBottom:false,
            html:html,
            afterShow:function(dlg){
                var loadAlbums = function(){
                    $.getJSON('/?m=jsapi&c=album&a=batchget_album', function(json){
                        if(json.errcode == 0){
                            $(json.data).each(function(i, o) {
                                $("#dialog-album-list").append('<li albumid="'+o.albumid+'"><a>'+o.title+'('+o.total_count+')</a></li>');
                                $("#dialog-album-list li").click(function(e) {
                                    current_albumid = $(this).attr('albumid');
                                    loadPhotos(current_albumid);
                                });
                            });
                        }
                    });
                }
                loadAlbums();

                //加载照片
                var loadPhotos = function(albumid){
                    if(!albumid) albumid = 0;
                    if(isLoading) {
                        return false;
                    }else {
                        isLoading = true;
                    }
                    $.ajax({
                        url:'/?m=jsapi&c=material&a=batchget_material&type=image',
                        data:{albumid:albumid},
                        dataType:"json",
                        success: function(json){
                            isLoading = false;
                            if(json.errcode == 0){
                                var imageItems = '';
                                imageList = json.data;
                                $("#dialog-image-list").empty();
                                $(imageList).each(function(i, o) {
                                    var imageLink = '<dd style="background-image:url('+o.thumburl+');"><div><i><i></div></dd>'
                                    var imageItem = '<dl photoid="'+o.id+'" image="'+o.image+'" thumb="'+o.thumb+'" imageurl="'+o.imageurl+'" thumburl="'+o.thumburl+'">'+imageLink+'</dl>';
                                    $("#dialog-image-list").append(imageItem);
                                });
                                $("#dialog-image-list dl").click(function(e) {
                                    if(opts.multi){
                                        if($(this).hasClass("checked")){
                                            $(this).removeClass("checked");
                                        }else {
                                            $(this).addClass("checked");
                                        }
                                    }else {
                                        $(this).addClass("checked").siblings().removeClass("checked");
                                    }
                                });
                            }
                        }
                    });
                }
                loadPhotos();
                $("#dialog-filedata").change(function(){
                    //var loading;
                    $("#dialog-upload-form").ajaxSubmit({
                        url:'/?m=jsapi&c=material&a=add_material&type=image',
                        data:{albumid:current_albumid},
                        dataType:'json',
                        beforeSend:function(){
                            //loading = DSXUI.showloading('在上上传图片...');
                            $("#dialog-ajax-loader").show();
                        },
                        success:function(json){
                            setTimeout(function(){
                                $("#dialog-ajax-loader").hide();
                                if(json.errcode == 0){
                                    loadPhotos(current_albumid);
                                }
                            }, 1500);
                        }
                    });
                });
                //创建相册
                $("#dialog-add-album").click(function(e) {
                    var albumdlg = createAlbumDialog({},function(data){
                        var album = $('<li albumid="'+data.albumid+'"><a>'+data.title+'(0)</a></li>').click(function(e) {
                            current_albumid = data.albumid;
                            loadPhotos(data.albumid);
                        });
                        $("#dialog-album-list").append(album);
                    });
                });
            },
            //=======================
            onConfirm:function(dlg){
                if($("#dialog-image-list dl.checked").length > 0){
                    if(opts.multi) {
                        var selectedImages = [];
                        $("#dialog-image-list dl.checked").each(function(i, dl) {
                            var imgdata = {};
                            var imgobj = $(dl);
                            imgdata.id = imgobj.attr('photoid');
                            imgdata.image = imgobj.attr('image');
                            imgdata.thumb = imgobj.attr('thumb');
                            imgdata.imageurl = imgobj.attr('imageurl');
                            imgdata.thumburl = imgobj.attr('thumburl');
                            selectedImages.push(imgdata);
                        });
                        if(opts.onPicked) opts.onPicked(selectedImages);
                    }else {
                        var imgobj = $($("#dialog-image-list dl.checked")[0]);
                        var imgdata = {};
                        imgdata.id = imgobj.attr('photoid');
                        imgdata.image = imgobj.attr('image');
                        imgdata.thumb = imgobj.attr('thumb');
                        imgdata.imageurl = imgobj.attr('imageurl');
                        imgdata.thumburl = imgobj.attr('thumburl');
                        if(opts.onPicked) opts.onPicked(imgdata);
                    }
                    dlg.close();
                }else {
                    DSXUI.error('请选择图片');
                }
            }
        }
    );
}

;(function($){
    $.fn.Jscroll = function(settings){
        settings = $.extend({
            speed : 3000,
            animateSpeed:1000,
            direction : 'left',
            width:300,
            height:300,
            arrowLeft:'',
            arrowRight:''
        },settings);
        var that = this;
        var ul = $(this).find("ul");
        $(this).css({'overflow':'hidden','height':settings.height});
        if(settings.direction == 'left' || settings.direction == 'right') ul.css({'width':1000,'height':settings.height});
        that.t = setInterval(function(){that.AutoPlay();},settings.speed);
        that.scrollLeft = function(){
            ul.animate({marginLeft:-settings.width+"px"},settings.animateSpeed,function(){
                //把第一个li丢最后面去
                ul.css({marginLeft:0}).find("li:first").appendTo(ul);
            });
        }
        that.scrollRight = function(){
            ul.css({marginLeft:-settings.width+"px"}).find("li:last").prependTo(ul);
            ul.animate({marginLeft:0},settings.animateSpeed,function(){
                //把第一个li丢最后面去
            });
        }
        that.scrollUp = function(){
            ul.animate({marginTop:-settings.height+"px"},settings.animateSpeed,function(){
                //把第一个li丢最后面去
                ul.css({marginTop:0}).find("li:first").appendTo(ul);
            });
        }
        that.scrollDown = function(){
            ul.css({marginTop:-settings.height+"px"}).find("li:last").prependTo(ul);
            ul.animate({marginTop:0},settings.animateSpeed,function(){
                //把第一个li丢最后面去
            });
        }
        that.AutoPlay = function(){
            if(settings.direction == 'right'){
                that.scrollRight();
            }else if(settings.direction == 'up'){
                that.scrollUp();
            }else if(settings.direction == 'down'){
                that.scrollDown();
            }else{
                that.scrollLeft();
            }
        }
        $(this).hover(function(){
                clearTimeout(that.t);
            },
            function(){
                that.t = setInterval(function(){that.AutoPlay();},settings.speed);
            });
        $(this).find(settings.arrowLeft).bind('click',that.scrollRight);
        $(this).find(settings.arrowRight).bind('click',that.scrollLeft);
    }
})(jQuery);

/*
 * jQuery JavaScript Library Marquee Plus 1.0
 * http://mzoe.com/
 *
 * Copyright (c) 2009 MZOE
 * Dual licensed under the MIT and GPL licenses.
 *
 * Date: 2009-05-13 18:54:21
 */
;(function($) {
    $.fn.marquee = function(o) {
        //获取滚动内容内各元素相关信息
        o = $.extend({
            speed:30, // 滚动速度
            step:1, // 滚动步长
            direction:'left', // 滚动方向
            pause: 0, // 停顿时长
            container:'ul',
            items : 'li'
        }, o || {});
        var dIndex = $.inArray(o.direction, ['right', 'down']);
        if (dIndex > -1) {
            o.direction = ['left', 'up'][dIndex];
            o.step = -o.step;
        }
        var mid;
        var div 		= $(this); // 容器对象
        var divWidth 	= div.innerWidth(); // 容器宽
        var divHeight 	= div.innerHeight(); // 容器高
        var ul 			= div.find(o.container);
        var li 			= ul.find(o.items);
        var liSize 		= li.size(); // 初始元素个数
        var liWidth 	= li.width(); // 元素宽
        var liHeight 	= li.height(); // 元素高
        var width 		= liWidth * liSize;
        var height 		= liHeight * liSize;
        div.height(liHeight);
        if ((o.direction == 'left' && width > divWidth) ||
            (o.direction == 'up' && height > divHeight)) {
            // 元素超出可显示范围才滚动
            if (o.direction == 'left') {
                ul.width(2 * liSize * liWidth);
                if (o.step < 0) div.scrollLeft(width);
            } else {
                ul.height(2 * liSize * liHeight);
                if (o.step < 0) div.scrollTop(height);
            }
            ul.append(li.clone()); // 复制元素
            mid = setInterval(_marquee, o.speed);
            div.hover(
                function(){clearInterval(mid);},
                function(){mid = setInterval(_marquee, o.speed);}
            );
        }
        function _marquee() {
            // 滚动
            if (o.direction == 'left') {
                var l = div.scrollLeft();
                if (o.step < 0) {
                    div.scrollLeft((l <= 0 ? width : l) + o.step);
                } else {
                    div.scrollLeft((l >= width ? 0 : l) + o.step);
                }
                if (l % liWidth == 0) _pause();
            } else {
                var t = div.scrollTop();
                if (o.step < 0) {
                    div.scrollTop((t <= 0 ? height : t) + o.step);
                } else {
                    div.scrollTop((t >= height ? 0 : t) + o.step);
                }
                if (t % liHeight == 0) _pause();
            }
        }
        function _pause() {
            // 停顿
            if (o.pause > 0) {
                var tempStep = o.step;
                o.step = 0;
                setTimeout(function() {
                    o.step = tempStep;
                }, o.pause);
            }
        }
    };
})(jQuery);

;(function($){
    $.fn.extend({
        confirm : function(settings){
            var option = $.extend({
                event:'click',
                text:'确定要删除吗?',
                btnYes:'确定',
                btnNo:'取消'
            },settings);

            var div = $('<div id="ui-confirm-box" class="ui-confirm-box">'+
                '<dl><dt class="txt">'+option.text+'</dt><dd><span class="btn btn-yes" tabindex="1">'+option.btnYes+'</span>'+
                '<span class="btn btn-no" tabindex="1">'+option.btnNo+'</span></dd></dl></div>');
            $(this).on(option.event,function(e) {
                if(e.stopPropagation){
                    e.stopPropagation();
                }else{
                    e.cancelBubble = true;
                }
                var self = this;
                var position = $(this).offset();
                var top = parseInt((position.top+$(this).outerHeight())) + 7;
                $(document.body).append(div);
                div.css({"top":top+"px","display":"none",'position':'absolute'}).fadeIn("fast");
                /*
                if((position.left + div.width()) > $(document).width()){
                    div.css({'right':$(document).width() - (position.left+$(this).outerWidth())+'px'});
                }else {
                    div.css({'left':position.left+'px'});
                }
                */
                if(position.left > $(document).width()/2){
                    div.css({'right':$(document).width() - (position.left+$(this).outerWidth())+'px'});
                }else {
                    div.css({'left':position.left+'px'});
                }
                div.find(".btn-yes").one('click',function(){
                    div.remove();
                    if(option.onConfirm) option.onConfirm(div,self);
                });
                div.find(".btn-no").click(function(){
                    div.remove();
                    if(option.onCancel) option.onCancel(div,self);
                });
                div.click(function(event){
                    var e = window.event || event;
                    if(e.stopPropagation){
                        e.stopPropagation();
                    }else{
                        e.cancelBubble = true;
                    }
                });
                $(document).on('click',function(){div.remove();});
            });
        },
        showPrompt:function(){
            var that = this;
            var tips  = $('<div class="ui-tips-box" id="ui-tips-box"></div>');
            var arrow = $('<div class="ui-tips-arrow" id="ui-tips-arrow"></div>');
            this.show = function(){
                $(document.body).append(tips);
                $(document.body).append(arrow);
                tips.empty().text($(this).attr('prompt'));
                var offset = $(this).offset();
                var left = offset.left + $(that).outerWidth()/2;
                arrow.css({top:offset.top-14, left:left-8});

                var tipsLeft = offset.left - (tips.outerWidth() - $(this).outerWidth())/2;
                tips.css({top:offset.top-$(tips).outerHeight()-8, left:tipsLeft});
            }
            this.hide = function(){
                tips.remove();
                arrow.remove();
            }

            $(this).hover(this.show,this.hide);
        },
        setImage : function(success,error){
            var that = this;
            var el = null;
            var div = $("<div/>").attr("id","ui-setimage-dialog").height(0);
            var form = $('<form id="ui-setimage-form" enctype="multipart/form-data" method="POST" action="/?m=jsapi&c=material&a=uploadimg"></form>');
            var file = $('<input type="file" name="filedata" title="点击上传图片">').css({'opacity':'0','position':'absolute','z-index':'500','cursor':'pointer'});

            form.append(file);
            div.append(form);
            $(file).change(function(e) {
                var loading;
                form.ajaxSubmit({
                    dataType:'json',
                    beforeSend:function(){
                        loading = DSXUI.showloading('正在上传图片');
                    },
                    success:function(json){
                        loading.close();
                        if(json.errcode == 0){
                            $(el).attr('src',json.data.imageurl);
                            if(success) success(el,json.data);
                        }else {
                            DSXUI.error('上传失败');
                            if(error) error(json);
                        }
                    }
                });
            });
            $(this).each(function(index, element) {
                $(element).mouseover(function(){
                    el = element;
                    var offset = $(this).offset();
                    file.css({'left':offset.left,'top':offset.top,'width':$(this).width(),'height':$(this).height()});
                    $(document.body).append(div);
                });
            });
        },
        //图片选择器
        pickImage : function(settings){
            var opts = $.extend({
                event:'click',
                multi:false
            },settings);

            var self;
            $(this).on(opts.event,function(e) {
                self = this;
                return new imagePickerView({
                    multi:opts.multi,
                    onPicked:function(data){
                        if(opts.onPicked) opts.onPicked(self, data);
                    }
                });
            });
        },
        //文件选择器
        pickFile:function(settings){
            var opts = $.extend({
                event:'click',
                post_params:{}
            }, settings);
            var self = this;
            $(this).on(opts.event,function(e) {
                var o = this;
                return filePickerView({
                    post_params:opts.post_params,
                    onPicked:function(data){
                        if(opts.onPicked) opts.onPicked(o, data);
                    }
                });
            });
        }
    });
})(jQuery);