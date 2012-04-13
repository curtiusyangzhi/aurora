<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="zh-CN" />
<meta name="author" content="emlog" />
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="X-UA-Compatible" content="IE=8" />
<link href="./views/style/<?php echo Option::get('admin_style');?>/style.css" type=text/css rel=stylesheet>
<link href="./views/css/css-main.css" type=text/css rel=stylesheet>
<script type="text/javascript" src="../include/lib/js/jquery/jquery-1.7.1.js"></script>
<script type="text/javascript" src="../include/lib/js/jquery/plugin-cookie.js"></script>
<script type="text/javascript" src="./views/js/common.js"></script>
<?php doAction('adm_head');?>
<title><?php echo Option::get('blogname'); ?> - 管理中心</title>
</head>
<body>
<div class="center">
<table id=header cellspacing=0 cellpadding=0 width="988" border=0>
  <tbody>
  <tr>
    <td width="9" id="headerleft"></td>
    <td width="125"  class="logo" align="left"><a href="./" title="返回管理首页">emlog</a></td>
    <td class="vesion" width="20"><?php echo Option::EMLOG_VERSION; ?></td>
    <td  class="home" align="left"><a href="../" target="_blank" title="在新窗口浏站点">
    <?php 
    	$blog_name = Option::get('blogname');
    	if (empty($blog_name)) {
    		$blog_name = '查看站点';
    	}
    	echo subString($blog_name, 0, 60);
    ?>
    </a></td>
    <td align=right nowrap class="headtext">
    <?php if (ROLE == 'admin'):?>
	你好，<a href="./blogger.php"><?php echo $user_cache[UID]['name'] ?>
	<img src="<?php echo empty($user_cache[UID]['avatar']) ? './views/images/avatar.jpg' : '../' . $user_cache[UID]['avatar'] ?>" 
	align="top" height="20" width="20" style="border:1px #FFFFFF solid;" />
	</a>&nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="configure.php"><img src="./views/images/setting.gif" align="absmiddle" border="0"> 设置</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	<a href="template.php" ><img src="./views/images/skin.gif" align="absmiddle" border="0"> 换模板</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	<?php else:?>
	<a href="blogger.php"><img src="./views/images/setting.gif" align="absmiddle" border="0"> 设置</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	<?php endif;?>
	<a href="./?action=logout">退出</a>
	</td>
    <td width="9" id="headerright" ></td>
	</tbody>
</table>
<table cellspacing=0 cellpadding=0 width="100%" border=0>
<tbody >
  <tr>
    <td valign=top align=left width="114">
    <div id=sidebartop></div>
	<table cellspacing=0 cellpadding=0 width="100%" border=0>
        <tbody>
        <tr>
          <td valign=top align=left width="114">
            <div id=sidebar>
            <div class="sidebarmenu" onclick="displayToggle('log_mg', 1);">日志管理</div>
			<div id="log_mg">
            <div class="sidebarsubmenu" id="menu_wt"><a href="write_log.php">写日志</a></div>
			<div class="sidebarsubmenu" id="menu_draft"><a href="admin_log.php?pid=draft">草稿<span id="dfnum">
			<?php 
			if (ROLE == 'admin'){
				echo $sta_cache['draftnum'] == 0 ? '' : '('.$sta_cache['draftnum'].')'; 
			}else{
				echo $sta_cache[UID]['draftnum'] == 0 ? '' : '('.$sta_cache[UID]['draftnum'].')';
			}
			?>
			</span></a></div>
			<div class="sidebarsubmenu" id="menu_log"><a href="admin_log.php">日志</a></div>
			<div class="sidebarsubmenu" id="menu_tw"><a href="twitter.php">碎语</a></div>
			<?php if (ROLE == 'admin'):?>
            <div class="sidebarsubmenu" id="menu_tag"><a href="tag.php">标签</a></div>
            <div class="sidebarsubmenu" id="menu_sort"><a href="sort.php">分类</a></div>
            <?php endif;?>
            <div class="sidebarsubmenu" id="menu_cm"><a href="comment.php">评论</a> </div>
            <?php
			$hidecmnum = ROLE == 'admin' ? $sta_cache['hidecomnum'] : $sta_cache[UID]['hidecommentnum'];
			if ($hidecmnum > 0):
			$n = $hidecmnum > 999 ? '...' : $hidecmnum;
			?>
			<div class="coment_number"><a href="./comment.php?hide=y" title="<?php echo $hidecmnum; ?>条待审"><?php echo $n; ?></a></div>
			<?php endif; ?>
            <div class="sidebarsubmenu" id="menu_tb"><a href="trackback.php">引用</a></div>
			</div>
			</div>
       	    </td>
		  </tr>
		</tbody>
	</table>
	<?php if (ROLE == 'admin'):?>
      <table cellspacing=0 cellpadding=0 width="100%" border=0 >
        <tbody>
        <tr>
          <td valign=top align=left width=114>
            <div id=sidebar>
            <div class="sidebarmenu" onclick="displayToggle('blog_mg', 1);">站点管理</div>
			<div id="blog_mg">
            <div class="sidebarsubmenu" id="menu_widget"><a href="widgets.php" >Widgets</a></div>
			<div class="sidebarsubmenu" id="menu_page"><a href="page.php" >页面</a></div>
			<div class="sidebarsubmenu" id="menu_link"><a href="link.php">链接</a></div>
			<div class="sidebarsubmenu" id="menu_user"><a href="user.php" >用户</a></div>
			<div class="sidebarsubmenu" id="menu_data"><a href="data.php">数据</a></div>
			</div>
			</div>
			</td>
		  </tr>
		</tbody>
	</table>
	<table cellspacing=0 cellpadding=0 width="100%" border=0>
      <tbody>
        <tr>
          <td valign=top align=left width=114>
            <div id=sidebar>
            <div class="sidebarmenu" onclick="displayToggle('extend_mg', 1);">功能扩展</div>
			<div id="extend_mg">
            <div class="sidebarsubmenu" id="menu_plug"><a href="plugin.php"><img src="./views/images/plugin.gif" align="absbottom" border="0"> 插件</a></div>
            <?php doAction('adm_sidebar_ext'); ?>
			</div>
			</div>
       	    </td>
		  </tr>
		</tbody>
	</table>
	<?php endif;?>
	<div id="sidebarBottom"></div>
</td>
<td id=container valign=top align=left>
<?php doAction('adm_main_top'); ?>
<script>
$("#blog_mg").css('display', $.cookie('em_blog_mg') ? $.cookie('em_blog_mg') : '');
$("#log_mg").css('display', $.cookie('em_log_mg') ? $.cookie('em_log_mg') : '');
$("#extend_mg").css('display', $.cookie('em_extend_mg') ? $.cookie('em_extend_mg') : '');
</script>