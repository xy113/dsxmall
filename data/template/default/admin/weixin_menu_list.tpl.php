<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="console-title">
	<div class="float-right">
    	<input type="button" class="button" value="应用菜单" onclick="apply()" />
        <input type="button" class="button" value="删除菜单" onclick="remove()" />
    </div>
	<h2>微信自定义菜单设置</h2>
</div>
<div class="table-wrap">
<form method="post" action="">
<input type="hidden" name="formsubmit" value="yes" />
<input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
    <thead>
       <th width="30" class="center">删?</th>
       <th width="30">ID</th>
       <th width="300">菜单名称</th>
       <th width="200">菜单类型</th>
       <th>选项</th>
    </thead>
</table>
<div id="menu-item-list">
    <?php if(is_array($menulist[0])) { foreach($menulist[0] as $id=>$menu) { ?>    <div class="menu-item">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
            <tbody>
                <td width="30"><input type="checkbox" class="checkbox checkmark" name="delete[]" value="<?php echo $id;?>"></td>
                <td width="30"><?php echo $id;?></td>
                <td width="300">
                    <input type="text" class="input-text w200" name="menulist[<?php echo $id;?>][name]" value="<?php echo $menu[name];?>" maxlength="10" style="font-weight:bold;">
                    <a onclick="addMenu(<?php echo $id;?>)">+添加子分类</a>
                </td>
                <td width="200"><?php echo $lang[weixin_menu_types][$menu[type]];?></td>
                <td><a onclick="editMenu(<?php echo $id;?>)">编辑</a></td>
            </tbody>
        </table>
        <div class="menu-sub-list">
            <?php if(is_array($menulist[$id])) { foreach($menulist[$id] as $id2=>$menu2) { ?>            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable sub-item">
              <tbody>
                  <td width="30"><input type="checkbox" class="checkbox checkmark" name="delete[]" value="<?php echo $id2;?>" /></td>
                  <td width="30"><?php echo $id2;?></td>
                  <td width="300">
                      <div class="cat-level cat-level-2"></div>
                      <input type="text" class="input-text w200" name="menulist[<?php echo $id2;?>][name]" value="<?php echo $menu2[name];?>" maxlength="10">
                  </td>
                  <td width="200"><?php echo $lang[weixin_menu_types][$menu2[type]];?></td>
                  <td><a onclick="editMenu(<?php echo $id2;?>)">编辑</a></td>
              </tbody>
            </table>
            <?php } } ?>        </div>
    </div>
    <?php } } ?>    
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
<tfoot>
<tr>
    <td>
        <label><input type="checkbox" class="checkbox checkall" /> 全选</label>
        <a onclick="addMenu(0)" style="margin-left:20px;"><i class="icon">&#xf0154;</i>添加菜单</a>
        <p class="tips">提示:提交后选中项将被删除，微信菜单一级菜单最多3个，二级菜单最多5个，一级菜单最多4个字，二级菜单最多7各字</p>
    </td>
</tr>
<tr>
    <td>
        <input type="submit" class="button" value="提交" />
        <input type="button" class="button button-cancel" value="刷新" onclick="window.location.reload()" />
    </td>
</tr>
</tfoot>
</table>
</form>
</div>
<script type="text/javascript">
$("#menu-item-list").sortable({item:'.menu-item'});
$(".menu-sub-list").sortable({item:'.sub-item'});
function addMenu(fid){
	DSXUI.dialog({
		width:600,
		title:'添加菜单',
		url:'/?m=<?php echo $G[m];?>&c=<?php echo $G[c];?>&a=add&fid='+fid,
		onConfirm:function(dlg){
			var form = dlg.content.find("ajaxMenuForm");
			var name = $("#menu_name").val();
			if(name.length > 0) {
				$("#ajaxMenuForm").ajaxSubmit({
					dataType:'json',
					data:{fid:fid},
					success:function(json){
						if(json.errcode == 0){
							dlg.close();
							DSXUtil.reFresh();
						}else {
							DSXUI.error('菜单添加失败');
						}
					}
				});
			}else {
				DSXUI.error('请填写菜单名称');
			}
		}
	});
}
function editMenu(id){
	DSXUI.dialog({
		width:600,
		title:'编辑菜单',
		url:'/?m=<?php echo $G[m];?>&c=<?php echo $G[c];?>&a=edit&id='+id,
		onConfirm:function(dlg){
			var form = dlg.content.find("ajaxMenuForm");
			var name = $("#menu_name").val();
			if(name.length > 0) {
				$("#ajaxMenuForm").ajaxSubmit({
					dataType:'json',
					data:{id:id},
					success:function(json){
						if(json.errcode == 0){
							dlg.close();
							DSXUI.success('菜单修改成功', DSXUtil.reFresh);
						}else {
							DSXUI.error('菜单修改失败');
						}
					}
				});
			}else {
				DSXUI.error('请填写菜单名称');
			}
		}
	});
}

function apply(){
	DSXUI.confirmDialog({
		title:'应用确认',
		text:'应用成功后，微信公众号现有的自定义菜单将会被替换',
		onConfirm:function(dlg){
			$.ajax({
				url:'/?m=<?php echo $G[m];?>&c=<?php echo $G[c];?>&a=apply',
				dataType:"json",
				success: function(json){
					dlg.close();
					if(json.errcode == 0){
						DSXUI.success('菜单应用成功');
					}else {
						DSXUI.error('菜单应用失败');
					}
				}
			});
		}
	});
}

function remove(){
	DSXUI.confirmDialog({
		title:'删除确认',
		text:'此操作将删除公众号所有自定义菜单，你确定要删除吗?',
		onConfirm:function(dlg){
			$.getJSON('/?m=<?php echo $G[m];?>&c=<?php echo $G[c];?>&a=remove', function(json){
				if (json.errcode == 0){
					DSXUI.success('菜单删除成功');
				}else {
					DSXUI.error('菜单删除失败');
				}
			});
		}
	});
}
</script><?php include template('footer'); ?>