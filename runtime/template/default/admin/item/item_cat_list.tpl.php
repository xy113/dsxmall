<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="console-title">
	<h2>商品分类列表</h2>
</div>
<div class="content-div table-wrap">
<form method="post" action="">
<input type="hidden" name="formsubmit" value="yes" />
<input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable table-no-border">
    <thead>
       <th width="40" class="align-center">删?</th>
       <th width="60">ID</th>
       <th width="70">图片</th>
       <th>分类名称</th>
       <th width="130">标识</th>
       <th width="80">显示顺序</th>
       <th width="50" class="align-center">可选</th>
       <th width="50" class="align-center">可用</th>
       <th width="50">选项</th>
    </thead>
</table>
<div id="item-list-div"><?php if(is_array($itemlist[0])) { foreach($itemlist[0] as $id1=>$lv1) { ?>    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable table-no-border">
    	<tbody>
        	<td width="40"><input type="checkbox" class="checkbox checkmark" name="delete[]" value="<?php echo $id1;?>"></td>
            <td width="60"><?php echo $id1;?></td>
            <td width="70"><img src="<?php echo image($lv1[image]); ?>" width="50" height="50" rel="setImage" data-json="{catid:<?php echo $id1;?>}"></td>
            <td>
            	<input type="text" class="input-text w200" name="itemlist[<?php echo $id1;?>][name]" value="<?php echo $lv1[name];?>" maxlength="10" style="font-weight:bold;">
            	<a href="javascript:;" data-level="1" data-id="$id1" onclick="addItem(<?php echo $id1;?>,2)">+添加子分类</a>
            </td>
            <td width="130"><input type="text" class="input-text w120"  name="itemlist[<?php echo $id1;?>][identifer]" value="<?php echo $lv1[identifer];?>"></td>
            <td width="80"><input type="text" class="input-text w60"  name="itemlist[<?php echo $id1;?>][displayorder]" value="<?php echo $lv1[displayorder];?>"></td>
            <td width="50" class="center"><input type="checkbox" class="checkbox" name="itemlist[<?php echo $id1;?>][enable]" value="1"<?php if($lv1[enable]) { ?> checked="checked"<?php } ?>></td>
            <td width="50" class="center"><input type="checkbox" class="checkbox" name="itemlist[<?php echo $id1;?>][available]" value="1"<?php if($lv1[available]) { ?> checked="checked"<?php } ?>></td>
        	<td width="50"><a href="<?php echo U('c=itemcat&a=edit&catid='.$id1); ?>" class="edit">编辑</a></td>
        </tbody>
    </table>
    <div id="item-list-div-<?php echo $id1;?>">
    <?php if(is_array($itemlist[$id1])) { foreach($itemlist[$id1] as $id2=>$lv2) { ?>    	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable table-no-border">
          <tbody>
              <td width="40"><input type="checkbox" class="checkbox checkmark" name="delete[]" value="<?php echo $id2;?>" /></td>
              <td width="60"><?php echo $id2;?></td>
              <td width="70"><img src="<?php echo image($lv2[image]); ?>" width="50" height="50" rel="setImage" data-json="{catid:<?php echo $id2;?>}"></td>
              <td>
              	  <div class="cat-level cat-level-2"></div>
                  <input type="text" class="input-text w200" name="itemlist[<?php echo $id2;?>][name]" value="<?php echo $lv2[name];?>" maxlength="10">
                  <a href="javascript:;" data-level="1" data-id="<?php echo $id1;?>" onclick="addItem(<?php echo $id2;?>,3)">+添加子分类</a>
              </td>
              <td width="130"><input type="text" class="input-text w120"  name="itemlist[<?php echo $id2;?>][identifer]" value="<?php echo $lv2[identifer];?>"></td>
              <td width="80"><input type="text" class="input-text w60"  name="itemlist[<?php echo $id2;?>][displayorder]" value="<?php echo $lv2[displayorder];?>"></td>
              <td width="50" class="center"><input type="checkbox" class="checkbox" name="itemlist[<?php echo $id2;?>][enable]" value="1"<?php if($lv2[enable]) { ?> checked="checked"<?php } ?>></td>
              <td width="50" class="center"><input type="checkbox" class="checkbox" name="itemlist[<?php echo $id2;?>][available]" value="1"<?php if($lv2[available]) { ?> checked="checked"<?php } ?>></td>
              <td width="50"><a href="<?php echo U('c=itemcat&a=edit&catid='.$id2); ?>" class="edit">编辑</a></td>
          </tbody>
      	</table>
        <div id="item-list-div-<?php echo $id2;?>">
            <?php if(is_array($itemlist[$id2])) { foreach($itemlist[$id2] as $id3=>$lv3) { ?>            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
              <tbody>
                  <td width="40"><input type="checkbox" class="checkbox checkmark" name="delete[]" value="<?php echo $id3;?>" /></td>
                  <td width="60"><?php echo $id3;?></td>
                  <td width="70"><img src="<?php echo image($lv3[image]); ?>" width="50" height="50" rel="setImage" data-json="{catid:<?php echo $id3;?>}"></td>
                  <td>
                      <div class="cat-level cat-level-3"></div>
                      <input type="text" class="input-text w200" name="itemlist[$id3][name]" value="<?php echo $lv3[name];?>" maxlength="10">
                  </td>
                  <td width="130"><input type="text" class="input-text w120"  name="itemlist[<?php echo $id3;?>][identifer]" value="<?php echo $lv3[identifer];?>"></td>
                  <td width="80"><input type="text" class="input-text w60"  name="itemlist[<?php echo $id3;?>][displayorder]" value="<?php echo $lv3[displayorder];?>"></td>
                  <td width="50" class="center"><input type="checkbox" class="checkbox" name="itemlist[<?php echo $id3;?>][enable]" value="1"<?php if($lv3[enable]) { ?> checked="checked"<?php } ?>></td>
                  <td width="50" class="center"><input type="checkbox" class="checkbox" name="itemlist[<?php echo $id3;?>][available]" value="1"<?php if($lv3[available]) { ?> checked="checked"<?php } ?>></td>
                  <td width="50"><a href="<?php echo U('c=itemcat&a=edit&catid='.$id3); ?>" class="edit">编辑</a></td>
              </tbody>
            </table>
            <?php } } ?>        </div>
        <?php } } ?>    </div>
    <?php } } ?></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable table-no-border">
<tfoot>
<tr>
    <td>
        <label><input type="checkbox" class="checkbox checkall" /> 全选</label>
        <a href="javascript:;" onclick="addItem(0,1)" style="margin-left:20px;"><i class="iconfont icon-roundaddfill"></i>添加分类</a>
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
<script type="text/x-template" id="item-level-1">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable table-no-border">
	<tbody>
		<td width="40"><input type="hidden" name="itemlist[#id#][fid]" value="#fid#" /></td>
		<td width="60"><input type="hidden" name="itemlist[#id#][level]" value="#level#" /></td>
		<td width="70"></td>
		<td><div class="cat-level cat-level-#level#"></div><input type="text" class="input-text w200" name="itemlist[#id#][name]" value="" maxlength="10"></td>
		<td width="120"><input type="text" class="input-text w120" name="itemlist[#id#][identifer]" value=""></td>
		<td width="80"><input type="text" class="input-text w60" name="itemlist[#id#][displayorder]" value="0"></td>
		<td width="50" class="center"><input type="checkbox" class="checkbox" name="itemlist[#id#][enable]" value="1" checked="checked"></td>
		<td width="50" class="center"><input type="checkbox" class="checkbox" name="itemlist[#id#][available]" value="1" checked="checked"></td>
		<td width="50"></td>
	</tbody>
</table>
</script>
<script type="text/javascript">
var k = 0;
function addItem(fid,level){
	k--;
	var html = $("#item-level-1").html();
	html = html.replace(/#id#/g, k);
	html = html.replace(/#fid#/g, fid);
	html = html.replace(/#level#/g, level);
	if(level == 1){
		$("#item-list-div").append(html);
	}else {
		$("#item-list-div-"+fid).append(html);
	}
}
</script><?php include template('footer'); ?>