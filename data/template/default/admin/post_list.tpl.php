<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="console-title">
	<div class="float-right">
        <form name="search" action="/?">
            <input type="hidden" name="m" value="<?php echo $_G[m];?>">
            <input type="hidden" name="c" value="<?php echo $_G[c];?>">
            <input type="hidden" name="a" value="<?php echo $_G[a];?>">
            <input type="hidden" name="status" value="<?php echo $status;?>">
            <select name="catid" id="catid" style="width: auto;">
                <option value="0">所有栏目</option>
                <?php echo $categoryoptions;?>
            </select>
            <input type="text" class="input-text" name="keyword" value="<?php echo $keyword;?>">
            <input type="submit" class="button" value="<?php echo $_lang[search];?>">
            <a href="<?php echo U('c=postcat'); ?>" class="button">分类管理</a>
            <a href="<?php echo U('a=add'); ?>" class="button">发布文章</a>
        </form>
    </div>
    <h2>文章管理->文章列表</h2>
</div>
<div class="toolbar">
	<div class="f-right"><span class="pages"><?php echo $pages;?></span></div>

</div>
<div class="table-wrap">
    <form method="post" id="postForm">
    <input type="hidden" name="formsubmit" value="yes" />
    <input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
    <thead>
      <tr>
        <th width="20" class="center">选?</th>
        <th width="50">图片</th>
        <th>标题</th>
        <th width="100">分类</th>
        <th width="60">形式</th>
        <th width="60">点击</th>
        <th width="140">时间</th>
        <th width="80">状态</th>
        <th width="40">编辑</th>
      </tr>
     </thead>
     <tbody>
      <?php if(is_array($postlist)) { foreach($postlist as $id=>$item) { ?>      <tr>
        <td class="center"><input type="checkbox" class="checkbox checkmark" name="id[]" value="<?php echo $id;?>"></td>
        <td><img src="<?php echo image($item[image]); ?>" width="50" height="50" rel="pickimage" data-json="{id:<?php echo $id;?>}"></td>
        <th><a href="<?php echo $item[url];?>" target="_blank"><?php echo $item[title];?></a></th>
        <td><?php echo $item[cat_name];?></td>
        <td><?php echo $item[type_name];?></td>
        <td><?php echo $item[viewnum];?></td>
        <td><?php echo $item[formatted_pubtime];?></td>
        <td><?php echo $item[status_name];?></td>
        <td><a href="<?php echo U('a=edit&id='.$id); ?>">编辑</a></td>
      </tr>
      <?php } } ?>      </tbody>
      <tfoot>
      <tr>
        <td colspan="10">
            <label><input type="checkbox" class="checkbox checkall"> <?php echo $_lang[selectall];?></label>
            <label><input type="radio" class="radio" name="option" value="delete" checked> 删除</label>
            <label><input type="radio" class="radio" name="option" value="move"> 移动</label>
            <label><input type="radio" class="radio" name="option" value="audit"> 审核通过</label>
            <label><input type="radio" class="radio" name="option" value="unaudit"> 审核未过</label>
        </td>
      </tr>
      <tr>
          <td colspan="10">
              <span class="pages"><?php echo $pages;?></span>
              <input type="button" class="button" value="<?php echo $_lang[submit];?>" id="submitButton">
              <input type="button" class="button cancel" value="<?php echo $_lang[refresh];?>" onclick="window.location.reload()">
          </td>
      </tr>
     </tfoot>
    </table>
    </form>
</div>
<script type="text/javascript">
var spinner;
$("#submitButton").click(function(e) {
    if($("input.checkmark:checked").length == 0){
		DSXUI.error("请至少选择一个选项");
	}else {
		if($("[name=option]:checked").val() !== 'move'){
			$("#postForm").ajaxSubmit({
				dataType:'json',
				beforeSend:function(){
					spinner = DSXUI.showSpinner();
				},
				success:function(json){
					setTimeout(function(){
						spinner.close();
						if(json.errcode == 0){
							DSXUtil.reFresh();
						}
					},1000);
				}
			});
		}else {
			$("#postForm").submit();
		}
	}
});
</script><?php include template('footer'); ?>