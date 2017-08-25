/**
 * Created by songdewei on 2017/6/27.
 */
var touch = window.ontouchstart ? 'touchstart' : 'click';
function onBridgeReady(callback) {
    var ua = navigator.userAgent.toLowerCase();
    if (/android/.test(ua)){
        if (window.WebViewJavascriptBridge) {
            callback(WebViewJavascriptBridge)
        } else {
            if (window.WebViewJavascriptBridge) {
                callback(WebViewJavascriptBridge);
            } else {
                document.addEventListener("WebViewJavascriptBridgeReady", function (event) {
                    callback(WebViewJavascriptBridge);
                }, false);
            }
        }
    }else {
        if (window.WebViewJavascriptBridge) {
            return callback(WebViewJavascriptBridge);
        }
        if (window.WVJBCallbacks) {
            return window.WVJBCallbacks.push(callback);
        }
        window.WVJBCallbacks = [callback];
        var WVJBIframe = document.createElement('iframe');
        WVJBIframe.style.display = 'none';
        WVJBIframe.src = 'https://__bridge_loaded__';
        document.documentElement.appendChild(WVJBIframe);
        setTimeout(function() {
            document.documentElement.removeChild(WVJBIframe)
        }, 0);
    }
}

$(function () {
    onBridgeReady(function (bridge) {
        //打开一个指定连接
        $("[handler=openURL]").on('click', function (e) {
            var url = $(this).attr('data-url');
            bridge.callHandler('openURL', url);
        });
        //商品详情
        $("[handler=viewItem]").on('click', function (e) {
            var id = $(this).attr('data-id');
            bridge.callHandler('viewItem', id);
        });
        //店铺详情
        $("[handler=viewShop]").on('click', function (e) {
            var shop_id = $(this).attr('data-id');
            bridge.callHandler('viewShop', shop_id);
        });
        //文章详情
        $("[handler=viewArticle]").on('click', function (e) {
            var id = $(this).attr('data-id');
            bridge.callHandler('viewArticle', id);
        });
    });
});
