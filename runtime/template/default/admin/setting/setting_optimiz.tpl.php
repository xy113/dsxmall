<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="console-title">
    <h2>系统设置->优化配置</h2>
</div>
<div class="content-div">
    <form method="post" id="settingForm" action="<?php echo U('c=setting&a=save'); ?>">
        <input type="hidden" name="formsubmit" value="yes">
        <input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>">
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="formtable">
            <tbody>
            <tr>
                <td class="cell-name" width="90">URL静态化:</td>
                <td width="320">
                    <label><input type="radio" value="1" name="settingnew[rewrite]" class="radio"<?php if($setting[rewrite]) { ?> checked<?php } ?>> 是</label>
                    <label><input type="radio" value="0" name="settingnew[rewrite]" class="radio"<?php if(!$setting[rewrite]) { ?> checked<?php } ?>> 否</label>
                </td>
                <td>URL 静态化可以提高搜索引擎抓取，开启本功能需要对 Web 服务器增加相应的 Rewrite 规则，且会轻微增加服务器负担。</td>
            </tr>
            <tr>
                <td class="cell-name">启用Gzip压缩:</td>
                <td>
                    <label><input type="radio" value="1" name="settingnew[gzipcompress]" class="radio"<?php if($setting[gzipcompress]) { ?> checked<?php } ?>> 是</label>
                    <label><input type="radio" value="0" name="settingnew[gzipcompress]" class="radio"<?php if(!$setting[gzipcompress]) { ?> checked<?php } ?>> 否</label>
                </td>
                <td>将页面内容以 gzip 压缩后传输，可以加快传输速度，需 PHP 4.0.4 以上且支持 Zlib 模块才能使用</td>
            </tr>
            <tr>
                <td class="cell-name">标题附加字:</td>
                <td><input type="text" value="<?php echo $setting[seotitle];?>" class="input-text w300" name="settingnew[seotitle]"></td>
                <td>网页标题通常是搜索引擎关注的重点，本附加字设置将出现在标题中论坛名称的后面，如果有多个关键字，建议用 "|"、","(不含引号) 等符号分隔</td>
            </tr>
            <tr>
                <td class="cell-name">其他头部信息:</td>
                <td><textarea class="textarea w300" name="settingnew[seohead]"><?php echo $setting[seohead];?></textarea></td>
                <td>如需在  中添加其他的 HTML 代码，可以使用本设置，否则请留空</td>
            </tr>
            <tr>
                <td class="cell-name">启用缓存:</td>
                <td>
                    <label><input type="radio" value="1" name="settingnew[iscache]" class="radio"<?php if($setting[iscache]) { ?> checked<?php } ?>> 是</label>
                    <label><input type="radio" value="0" name="settingnew[iscache]" class="radio"<?php if(!$setting[iscache]) { ?> checked<?php } ?>> 否</label>
                </td>
                <td>设置是否启用页面缓存，启用缓存可以减轻服务器负担，提高浏览速度</td>
            </tr>
            <tr>
                <td class="cell-name">缓存首页有效期:</td>
                <td><input type="text" value="<?php echo $setting[cacheindex];?>" class="input-text w300" name="settingnew[cacheindex]"></td>
                <td>设置首页缓存更新的时间，单位为秒，0 为关闭（此处关闭以后，缓存系数将不再起作用），建议设置为 900。</td>
            </tr>
            <tr>
                <td class="cell-name">页面缓存时间:</td>
                <td><input type="text" class="input-text w300" value="<?php echo $setting[cachetime];?>" name="settingnew[cachetime]"></td>
                <td>设置页面缓存更新的时间，单位为秒，0 为关闭。请根据实际情况进行调整，建议设置为 900。</td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td></td>
                <td colspan="2"><input type="submit" value="更新配置" class="button submit" name="button-submit"></td>
            </tr>
            </tfoot>
        </table>
    </form>
</div><?php include template('footer'); ?>