<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="console-title">
	<h2>合并文章分类</h2>
</div>
<div class="area">
	<form method="post">
    	<input type="hidden" name="formsubmit" value="yes">
        <input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
    	<table cellpadding="0" cellspacing="0" width="100%" class="formtable">
        	<tbody>
            	<tr>
                	<th width="300">源分类</th>
                    <td width="50"></td>
                    <th>目标分类</th>
                </tr>
            	<tr>
                    <td>
                    	<select name="source[]" size="10" class="select" multiple="multiple" style="width:300px; height:300px;">
                        <?php echo $categoryoptions;?>
                        </select>
                    </td>
                	<td class="center">>></td>
                    <td>
                    	<select name="target" size="10" class="select" style="width:300px; height:300px;">
                        <?php echo $categoryoptions;?>
                        </select>
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