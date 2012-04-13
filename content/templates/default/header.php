<?php
/*
Template Name:默认模板
Description:默认模板，简洁优雅 ……
Version:1.2
Author:emlog
Author Url:http://www.emlog.net
Sidebar Amount:1
ForEmlog:4.2.1
*/
if(!defined('EMLOG_ROOT')) {exit('error!');}
require_once View::getView('module');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $blogtitle; ?></title>
<meta name="keywords" content="<?php echo $site_key; ?>" />
<meta name="description" content="<?php echo $description; ?>" />
<meta name="generator" content="emlog" />
<link rel="EditURI" type="application/rsd+xml" title="RSD" href="<?php echo BLOG_URL; ?>xmlrpc.php?rsd" />
<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="<?php echo BLOG_URL; ?>wlwmanifest.xml" />
<link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo BLOG_URL; ?>rss.php" />
<link href="<?php echo TEMPLATE_URL; ?>main.css" rel="stylesheet" type="text/css" />
<script src="<?php echo BLOG_URL; ?>include/lib/js/common_tpl.js" type="text/javascript"></script>
<?php doAction('index_head'); ?>
</head>
<body>
<div id="wrap">
  <div id="header">
    <h1><a href="<?php echo BLOG_URL; ?>"><?php echo $blogname; ?></a></h1>
    <h3><?php echo $bloginfo; ?></h3>
  </div>

  <div id="banner"><a href="<?php echo BLOG_URL; ?>"><img src="<?php echo BLOG_URL.Option::get('topimg'); ?>" height="134" width="960" /></a></div>

  <div id="nav">
    <ul>
	<li class="<?php echo $curpage == CURPAGE_HOME ? 'current' : 'common';?>"><a href="<?php echo BLOG_URL; ?>">首页</a></li>
	<?php if($istwitter == 'y'):?>
	<li class="<?php echo $curpage == CURPAGE_TW ? 'current' : 'common';?>"><a href="<?php echo BLOG_URL; ?>t/"><?php echo Option::get('twnavi');?></a></li>
	<?php endif;?>
	<?php 
	foreach ($navibar as $key => $val):
	if ($val['hide'] == 'y'){continue;}
	if (empty($val['url'])){$val['url'] = Url::log($key);}
	?>
	<li class="<?php echo isset($logid) && $key == $logid ? 'current' : 'common';?>"><a href="<?php echo $val['url']; ?>" target="<?php echo $val['is_blank']; ?>"><?php echo $val['title']; ?></a></li>
	<?php endforeach;?>
	<?php doAction('navbar', '<li class="common">', '</li>'); ?>
	<?php if(ROLE == 'admin' || ROLE == 'writer'): ?>
	<li class="common"><a href="<?php echo BLOG_URL; ?>admin/write_log.php">写日志</a></li>
	<li class="common"><a href="<?php echo BLOG_URL; ?>admin/">管理中心</a></li>
	<li class="common"><a href="<?php echo BLOG_URL; ?>admin/?action=logout">退出</a></li>
	<?php else: ?>
	<li class="common"><a href="<?php echo BLOG_URL; ?>admin/">登录</a></li>
	<?php endif; ?>
   	</ul>
  </div><!-- end #nav-->