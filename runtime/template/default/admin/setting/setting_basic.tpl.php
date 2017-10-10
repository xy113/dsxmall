<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="console-title">
    <h2>系统设置->基本设置</h2>
</div>
<div class="content-div">
    <form method="post" id="settingForm" action="<?php echo U('c=setting&a=save'); ?>">
        <input type="hidden" name="formsubmit" value="yes">
        <input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>">
        <table class="formtable" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody id="basic">
            <tr>
                <td class="cell-name" width="90">网站名称:</td>
                <td width="320"><input name="settingnew[sitename]" class="input-text w300" value="<?php echo $setting[sitename];?>" type="text"></td>
                <td>系统名称，将显示在导航条和标题中</td>
            </tr>
            <tr>
                <td class="cell-name">网站地址:</td>
                <td><input name="settingnew[siteurl]" class="input-text w300" value="<?php echo $setting[siteurl];?>" type="text"></td>
                <td>网站 URL，将作为链接显示在页面底部</td>
            </tr>
            <tr>
                <td class="cell-name">关键字:</td>
                <td><input name="settingnew[keywords]" class="input-text w300" value="<?php echo $setting[keywords];?>"></td>
                <td>Keywords 项出现在页面头部的 Meta 标签中，用于记录本页面的关键字，多个关键字间请用半角逗号 "," 隔开</td>
            </tr>
            <tr>
                <td class="cell-name">网站描述:</td>
                <td><textarea name="settingnew[description]" class="textarea w300" style="height: 100px;"><?php echo $setting[description];?></textarea></td>
                <td>Description 出现在页面头部的 Meta 标签中，用于记录本页面的概要与描述</td>
            </tr>
            <tr>
                <td class="cell-name">备案信息:</td>
                <td><input name="settingnew[icp]" class="input-text w300" value="<?php echo $setting[icp];?>" type="text"></td>
                <td>页面底部可以显示 ICP 备案信息，如果网站已备案，在此输入您的授权码，它将显示在页面底部，如果没有请留空</td>
            </tr>
            <tr>
                <td class="cell-name">版权信息:</td>
                <td><input name="settingnew[copyright]" class="input-text w300" value="<?php echo $setting[copyright];?>"></td>
                <td>网站的版权信息，将显示在页面底部</td>
            </tr>
            <tr>
                <td class="cell-name">统计代码:</td>
                <td><textarea name="settingnew[statcode]" class="textarea w300" style="height: 100px;"><?php echo $setting[statcode];?></textarea></td>
                <td>用于统计网站访问情况的第三方统计代码，通常为JS代码</td>
            </tr>
            <tr>
                <td class="cell-name">关闭网站:</td>
                <td>
                    <label><input name="settingnew[sysclosed]" class="radio" value="1" type="radio"<?php if($setting[sysclosed]) { ?> checked="checked"<?php } ?>> 是</label>
                    <label><input name="settingnew[sysclosed]" class="radio" value="0" type="radio"<?php if(!$setting[sysclosed]) { ?> checked="checked"<?php } ?>> 否</label>
                </td>
                <td>暂时将网站关闭，其他人无法访问，但不影响管理员访问</td>
            </tr>
            <tr>
                <td class="cell-name">关闭原因:</td>
                <td><textarea name="settingnew[sysclosedreason]" class="textarea w300"><?php echo $setting[sysclosedreason];?></textarea></td>
                <td>网站关闭时出现的提示信息</td>
            </tr>
            <tr>
                <td class="cell-name">地图接口Key:</td>
                <td><input name="settingnew[amap_key]" class="input-text w300" value="<?php echo $setting[amap_key];?>"></td>
                <td>高德地图访问接口Key</td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td></td>
                <td colspan="2"><input name="button-submit" class="button submit" value="更新配置" type="submit"></td>
            </tr>
            </tfoot>
        </table>
    </form>
</div><?php include template('footer'); ?>