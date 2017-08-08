<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="console-title">
	<a href="/?m=<?php echo $_G[m];?>&c=<?php echo $_G[c];?>&a=index" class="button float-right">返回菜单列表</a>
	<h2>菜单管理-><?php echo $menu[name];?></h2>
</div>
<div class="table-wrap">
	<form method="post" id="menuForm">
    <input type="hidden" name="formsubmit" value="yes">
    <input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>">
    <table cellpadding="0" cellspacing="0" width="100%" class="listtable">
    	<thead>
        	<tr>
            	<th>删?</th>
                <th width="50">图标</th>
            	<th width="100">名称</th>
                <th>链接</th>
                <th width="80">打开方式</th>
                <th width="40">可用</th>
            </tr>
        </thead>
     </table>
     <div class="menu-list" data-id="0">
     <?php $this->printItems($itemlist, 0);; ?>     </div>
     <div class="menu-list" id="nemu-new"></div>
    <table cellpadding="0" cellspacing="0" width="100%" class="listtable">
    	<tfoot>
        	<tr>
            	<td>
                	<label><input type="checkbox" class="checkbox checkall"> 全选</label>
                    <a href="javascript:;" id="addnew"><i class="icon">&#xf0154;</i>添加菜单项</a></td>
                </td>
            </tr>
            <tr>
            	<td>
                	<input type="submit" class="button" value="提交">
                    <input type="button" class="button button-cancel" value="刷新" onclick="window.location.reload()">
                </td>
            </tr>
        </tfoot>
    </table>
    </form>
</div>
<script type="text/x-template" id="J-menu-item-tpl">
<table cellpadding="0" cellspacing="0" width="100%" class="listtable">
	<tbody>
		<tr>
			<td width="20"><input type="hidden" name="itemlist[#k#][fid]" class="fid" value="0"></td>
			<td width="50"></td>
			<td width="100"><input type="text" name="itemlist[#k#][name]" class="input-text w100" value=""></td>
			<td><input type="text" name="itemlist[#k#][url]" class="input-text w300" value=""></td>
			<td width="80">
				<select name="itemlist[#k#][target]">
					<option value="_self">本窗口</option>
					<option value="_blank">新窗口</option>
					<option value="_top">顶层框架</option>
				</select>
			</td>
			<td width="40"><input type="checkbox" name="itemlist[#k#][available]" value="1" checked></td>
		</tr>
	</tbody>
</table>
</script>
<script type="text/javascript">
var k=0;
$("#addnew").click(function(e) {
    k--;
	var html = $("#J-menu-item-tpl").html().replace(/#k#/g,k);
	$("#nemu-new").append(html);
});
$(".menu-list,.sub-menu").sortable({
	item:'.menu-item',
	connectWith:'.menu-list,.sub-menu',
	update:function(event,ui){
		var fid = $(ui.item).parent().attr('data-id');
		$(ui.item).find(".fid").val(fid);
	}
});
</script><?php include template('footer'); ?>