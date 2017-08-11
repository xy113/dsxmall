(function($){
    $.fn.extend({
        //层居中
        center: function (settings) {
            settings = $.extend({'fixed':true},settings);
            return this.each(function() {
                var top = ($(window).height() - $(this).outerHeight()) / 2;
                var left = ($(window).width() - $(this).outerWidth()) / 2;
                if(settings.fixed){
                    $(this).css({position:'fixed', margin:0, top:top,left:left});
                }else{
                    $(this).css({
                        position:'absolute',
                        margin:0,
                        top:top+$(document).scrollTop(),
                        left:left+$(document).scrollLeft()
                    });
                }
            });
        },
        //层可拖动
        dragable:function(options){
            options = $.extend({},options);
            var self = this;
            var mouse = {x:0,y:0};
            $(this).css({'position':'absolute','z-index':1000});
            this.moveDiv = function(event){
                var e = window.event || event;
                var position = $(self).offset();
                var top = position.top + (e.clientY - mouse.y);
                var left = position.left + (e.clientX - mouse.x);
                $(self).css({top:top,left:left});
                mouse.x = e.clientX;
                mouse.y = e.clientY;
            }
            var handle = options.handle ? $(options.handle) : $(this);
            handle.mousedown(function(event){
                var e = window.event || event;
                mouse.x = e.clientX;
                mouse.y = e.clientY;
                $(document).bind('mousemove',self.moveDiv);
            });
            $(document).mouseup(function(){
                $(document).unbind('mousemove',self.moveDiv);
            });
        },
        //当前位置插入内容
        insertContent: function(myValue, t) {
            var $t = $(this)[0];
            if (document.selection) { //ie
                this.focus();
                var sel = document.selection.createRange();
                sel.text = myValue;
                sel.moveStart('character', -l);
                var wee = sel.text.length;
                if (arguments.length == 2) {
                    var l = $t.value.length;
                    sel.moveEnd("character", wee + t);
                    t <= 0 ? sel.moveStart("character", wee - 2 * t - myValue.length) : sel.moveStart("character", wee - t - myValue.length);
                    sel.select();
                }
            } else if ($t.selectionStart || $t.selectionStart == '0') {
                var startPos = $t.selectionStart;
                var endPos = $t.selectionEnd;
                var scrollTop = $t.scrollTop;
                $t.value = $t.value.substring(0, startPos) + myValue + $t.value.substring(endPos, $t.value.length);
                this.focus();
                $t.selectionStart = startPos + myValue.length;
                $t.selectionEnd = startPos + myValue.length;
                $t.scrollTop = scrollTop;
                if (arguments.length == 2) {
                    $t.setSelectionRange(startPos - t, $t.selectionEnd + t);
                    this.focus();
                }
            }
            else {
                this.value += myValue;
                this.focus();
            }
        },
        //表单验证
        validate:function(option){
            var self  = this;
            var form  = $(this);
            var tips  = $('<div/>').addClass("ui-tips-box ui-form-tips").css({'z-index':'10005'});
            var arrow = $('<div/>').addClass("ui-tips-arrow ui-form-tips").css({'z-index':'10005'});
            var validateItems = $(this).find("[required]");
            this.flag = true;
            this.showPrompt = function(o,text){
                self.hidePrompt();
                $("body").append(tips);
                $("body").append(arrow);
                tips.empty().text(text);
                var offset = $(o).offset();
                arrow.css({top:offset.top-14, left:offset.left + 10});
                tips.css({top:offset.top-$(tips).outerHeight()-8, left:offset.left});
            }
            this.hidePrompt = function(){
                $(".ui-form-tips").remove();
            }

            this.validateItem = function(o){
                var value   = $.trim($(o).val());
                var regular = $(o).attr("regular");
                var errmsg  = $(o).attr('error');
                if(value == undefined) value = '';
                if(regular == undefined || regular == ''){
                    if(value.length < 1){
                        if(errmsg != undefined && errmsg != '') self.showPrompt(o, errmsg);
                        self.flag = false;
                    }
                }else {
                    regular = eval(regular);
                    if(!regular.test(value)){
                        if(errmsg != undefined) self.showPrompt(o, errmsg);
                        self.flag = false;
                    }
                }
            }

            this.validateForm = function(){
                $(self).find("[required]").each(function(index, element) {
                    if(self.flag) self.validateItem(element);
                });
            }

            this.bind = function(){
                $(self).find("[prompt]").each(function(index, element) {
                    if($(element).attr('prompt') != undefined){
                        $(element).focus(function(e) {
                            self.showPrompt(element, $(element).attr('prompt'));
                        });
                    }
                    $(element).blur(function(e) {
                        self.hidePrompt();
                    });
                });
            }

            this.bind();
            this.validateForm();
            return this.flag;
        }
    });
})(jQuery);
//AJAX上传图片
;(function($) {
    $.fn.AjaxFileUpload = function(options) {
        var defaults = {
                action:     "upload.php",
                dataType:   'json',
                data:{},
                onChange:   function(filename) {},
                onSubmit:   function(filename) {},
                onComplete: function(filename, response) {}
            },
            settings = $.extend({}, defaults, options),
            randomId = (function() {
                var id = 0;
                return function () {
                    return "_AjaxFileUpload" + id++;
                };
            })();

        return this.each(function() {
            var $this = $(this);
            if ($this.is("input") && $this.attr("type") === "file") {
                $this.bind("change", onChange);
            }
        });

        function onChange(e) {
            var $element = $(e.target),
                id       = $element.attr('id'),
                $clone   = $element.removeAttr('id').clone().attr('id', id).AjaxFileUpload(options),
                filename = $element.val().replace(/.*(\/|\\)/, ""),
                iframe   = createIframe(),
                form     = createForm(iframe);

            // We append a clone since the original input will be destroyed
            $clone.insertBefore($element);
            settings.onChange.call($clone[0], filename);
            iframe.bind("load", {element: $clone, form: form, filename: filename}, onComplete);
            form.append($element).bind("submit", {element: $clone, iframe: iframe, filename: filename}, onSubmit).submit();
        }

        function onSubmit(e) {
            var data = settings.onSubmit.call(e.data.element, e.data.filename);
            // If false cancel the submission
            if (data === false) {
                // Remove the temporary form and iframe
                $(e.target).remove();
                e.data.iframe.remove();
                return false;
            } else {
                // Else, append additional inputs
                for (var variable in data) {
                    $("<input />")
                        .attr("type", "hidden")
                        .attr("name", variable)
                        .val(data[variable])
                        .appendTo(e.target);
                }
            }
        }

        function onComplete (e) {
            var $iframe  = $(e.target),
                doc      = ($iframe[0].contentWindow || $iframe[0].contentDocument).document;
            //	response = doc.body.innerHTML;
            var docRoot = doc.body ? doc.body : doc.documentElement;
            var response = docRoot ? docRoot.innerHTML : null;
            // If you add mimetype in your response,
            // you have to delete the '<pre></pre>' tag.
            // The pre tag in Chrome has attribute, so have to use regex to remove
            var rx = new RegExp("<pre.*?>(.*?)</pre>","i");
            var am = rx.exec(response);
            //this is the desired data extracted
            var response = am ? am[1] : response;    //the only submatch or empty
            if (response) {
                if (settings.dataType.toLowerCase() == 'json') response = $.parseJSON(response);
            } else {
                response = {};
            }

            settings.onComplete.call(e.data.element, e.data.filename, response);

            // Remove the temporary form and iframe
            e.data.form.remove();
            $iframe.remove();
        }

        function createIframe() {
            var id = randomId();
            // The iframe must be appended as a string otherwise IE7 will pop up the response in a new window
            $("body").append('<iframe src="javascript:false;" name="' + id + '" id="' + id + '" style="display: none;"></iframe>');
            return $('#' + id);
        }

        function createForm(iframe) {
            return $("<form />")
                .attr({
                    method: "post",
                    action: settings.action,
                    enctype: "multipart/form-data",
                    target: iframe[0].name
                })
                .hide()
                .appendTo("body");
        }
    };
})(jQuery);

function DistrictSelector(optons) {
    var opts = $.extend({
        province:'',
        city:'',
        county:'',
        province_selector:'#province',
        city_selector:'#city',
        county_selector:'#county',
        valueType:'name'
    }, optons);
    var bindData = function(element,fid, defvalue, callback){
        if(!fid) fid = 0;
        if(!defvalue) defvalue = 0;
        $.ajax({
            url:'/?m=jsapi&c=district&a=batchget_district&fid='+fid,
            dataType:"json",
            success: function(json){
                if(json.errcode == 0){
                    var optionHtml = '<option value="">请选择</option>';
                    $(json.data).each(function(i, data) {
                        var val,sel;
                        if(opts.valueType == 'id') {
                            val = data.id;
                            sel = defvalue == data.id ? ' selected="selected"' : '';
                        }else {
                            val = data.name;
                            sel = defvalue == data.name ? ' selected="selected"' : '';
                        }
                        optionHtml+= '<option value="'+val+'" idvalue='+data.id+sel+'>'+data.name+'</option>';
                    });
                    $(element).html(optionHtml);
                    if(callback) callback();
                }else {
                    console.log(json);
                }
            }
        });
    }

    if($(opts.province_selector).length > 0) {
        bindData(opts.province_selector, 0, opts.province, function () {
            if($(opts.city_selector).length > 0){
                $(opts.province_selector).on('change', function(e){
                    var proid = $(this).find("option:selected").attr('idvalue');
                    if(proid > 0){
                        bindData(opts.city_selector, proid, opts.city, function () {
                            if($(opts.county_selector).length > 0){
                                $(opts.city_selector).on('change', function(e){
                                    var cityid = $(this).find("option:selected").attr('idvalue');
                                    if(cityid > 0) {
                                        bindData(opts.county_selector, cityid, opts.county);
                                    }else {
                                        $(opts.county_selector).html('<option value="">请选择</option>');
                                    }
                                }).change();
                            }
                        });
                    }else {
                        $(opts.city_selector).html('<option value="">请选择</option>');
                        $(opts.county_selector).html('<option value="">请选择</option>');
                    }
                }).change();
            }
        });
    }
}

//验证
var DSXValidate = {
    IsURL : function(url){
        return /^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\:+!]*([^<>])*$/.test(url);
    },
    IsChineseName:function(username){
        return /^[\u4e00-\u9fa5]{2,12}$/.test(username);
    },
    IsUserName:function(username){
        return /^[a-zA-Z0-9_\u4e00-\u9fa5]{2,20}$/.test(username);
    },
    IsEmail : function(email){
        return /^[-._A-Za-z0-9]+@([A-Za-z0-9]+\.)+[A-Za-z]{2,3}$/.test(email);
    },
    IsMobile : function(num){
        return /^1[3|4|5|7|8]\d{9}$/.test(num);
    },
    IsPassword : function(str){
        return /^.{6,20}$/.test(str);
    },
    IsIdCardNo : function(idCard){
        var Wi = [ 7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2, 1 ];    // 加权因子
        var ValideCode = [ 1, 0, 10, 9, 8, 7, 6, 5, 4, 3, 2 ];            // 身份证验证位值.10代表X
        /**
         * 判断身份证号码为18位时最后的验证位是否正确
         * @param a_idCard 身份证号码数组
         * @return
         */
        this.isTrueValidateCodeBy18IdCard = function(a_idCard) {
            var sum = 0;                             // 声明加权求和变量
            if (a_idCard[17].toLowerCase() == 'x') {
                a_idCard[17] = 10;                    // 将最后位为x的验证码替换为10方便后续操作
            }
            for ( var i = 0; i < 17; i++) {
                sum += Wi[i] * a_idCard[i];            // 加权求和
            }
            valCodePosition = sum % 11;                // 得到验证码所位置
            if (a_idCard[17] == ValideCode[valCodePosition]) {
                return true;
            } else {
                return false;
            }
        }
        /**
         * 验证18位数身份证号码中的生日是否是有效生日
         * @param idCard 18位书身份证字符串
         * @return
         */
        this.isValidityBrithBy18IdCard = function(idCard18){
            var year =  idCard18.substring(6,10);
            var month = idCard18.substring(10,12);
            var day = idCard18.substring(12,14);
            var temp_date = new Date(year,parseFloat(month)-1,parseFloat(day));
            // 这里用getFullYear()获取年份，避免千年虫问题
            if(temp_date.getFullYear()!=parseFloat(year)
                ||temp_date.getMonth()!=parseFloat(month)-1
                ||temp_date.getDate()!=parseFloat(day)){
                return false;
            }else{
                return true;
            }
        }
        /**
         * 验证15位数身份证号码中的生日是否是有效生日
         * @param idCard15 15位书身份证字符串
         * @return
         */
        this.isValidityBrithBy15IdCard = function(idCard15){
            var year =  idCard15.substring(6,8);
            var month = idCard15.substring(8,10);
            var day = idCard15.substring(10,12);
            var temp_date = new Date(year,parseFloat(month)-1,parseFloat(day));
            // 对于老身份证中的你年龄则不需考虑千年虫问题而使用getYear()方法
            if(temp_date.getYear()!=parseFloat(year)
                ||temp_date.getMonth()!=parseFloat(month)-1
                ||temp_date.getDate()!=parseFloat(day)){
                return false;
            }else{
                return true;
            }
        }
        idCard = idCard.replace(/ /g, "");               //去掉字符串头尾空格
        idCard = idCard.replace(/(^\s*)|(\s*$)/g, "");
        if (idCard.length == 15) {
            return this.isValidityBrithBy15IdCard(idCard);       //进行15位身份证的验证
        } else if (idCard.length == 18) {
            var a_idCard = idCard.split("");                // 得到身份证数组
            if(this.isValidityBrithBy18IdCard(idCard)&&this.isTrueValidateCodeBy18IdCard(a_idCard)){   //进行18位身份证的基本验证和第18位的验证
                return true;
            }else {
                return false;
            }
        } else {
            return false;
        }
    }
}

var DSXUtil = {
    mb_cutstr : function(str, maxlen, dot) {
        var len = 0;
        var ret = '';
        var dot = !dot ? '...' : '';
        maxlen = maxlen - dot.length;
        for(var i = 0; i < str.length; i++) {
            len += str.charCodeAt(i) < 0 || str.charCodeAt(i) > 255 ? (charset == 'utf-8' ? 3 : 2) : 1;
            if(len > maxlen) {
                ret += dot;
                break;
            }
            ret += str.substr(i, 1);
        }
        return ret;
    },
    paramToJSON : function(str){
        if(!str) return;
        var json = {};
        var arr = str.split('&');
        $.each(arr,function(i,o){
            var arr2 = o.split('=');
            json[arr2[0]] = arr2[1] ? arr2[1] : '';
        });
        return json;
    },
    randomString : function (len) {
        len = len || 32;
        var $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        /****默认去掉了容易混淆的字符oOLl,9gq,Vv,Uu,I1****/
        var maxPos = $chars.length;
        var pwd = '';
        for (i = 0; i < len; i++) {
            pwd += $chars.charAt(Math.floor(Math.random() * maxPos));
        }
        return pwd;
    },
    getQueryString : function(item){
        var svalue = location.search.match(new RegExp("[\?\&]" + item + "=([^\&]*)(\&?)","i"));
        return svalue ? svalue[1] : svalue;
    },
    setCookie : function(name, value, expiresHours) {
        var cookieString = name + "=" + escape(value);
        //判断是否设置过期时间
        if(expiresHours > 0){
            var date = new Date();
            date.setTime(date.getTime() + expiresHours * 3600 * 1000);
            cookieString = cookieString + "; expires=" + date.toGMTString();
        }
        document.cookie = cookieString;
    },
    getCookie : function(strName){
        var strCookie = document.cookie.split("; ");
        for (var i=0; i < strCookie.length; i++) {
            var strCrumb = strCookie[i].split("=");
            if (strName == strCrumb[0]) {
                return strCrumb[1] ? unescape(strCrumb[1]) : null;
            }
        }
        return null;
    },
    reFresh:function(){
        window.location = window.location.href;
    },
    stopPropagation : function(event){
        var e = event || window.event;
        if(e.stopPropagation){
            e.stopPropagation();
        }else {
            e.cancelBubble = true;
        }
    },
    checkLogin : function(success, fail){
        $.ajax({
            url:'/?m=account&c=chklogin',
            async:false,
            dataType:"json",
            success: function(json){
                if(json.errcode == 0) {
                    if (success) success(json);
                }else {
                    if (fail) fail(json);
                }
            }
        });
    }
}

var DSXUI = {
    message : function(settings){
        var opt = $.extend({
            type:'success',
            text:'操作完成'
        },settings);

        if(opt.type != 'success' && opt.type != 'error' && opt.type != 'warning') opt.type = 'infomation';
        var icon;
        switch(opt.type) {
            case 'success':
                icon = '&#xe656;';
                break;
            case 'error':
                icon = '&#xe658;';
                break;
            case 'warning':
                icon = '&#xe662;';
                break;
            default : icon = '&#xe6e4;';
        }
        $("#ui-message-box").remove();
        var div = $('<div/>').addClass('ui-message-box').attr('id','ui-message-box');
        var con = $('<div/>').addClass('message-div message-'+opt.type).html('<div class="iconfont message-icon">'+icon+'</div><div class="message-text">'+opt.text+'</div>');
        div.html(con).appendTo(document.body).fadeIn('fast').center();
        if(opt.afterShow) opt.afterShow(div);
        setTimeout(function(){div.remove(); if(opt.afterClose) opt.afterClose(div);},2000);
    },
    success : function(text, callback){
        DSXUI.message({type:'success',text:text,afterClose:callback});
    },
    error : function(text,callback){
        DSXUI.message({type:'error',text:text,afterClose:callback});
    },
    warning : function(text,callback){
        DSXUI.message({type:'warning',text:text,afterClose:callback});
    },
    infomation : function(text,callback){
        DSXUI.message({type:'infomation',text:text,afterClose:callback});
    },
    confirm : function(selector,text,ok,cancel){
        $(selector).confirm({text:text,onConfirm:ok,onCancel:cancel});
    },
    showAjaxLoading : function(text){
        text = text||'数据加载中...';
        var overlayer = $("<div/>").addClass("ui-overlayer").appendTo(document.body);
        var loading = $('<div class="ui-loading-box" id="ui-loading-box"><span class="ico"></span>'+text+'</div>')
            .appendTo(document.body).center();
        this.close = function(){
            overlayer.remove();
            loading.remove();
        }
        return this;
    },
    showloading : function(text){
        return DSXUI.showAjaxLoading(text);
    },
    showSpinner : function(){
        var overlayer = $("<div/>").addClass("ui-overlayer").appendTo(document.body);
        var spinner = $('<div class="ui-spinner" id="ui-spinner"></div>').appendTo(document.body).center();
        this.close = function(){
            overlayer.remove();
            spinner.remove();
        }
        return this;
    },
    dialog:function(settings){
        return new DSXDialog(settings);
    },
    confirmDialog : function(settings){
        settings = $.extend({
            text:'确定要删除此项目吗？',
            width:400,
            hideTitle:true
        },settings);
        DSXUI.dialog({
            html:'<div class="ui-confirm-content">'+settings.text+'</div>',
            title:settings.title,
            width:settings.width,
            onConfirm:function(dlg){
                dlg.close();
                if(settings.onConfirm) settings.onConfirm(dlg);
            },
            onCancel:function(dlg){
                if(settings.onCancel) settings.onCancel(dlg);
            }
        });
    },
    showConfirm:function (text, callback, cancel) {
        if (!text) text = '确认要删除此项目吗?';
        DSXUI.dialog({
            width:350,
            html:'<div class="ui-confirm-content">'+text+'</div>',
            hideTitle:true,
            onConfirm:function(dlg){
                dlg.close();
                if(callback) callback(dlg);
            },
            onCancel:function(dlg){
                if (cancel) cancel(dlg);
            }
        });
    },
    //创建相册
    showCreateAlbum : function(post_data,callback){
        return createAlbumDialog(post_data,callback);
    },

    //图片选择器
    showImagePickerView : function(settings){
        return imagePickerView(settings);
    },
    showFilePickerView : function(settings){
        return filePickerView(settings);
    },
    showAjaxLogin : function (callback) {
        DSXUI.dialog({
            width:350,
            height:365,
            hideBottom:true,
            iframe:'/?m=account&c=login&a=ajaxlogin',
            afterShow:function (dlg) {
                window.afterLogin = function (data) {
                    dlg.close();
                    if (callback) callback(data);
                }
            }
        });
    }
}

;$(function () {
    $(".checkall").on('click',function(e) {
        var target = $(this).attr('toggle-target');
        if(typeof(target) === 'undefined'){
            target = 'input.checkmark';
        }
        $(target).prop('checked', $(this).is(":checked"));
    });
    /*
    $(".lazyload").lazyload({
        effect:'fadeIn',
        placeholder:'/static/images/common/placeholder.png'
    });
    */
    $(".lazyload").each(function () {
        var self = this;
        var imgurl = $(this).attr('data-original');
        if (this.tagName.toLowerCase() == 'img'){
            $(this).attr("src", "/static/images/common/placeholder.png");
            $("<img/>").attr("src", imgurl).load(function () {
                $(self).attr('src', imgurl);
            });
        }else {
            $("<img/>").attr("src", imgurl).load(function () {
                $(self).css('background-image','url('+imgurl+')');
            });
        }
    });
    $(".sortable").sortable();
});