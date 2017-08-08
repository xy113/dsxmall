<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="top">
    <div class="area">
        <h3 class="h3">申请遇到问题，拨打客服电话:0858-8772117</h3>
        <h1 class="h1">申请开店 > 填写店铺信息</h1>
    </div>
</div>

<div class="area store-form-div">
    <div class="form-content">
        <form method="post" id="storeForm">
            <div class="form-group">
                <div class="lable-name">门店名称:</div>
                <div class="label-input">
                    <input type="text" class="input-text" name="store[name]" id="store_name" maxlength="40" placeholder="请输入门店名称">
                    <div class="err-tips" id="err_name"></div>
                </div>
            </div>

            <div class="form-group">
                <div class="lable-name">联系电话:</div>
                <div class="label-input">
                    <input type="text" class="input-text" name="store[tel]" id="store_tel" maxlength="40" placeholder="请输入联系电话">
                    <div class="err-tips" id="err_tel"></div>
                </div>
            </div>

            <div class="form-group">
                <div class="lable-name">所在城市:</div>
                <div class="label-input">
                    <select class="input-select select" id="province" name="shop[province]">
                        <option value="">请选择</option>
                    </select>
                    <select class="input-select select" id="city" name="shop[city]">
                        <option value="">请选择</option>
                    </select>
                    <select class="input-select select" id="county" name="shop[county]">
                        <option value="">请选择</option>
                    </select>
                    <div class="err-tips" id="err_location"></div>
                </div>
            </div>

            <div class="form-group">
                <div class="lable-name">详细地址:</div>
                <div class="label-input">
                    <input type="text" class="input-text" name="store[street]" id="street" placeholder="请输入街道地址，如：金水港湾">
                    <span class="ui-button button-location" id="button-location">去定位</span>
                    <p>可以拖动蓝色图标到你的店铺所在位置</p>
                    <div class="err-tips" id="err_street"></div>
                </div>
            </div>

            <div class="form-group">
                <div class="lable-name"></div>
                <div class="label-input">
                    <input type="hidden" name="store[longitude]" id="longitude" value="0">
                    <input type="hidden" name="store[latitude]" id="latitude" value="0">
                    <div class="map-hd"><div class="map" id="map"></div></div>
                </div>
            </div>

            <div class="form-group">
                <div class="lable-name">门店LOGO:</div>
                <div class="label-input">
                    <div class="pic-item">
                        <div class="pic-demo">
                            <img src="/static/images/common/ex-logo.png">
                            <span class="t">示例</span>
                        </div>
                        <div class="pic-uploader">
                            <div class="icon">&#xf0020;</div>
                            <div class="t">点击上传</div>
                            <div class="pic" id="pic_preview_1">
                                <div class="b"></div>
                                <div class="t">重新上传</div>
                            </div>
                            <input type="file" class="file" accept="image/*" id="file_1" name="filedata">
                            <input type="hidden" name="store[logo]" id="pic_logo" value="">
                        </div>
                        <div class="pic-tips">上传与店铺气质吻合的Logo，能提高用户进店的概率<br>支持JPG/JPEG/PNG格式图片，文件大小不超过500K</div>
                    </div>
                    <div class="err-tips" id="err_logo"></div>
                </div>
            </div>

            <div class="form-group">
                <div class="lable-name">营业执照:</div>
                <div class="label-input">
                    <div class="pic-item">
                        <div class="pic-demo">
                            <img src="/static/images/common/ex-front.png">
                            <span class="t">示例</span>
                        </div>
                        <div class="pic-uploader">
                            <div class="icon">&#xf0020;</div>
                            <div class="t">点击上传</div>
                            <div class="pic" id="pic_preview_2">
                                <div class="b"></div>
                                <div class="t">重新上传</div>
                            </div>
                            <input type="file" class="file" accept="image/*" id="file_2" name="filedata">
                            <input type="hidden" name="store[pic_front]" id="pic_front" value="">
                        </div>
                        <div class="pic-tips">一张真实美观的门脸照可以提升店铺形象<br>支持JPG/JPEG/PNG格式图片，文件大小不超过5MB</div>
                    </div>
                    <div class="err-tips" id="err_pic_front"></div>
                </div>
            </div>

            <div class="form-group">
                <div class="lable-name">其他证件:</div>
                <div class="label-input">
                    <div class="pic-item">
                        <div class="pic-demo">
                            <img src="/static/images/common/ex-shop.png">
                            <span class="t">示例</span>
                        </div>
                        <div class="pic-uploader">
                            <div class="icon">&#xf0020;</div>
                            <div class="t">点击上传</div>
                            <div class="pic" id="pic_preview_3">
                                <div class="b"></div>
                                <div class="t">重新上传</div>
                            </div>
                            <input type="file" class="file" accept="image/*" id="file_3" name="filedata">
                            <input type="hidden" name="store[pic_inside]" id="pic_inside" value="">
                        </div>
                        <div class="pic-tips">简洁干净的店内照可以让用户放心点单<br>支持JPG/JPEG/PNG格式图片，文件大小不超过5MB</div>
                    </div>
                    <div class="err-tips" id="err_pic_inside"></div>
                </div>
            </div>

            <div class="button-div">
                <input type="submit" class="ui-button button" value="提交创建店铺">
            </div>
        </form>
    </div>
</div>
<script src="http://webapi.amap.com/maps?v=1.3&key=<?php echo $_G[setting][amap_key];?>" type="text/javascript"></script>
<script src="/static/js/dsxmap.js" type="text/javascript"></script>
<script type="text/javascript">
$(function () {
    var mapObj = new DSXMap('map', {zoom:13});
    var marker = mapObj.createMarker({draggable:true});
    mapObj.addMarker(marker);
    mapObj.setCurrentLocation(function (data) {
        mapObj.map.setCenter(data.position);
        marker.setPosition(data.position);
        setLocation(data.position);
        AMap.event.addListener(marker,'dragend',function (e) {
            var position = e.target.getPosition();
            setLocation(position);
        });
        AMap.event.addListener(marker,'mousemove',function (e) {
            var position = e.target.getPosition();
            setLocation(position);
        });
    }, function (err) {
        alert(JSON.stringify(err));
    });
    function setLocation(position) {
        $("#longitude").val(position.getLng());
        $("#latitude").val(position.getLat());
    }

    var district = new DistrictSelector({
        province:'贵州省',
        city:'六盘水市',
        county:'水城县'
    });
    $("#button-location").on('click', function (e) {
        var provice = $("#province").val();
        if (!provice) {
            DSXUI.error('请选择省份');
            return false;
        }
        var city = $("#city").val();
        if (!city) {
            DSXUI.error('请选择城市');
            return false;
        }
        var county = $("#county").val();
        if (!county) {
            DSXUI.error('请选择区县');
            return false;
        }
        var street = $.trim($("#street").val());
        if (!street) {
            DSXUI.error('请填写街道地址');
            return false;
        }
        var  address = provice+city+county+street;
        mapObj.geocoder(address, function (data) {
            //alert(JSON.stringify(data));
            var position = data[0].location
            mapObj.map.setCenter(position);
            marker.setPosition(position);
            setLocation(position);
        }, function (status, result) {
            //alert(JSON.stringify(result));
        });
    });
});
</script><?php include template('footer_common'); ?>