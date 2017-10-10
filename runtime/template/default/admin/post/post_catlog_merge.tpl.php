<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="console-title">
    <a href="<?php echo U('c=postcatlog&a=index'); ?>" class="button float-right">返回列表</a>
	<h2>文章管理 > 合并分类</h2>
</div>
<div class="content-div">
	<form method="post">
    	<input type="hidden" name="formsubmit" value="yes">
        <input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>">
    	<table cellpadding="0" cellspacing="0" width="100%" class="formtable">
        	<tbody>
            	<tr>
                	<th width="300">源分类</th>
                    <td width="50"></td>
                    <th>目标分类</th>
                </tr>
            	<tr>
                    <td>
                    	<select name="source[]" size="10" class="select" multiple="multiple" title="" style="height:300px;">
                            <?php if(is_array($catloglist[0])) { foreach($catloglist[0] as $catid1=>$cat1) { ?>                            <option value="<?php echo $catid1;?>"><?php echo $cat1[name];?></option>
                            <?php if(is_array($catloglist[$catid1])) { foreach($catloglist[$catid1] as $catid2=>$cat2) { ?>                            <option value="<?php echo $catid2;?>">|--<?php echo $cat2[name];?></option>
                            <?php if(is_array($catloglist[$catid2])) { foreach($catloglist[$catid2] as $catid3=>$cat3) { ?>                            <option value="<?php echo $catid3;?>">|--|--<?php echo $cat3[name];?></option>
                            <?php } } ?>                            <?php } } ?>                            <?php } } ?>                        </select>
                    </td>
                	<td class="align-center" style="vertical-align: middle;">>></td>
                    <td>
                    	<select name="target" size="10" class="select" title="" style="width:300px; height:300px;">
                            <?php if(is_array($catloglist[0])) { foreach($catloglist[0] as $catid1=>$cat1) { ?>                            <option value="<?php echo $catid1;?>"><?php echo $cat1[name];?></option>
                            <?php if(is_array($catloglist[$catid1])) { foreach($catloglist[$catid1] as $catid2=>$cat2) { ?>                            <option value="<?php echo $catid2;?>">|--<?php echo $cat2[name];?></option>
                            <?php if(is_array($catloglist[$catid2])) { foreach($catloglist[$catid2] as $catid3=>$cat3) { ?>                            <option value="<?php echo $catid3;?>">|--|--<?php echo $cat3[name];?></option>
                            <?php } } ?>                            <?php } } ?>                            <?php } } ?>                        </select>
                    </td>
                </tr>
            </tbody>
            <tfoot>
            	<tr>
                	<td>
                    	<input type="submit" class="button" value="确认合并">
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
</div><?php include template('footer'); ?>