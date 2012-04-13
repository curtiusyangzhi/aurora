<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<div class=containertitle><b>数据备份</b>
<?php if(isset($_GET['active_del'])):?><span class="actived">备份文件删除成功</span><?php endif;?>
<?php if(isset($_GET['active_backup'])):?><span class="actived">数据备份成功</span><?php endif;?>
<?php if(isset($_GET['active_import'])):?><span class="actived">备份导入成功</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error">请选择要删除的备份文件</span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error">错误的备份文件名</span><?php endif;?>
</div>
<div class=line></div>
<form  method="post" action="data.php?action=dell_all_bak" name="form_bak" id="form_bak">
<table width="100%" id="adm_bakdata_list" class="item_list">
  <thead>
    <tr>
      <th width="683" colspan="2"><b>备份文件</b></th>
      <th width="226"><b>备份时间</b></th>
      <th width="149"><b>文件大小</b></th>
      <th width="87"></th>
    </tr>
  </head>
  <tbody>
	<?php
		if($bakfiles):
		foreach($bakfiles  as $value):
		$modtime = smartDate(filemtime($value),'Y-m-d H:i:s');
		$size =  changeFileSize(filesize($value));
		$bakname = substr(strrchr($value,'/'),1);
	?>
    <tr>
      <td width="22"><input type="checkbox" value="<?php echo $value; ?>" name="bak[]" class="ids" /></td>
      <td width="661"><a href="../content/backup/<?php echo $bakname; ?>"><?php echo $bakname; ?></a></td>
      <td><?php echo $modtime; ?></td>
      <td><?php echo $size; ?></td>
      <td><a href="javascript: em_confirm('<?php echo $value; ?>', 'backup');">导入</a></td>
    </tr>
	<?php endforeach;else:?>
	  <tr><td class="tdcenter" colspan="5">还没有备份</td></tr>
	<?php endif;?>
	</tbody>
</table>
<div class="list_footer">
<a href="javascript:void(0);" id="select_all">全选</a> 选中项：<a href="javascript:bakact('del');">删除</a></div>
</form>
<div style="margin:20px 0px 20px 0px;"><a href="javascript:$('#import').hide();displayToggle('backup', 0);">备份数据+</a>　<a href="javascript:$('#backup').hide();displayToggle('import', 0);">导入本地备份文件+</a></div>
<form action="data.php?action=bakstart" method="post">
<div id="backup">
	<p>选择要备份的数据库表：<br /><select multiple="multiple" size="11" name="table_box[]">
		<?php foreach($tables  as $value): ?>
		<option value="<?php echo DB_PREFIX; ?><?php echo $value; ?>" selected="selected"><?php echo DB_PREFIX; ?><?php echo $value; ?></option>
		<?php endforeach; ?>
      	</select></p>
	<p>备份文件名：(由英文字母、数字、下划线组成) <br /><input maxlength="200" size="35" value="<?php echo $defname; ?>" name="bakfname" /><b>.sql</b></p>
	<p>备份文件保存在？
	本地<input type="radio" checked="checked" value="local" name="bakplace" id="bakup_place" />
	服务器<input type="radio" value="server" name="bakplace" id="bakup_place" /></p>
	<p><input type="submit" value="开始备份" class="submit" /></p>
</div>
</form>
<form action="data.php?action=import" enctype="multipart/form-data" method="post">
<div id="import">
	<p><input type="file" name="sqlfile" /> <input type="submit" value="导入" class="submit" /></p>
</div>
</form>
<div class=containertitle><b>数据缓存</b>
<?php if(isset($_GET['active_mc'])):?><span class="actived">缓存更新成功</span><?php endif;?>
</div>
<div class=line></div>
<div style="margin:0px 0px 20px 0px;">
	<p class="des">缓存可以大幅度提高站点的加载速度。通常系统会自动更新缓存，无需手动。有些特殊情况，比如缓存文件被修改、手动修改过数据库、页面出现异常等才需要手动更新。</p>
	<p><input type="button" onclick="window.location='data.php?action=Cache';" value="更新缓存" class="submit" /></p>
</div>
<script>
setTimeout(hideActived,2600);
$(document).ready(function(){
	$("#select_all").toggle(function () {$(".ids").attr("checked", "checked");},function () {$(".ids").removeAttr("checked");});
	$("#adm_bakdata_list tbody tr:odd").addClass("tralt_b");
	$("#adm_bakdata_list tbody tr")
		.mouseover(function(){$(this).addClass("trover")})
		.mouseout(function(){$(this).removeClass("trover")})
});
function bakact(act){
	if (getChecked('ids') == false) {
		alert('请选择要操作的备份文件');
		return;
	}
	if(act == 'del' && !confirm('你确定要删除所选备份文件吗？')){return;}
	$("#operate").val(act);
	$("#form_bak").submit();
}
$("#menu_data").addClass('sidebarsubmenu1');
</script>