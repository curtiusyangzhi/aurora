<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>
$(document).ready(function(){
	$("#adm_tb_list tbody tr:odd").addClass("tralt_b");
	$("#adm_tb_list tbody tr")
		.mouseover(function(){$(this).addClass("trover")})
		.mouseout(function(){$(this).removeClass("trover")})
});
setTimeout(hideActived,2600);
</script>
<div class=containertitle><b>引用管理</b>
<?php if(isset($_GET['active_del'])):?><span class="actived">删除引用成功</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error">请选择要执行操作的引用</span><?php endif;?>
</div>
<div class=line></div>
<form action="trackback.php?action=dell" method="post" name="form_tb" id="form_tb">
  <table width="100%" id="adm_tb_list" class="item_list">
  <thead>
      <tr>
        <th width="280" colspan="2"><b>标题</b></th>
        <th width="300"><b>来源</b></th>
		<th width="80"><b>IP</b></th>
        <th width="120"><b>时间</b></th>
      </tr>
  </thead>
  <tbody>
	<?php 
	if($trackback):
	foreach($trackback as $key=>$value):?>	
      <tr>
        <td width="10"><input type="checkbox" name="tb[]" value="<?php echo $value['tbid']; ?>" class="ids" ></td>
        <td width="270"><a href="<?php echo $value['url']; ?>" target="_blank"><?php echo $value['title']; ?></a></td>
        <td><?php echo $value['blog_name']; ?></td>
        <td><?php echo $value['ip']; ?></td>
        <td><?php echo $value['date']; ?></td>
      </tr>
	<?php endforeach;else:?>
	  <tr><td class="tdcenter" colspan="5">还没有收到引用</td></tr>
	<?php endif;?>
	</tbody>
  </table>
<div class="list_footer"><a href="javascript:void(0);" id="select_all">全选</a> 选中项：<a href="javascript:tbact('del');">删除</a></div>
<div class="page"><?php echo $pageurl; ?> (有<?php echo $tbnum; ?>条引用)</div> 
</form>
<script>
function tbact(act){
	if (getChecked('ids') == false) {
		alert('请选择要操作的引用');
		return;
	}
	if(act == 'del' && !confirm('你确定要删除所选引用吗？')){return;}
	$("#operate").val(act);
	$("#form_tb").submit();
}
$("#select_all").toggle(function () {$(".ids").attr("checked", "checked");},function () {$(".ids").removeAttr("checked");});
$("#menu_tb").addClass('sidebarsubmenu1');
</script>