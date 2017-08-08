<?php if (!defined('IN_DSXCMS')) die('Access Denied!');?><?php include template('header'); ?><div class="console-title">
	<div class="float-right">
    <form method="get" name="formsearch">
    <select name="province" style="width: auto;" onchange="this.form.city.value=0;this.form.county.value=0;refreshdistrict()">
        <option>--省份--</option>
        <?php if(is_array($provincelist)) { foreach($provincelist as $pro) { ?>        <option value="$pro[id]"<?php if($pro[id]==$province) { ?> selected="selected"<?php } ?>><?php echo $pro[name];?></option>
        <?php } } ?>    </select>
    <select name="city" style="width: auto;" onchange="this.form.county.value='';refreshdistrict()">
        <option value="0">--城市--</option>
        <?php if(is_array($citylist)) { foreach($citylist as $ct) { ?>        <option value="$ct[id]"<?php if($ct[id]==$city) { ?> selected="selected"<?php } ?>><?php echo $ct[name];?></option>
        <?php } } ?>    </select>
    <select name="county" style="width: auto;" onchange="refreshdistrict()">
        <option value="0">--州县--</option>
        <?php if(is_array($countylist)) { foreach($countylist as $cot) { ?>        <option value="$cot[id]"<?php if($cot[id]==$county) { ?> selected="selected"<?php } ?>><?php echo $cot[name];?></option>
        <?php } } ?>    </select>
    </form> 
    </div>
    <h2>区域管理</h2>
</div>
<div class="content-div">
<form method="post" action="">
  <input type="hidden" name="formsubmit" value="yes" />
  <input type="hidden" name="formhash" value="<?php echo FORMHASH; ?>">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
  <thead>
      <th width="30" class="center">删?</th>
      <th>名称</th>
  </thead>
  <tbody id="districtlist">
  <?php if(is_array($districtlist)) { foreach($districtlist as $dst) { ?>  <tr>
    <td><input type="checkbox" class="checkbox checkmark" name="delete[]" value="<?php echo $dst[id];?>" /></td>
    <td><input type="text" class="text text200" name="districtnew[<?php echo $dst[id];?>][name]" value="<?php echo $dst[name];?>" maxlength="10"></td>
  </tr>
  <?php } } ?>  </tbody>
  <tfoot>
  <tr>
      <td colspan="2">
          <label><input type="checkbox" class="checkbox checkall" /> 全选</label>
          <a href="javascript:;" id="addnew"><i class="icon">&#xf0154;</i>添加区域</a>
      </td>
  </tr>
  <tr>
      <td colspan="2">
          <input type="submit" class="button" value="提交" />
          <input type="button" class="button cancel" value="刷新" onclick="window.location.reload()" />
      </td>
  </tr>
  </tfoot>
</table>
</form>
</div>
<script type="text/template" id="tplDistrict">
<tr>
	<td><input type="hidden" name="newdistrict[#keynum#][fid]" value="$fid" />
	<input type="hidden" name="newdistrict[#keynum#][level]" value="$level" /></td>
	<td><input type="text" class="text text200" name="newdistrict[#keynum#][name]" value=""></td>
</tr>
</script>
<script type="text/javascript">
var keynum = 0;
$("#addnew").click(function(){
	var html = $("#tplDistrict").html().replace(/#keynum#/g,keynum);
	$("#districtlist").append(html);
	keynum--;
});

function refreshdistrict(){
	var form = $("form[name=formsearch]");
	var province = form.find("[name=province]").val();
	var city = form.find("[name=city]").val();
	var county = form.find("[name=county]").val();
	window.location = '/?m=<?php echo $G[m];?>&c=<?php echo $G[c];?>&province='+province+'&city='+city+'&county='+county;
}
</script><?php include template('footer'); ?>