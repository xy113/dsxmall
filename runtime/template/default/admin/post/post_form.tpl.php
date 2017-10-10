<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="console-title">
    <div class="float-right">
        <a href="<?php echo U('c=postcatlog'); ?>" class="button">分类管理</a>
        <a href="<?php echo U('c=post&a=itemlist'); ?>" class="button">返回列表</a>
    </div>
    <h2>发布文章</h2>
</div>
<div class="content-div">
    <form method="post" id="postForm" action="<?php echo U('c=post&a=save'); ?>" autocomplete="off">
        <input type="hidden" name="formsubmit" value="yes" />
        <input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>">
        <input type="hidden" name="eventType" value="<?php echo $_G[a];?>">
        <input type="hidden" name="aid" value="<?php echo $aid;?>">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
            <tr>
                <td width="80">文章标题</td>
                <td><input type="text" class="input-text" placeholder="在这里输入标题" name="newpost[title]" value="<?php echo $item[title];?>" id="title" style="width: 760px;"></td>
            </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
            <tr>
                <td width="80">目录分类</td>
                <td width="380">
                    <select name="newpost[catid]" class="select" title="">
                        <?php if(is_array($catloglist[0])) { foreach($catloglist[0] as $catid1=>$cat1) { ?>                        <option value="<?php echo $catid1;?>"<?php if($catid==$catid1) { ?> selected<?php } ?>><?php echo $cat1[name];?></option>
                        <?php if(is_array($catloglist[$catid1])) { foreach($catloglist[$catid1] as $catid2=>$cat2) { ?>                        <option value="<?php echo $catid2;?>"<?php if($catid==$catid2) { ?> selected<?php } ?>>|--<?php echo $cat2[name];?></option>
                        <?php if(is_array($catloglist[$catid2])) { foreach($catloglist[$catid2] as $catid3=>$cat3) { ?>                        <option value="<?php echo $catid3;?>"<?php if($catid==$catid3) { ?> selected<?php } ?>>|--|--<?php echo $cat3[name];?></option>
                        <?php } } ?>                        <?php } } ?>                        <?php } } ?>                    </select>
                </td>
                <td width="80">文章来源</td>
                <td><input type="text" title="" class="input-text" name="newpost[from]" value="<?php echo $item[from];?>"></td>
                <td rowspan="5" width="160">
                    <input type="hidden" id="post_image" name="newpost[image]" value="<?php echo $item[image];?>">
                    <div class="post-image-box" title="点击更换图片">
                        <div class="bg-cover" id="post_image_preview" style="width: 140px; height: 140px; background-color: #f5f5f5; display: block; background-image: url(<?php echo image($item[image]); ?>)">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>文章别名</td>
                <td><input type="text" title="" class="input-text" name="newpost[alias]" value="<?php echo $item[alias];?>"></td>
                <td>来源地址</td>
                <td><input type="text" title="" class="input-text" name="newpost[fromurl]" value="<?php echo $item[fromurl];?>"></td>
            </tr>
            <tr>
                <td>评论设置</td>
                <td><label><input type="checkbox" class="checkbox" name="newpost[allowcomment]" value="1"<?php if($item[allowcomment]) { ?> checked<?php } ?>> 允许评论</label></td>
                <td>文章标签</td>
                <td><input type="text" title="" class="input-text" name="newpost[tags]" value="<?php echo $item[tags];?>"></td>
            </tr>
            <tr>
                <td>文章作者</td>
                <td><input type="text" title="" class="input-text" name="newpost[author]" value="<?php echo $item[author];?>"></td>
                <td>文章形式</td>
                <td>
                    <label><input type="radio" class="radio" name="newpost[type]" onclick="switchContent('article')" value="article"<?php if($type=='article') { ?> checked<?php } ?>> 文章</label>
                    <label><input type="radio" class="radio" name="newpost[type]" onclick="switchContent('image')" value="image"<?php if($type=='image') { ?> checked<?php } ?>> 相册</label>
                    <label><input type="radio" class="radio" name="newpost[type]" onclick="switchContent('video')" value="video"<?php if($type=='video') { ?> checked<?php } ?>> 视频</label>
                </td>
            </tr>
            <tr>
                <td>阅读价格</td>
                <td><input type="text" title="" class="input-text" name="newpost[price]" value="<?php echo $item[price];?>"></td>
                <td>发布时间</td>
                <td><input type="text" title="" class="input-text" name="newpost[pubtime]" value="<?php echo $item[pubtime];?>"></td>
            </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
            <tr>
                <td width="80">内容摘要</td>
                <td><textarea title="" style="width:100%;" name="newpost[summary]"><?php echo $item[summary];?></textarea></td>
            </tr>
        </table>
        <!--文章内容部分-->
        <div class="swithContent" id="content-article" style="display: none;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
                <tr>
                    <td width="80">文章内容</td>
                    <td><div style="box-sizing:border-box"><?php include template('editor'); ?></div></td>
                </tr>
            </table>
        </div>
        <!--文章内容部分-->
        <div class="swithContent" id="content-image" style="display: none;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
                <tr>
                    <td width="80">图片列表</td>
                    <td>
                        <div id="post-gallery" class="post-gallery">
                            <?php if(is_array($gallery)) { foreach($gallery as $img) { ?>                            <div class="row">
                                <input type="hidden" name="gallery[<?php echo $img[id];?>][thumb]" value="<?php echo $img[thumb];?>">
                                <input type="hidden" name="gallery[<?php echo $img[id];?>][image]" value="<?php echo $img[image];?>">
                                <div class="img bg-cover" style="background-image: url(<?php echo image($img[thumb]); ?>)"></div>
                                <div class="con"><textarea name="gallery[<?php echo $img[id];?>][description]" class="textarea" title=""><?php echo $img[description];?></textarea></div>
                                <a class="delete" onclick="removeItem(this)">&times;</a>
                            </div>
                            <?php } } ?>                        </div>
                        <p><a id="addNewImg"><i class="iconfont icon-roundadd"></i><span>添加图片</span></a></p>
                    </td>
                </tr>
            </table>
        </div>
        <div class="swithContent" id="content-video" style="display: none;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
                <tr>
                    <td width="80">视频地址</td>
                    <td>
                        <input type="hidden" name="source_url">
                        <input title="" type="text" class="input-text input-title" name="original_url" value="<?php echo $media[original_url];?>" style="width:100%;">
                        <p>请输入QQ视频，优酷网、酷6网、56网的视频播放页链接</p>
                    </td>
                </tr>
            </table>
        </div>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
            <tr>
                <td width="80"></td>
                <td><input type="submit" class="button button-long" value="发布"></td>
            </tr>
        </table>
    </form>
</div>

<script type="text/javascript">$("#content-<?php echo $type;?>").show();</script>
<script type="text/javascript">
    function switchContent(type){
        $(".swithContent").hide();
        $("#content-"+type).show();
    }

    function removeItem(o){
        DSXUI.showConfirm('删除图片', '确认要删除此图片吗?', function () {
            $(o).parent().remove();
        });
    }

    $("#post_image_preview").click(function(e) {
        DSXUI.showImagePicker(function (data) {
            $("#post_image_preview").css('background-image', 'url('+data.imageurl+')');
            $("#post_image").val(data.image);
        });
    });

    ;$(function(){
        $("#postForm").on('submit',function(e) {
            var title = $.trim($("#title").val());
            if(!title){
                DSXUI.error("<?php echo $_lang[empty_post_title];?>");
                return false;
            }
        });
        var k = 0;
        $("#addNewImg").on('click', function () {
            DSXUI.showImagePicker(function (data) {
                $("#post-gallery").append('<div class="row">' +
                    '<input type="hidden" name="gallery['+k+'][thumb]" value="'+data.thumb+'">' +
                    '<input type="hidden" name="gallery['+k+'][image]" value="'+data.image+'">' +
                    '<div class="img bg-cover" style="background-image: url('+data.thumburl+')"></div>' +
                    '<div class="con"><textarea class="textarea" name="gallery['+k+'][description]" placeholder="图片说明文字"></textarea></div>' +
                    '<a class="delete" onclick="removeItem(this)">&times;</a></div>');
            });
            k--;
        });
        $("#post-gallery").sortable();
    });
</script><?php include template('footer'); ?>