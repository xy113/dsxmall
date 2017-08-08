<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="console-title">
	<h2>菜单管理</h2>
</div>
<div class="content-div">
	<form method="post" id="menuForm" autocomplete="off">
    <input type="hidden" name="formsubmit" value="yes">
    <input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>">
    <table cellpadding="0" cellspacing="0" width="100%" class="listtable">
    	<thead>
        	<tr>
            	<th width="40">删?</th>
            	<th width="220">名称</th>
                <th>选项</th>
            </tr>
        </thead>
     </table>
     <div class="menu-list" data-id="0">
     <?php if(is_array($menulist)) { foreach($menulist as $menu) { ?>     <?php $id=$menu[id]; ?>     <table cellpadding="0" cellspacing="0" width="100%" class="listtable">
        <tbody>
            <tr>
                <td width="20"><input type="checkbox" class="checkbox checkmark" name="delete[]" value="<?php echo $id;?>"></td>
                <td width="220"><input type="text" name="menulist[<?php echo $id;?>][name]" class="input-text" value="<?php echo $menu[name];?>"></td>
                <td><a href="<?php echo U("menuid=$id"); ?>">查看菜单项</a></td>
            </tr>
        </tbody>
    </table>
     <?php } } ?>    </div>
    <div class="menu-div" id="menu-new"></div>
    <table cellpadding="0" cellspacing="0" width="100%" class="listtable">
    	<tfoot>
        	<tr>
            	<td>
                	<label><input type="checkbox" class="checkbox checkall"> 全选</label>
                    <label><a href="javascript:;" id="addnew"><i class="icon">&#xf0154;</i>添加菜单</a></label>
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
			<td width="20"></td>
			<td width="220"><input type="text" name="menulist[#k#][name]" class="input-text" value=""></td>
			<td></td>
		</tr>
	</tbody>
</table>
</script>
<script type="text/javascript">
var k=0;
$("#addnew").click(function(e) {
    k--;
	var html = $("#J-menu-item-tpl").html().replace(/#k#/g,k);
	$("#menu-new").append(html);
});
$(".menu-list,.menu-div").sortable({
	item:'.nav-item',
	connectWith:'.navigation-top,.sub-top',
	update:function(event,ui){
		var fid = $(ui.item).parent().attr('data-id');
		$(ui.item).children(".fid").val(fid);
	}
});
</script><?php include template('footer'); ?>