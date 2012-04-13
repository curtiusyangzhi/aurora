<?php
/**
 * 模板管理
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';

if($action == '') {
	$nonce_templet = Option::get('nonce_templet');
	$nonceTplData = @implode('', @file(TPLS_PATH.$nonce_templet.'/header.php'));
	preg_match("/Template Name:(.*)/i", $nonceTplData, $tplName);
	preg_match("/Version:(.*)/i", $nonceTplData, $tplVersion);
	preg_match("/Author:(.*)/i", $nonceTplData, $tplAuthor);
	preg_match("/Description:(.*)/i", $nonceTplData, $tplDes);
	preg_match("/Author Url:(.*)/i", $nonceTplData, $tplUrl);
	preg_match("/ForEmlog:(.*)/i", $nonceTplData, $tplForEmlog);
	$tplName = !empty($tplName[1]) ? trim($tplName[1]) : $nonce_templet;
	$tplDes = !empty($tplDes[1]) ? $tplDes[1] : '';
	$tplVer = !empty($tplVersion[1]) ? $tplVersion[1] : '';
	$tplForEm = !empty($tplForEmlog[1]) ? '适用于emlog：' . $tplForEmlog[1] : '';

	if(isset($tplAuthor[1]))
	{
		$tplAuthor = !empty($tplUrl[1]) ? "作者：<a href=\"{$tplUrl[1]}\">{$tplAuthor[1]}</a>" : "作者：{$tplAuthor[1]}";
	}else{
		$tplAuthor = '';
	}
	//模板列表
	$handle = @opendir(TPLS_PATH) OR die('emlog template path error!');
	$tpls = array();
	while ($file = @readdir($handle))
	{
		if(@file_exists(TPLS_PATH.$file.'/header.php'))
		{
			$tplData = implode('', @file(TPLS_PATH.$file.'/header.php'));
			preg_match("/Template Name:([^\r\n]+)/i", $tplData, $name);
			preg_match("/Sidebar Amount:([^\r\n]+)/i", $tplData, $sidebar);
			$tplInfo['tplname'] = !empty($name[1]) ? trim($name[1]) : $file;
			$tplInfo['sidebar'] = !empty($sidebar[1]) ? intval($sidebar[1]) : 1;
			$tplInfo['tplfile'] = $file;

			$tpls[] = $tplInfo;
		}
	}
	closedir($handle);

	$tplnums = count($tpls);

	include View::getView('header');
	require_once View::getView('template');
	include View::getView('footer');
	View::output();
}

//使用模板
if($action == 'usetpl')
{
	$tplName = isset($_GET['tpl']) ? addslashes($_GET['tpl']) : '';
	$tplSideNum = isset($_GET['side']) ? intval($_GET['side']) : '';

	Option::updateOption('nonce_templet', $tplName);
	Option::updateOption('tpl_sidenum', $tplSideNum);
	$CACHE->updateCache('options');
	emDirect("./template.php?activated=true");
}

//删除模板
if($action == 'del')
{
	$tplName = isset($_GET['tpl']) ? addslashes($_GET['tpl']) : '';

	if (true === emDeleteFile(TPLS_PATH . $tplName)) {
		emDirect("./template.php?activate_del=1#tpllib");
	} else {
		emDirect("./template.php?error_a=1#tpllib");
	}
}

//自定义顶部图片页面
if($action == 'custom-top')
{
	$topimg = Option::get('topimg');

	$top_image_path = TPLS_PATH . 'default/images/top/';

	$handle = @opendir($top_image_path) OR die('emlog default template path error!');
	$default_topimgs = array();
    while ($file = @readdir($handle)) 
    {
    	if (getFileSuffix($file) == 'jpg' && !strstr($file, '_mini.jpg')) {
        	$default_topimgs[] = array('path'=>'content/templates/default/images/top/'.$file);
    	}
    }
    $custom_topimgs = Option::get('custom_topimgs');
    $topimgs = array_merge($default_topimgs, $custom_topimgs);
	closedir($handle);

	include View::getView('header');
	require_once View::getView('template_top');
	include View::getView('footer');
	View::output();
}

//使用顶部图片
if($action == 'update_top')
{
	$top = isset($_GET['top']) ? addslashes($_GET['top']) : '';

	Option::updateOption('topimg', $top);
	$CACHE->updateCache('options');
	emDirect("./template.php?action=custom-top&activated=true");
}

//删除自定义顶部图片
if($action == 'del_top')
{
	$top = isset($_GET['top']) ? addslashes($_GET['top']) : '';

	$custom_topimgs = Option::get('custom_topimgs');
	$key = array_search($top, $custom_topimgs);
	if(isset($custom_topimgs[$key])) {
		unset($custom_topimgs[$key]);
	}

	$top_mini = str_replace('.jpg', '_mini.jpg', $top);
	@unlink('../' . $top);
	@unlink('../' . $top_mini);

	Option::updateOption('custom_topimgs', serialize($custom_topimgs));

	$CACHE->updateCache('options');
	emDirect("./template.php?action=custom-top&active_del=true");
}

//上传顶部图片
if ($action == 'upload_top') {
	$photo_type = array('jpg', 'jpeg', 'png');
	$topimg = '';

	if($_FILES['topimg']['error'] != 4)
	{
		$topimg = uploadFile($_FILES['topimg']['name'], $_FILES['topimg']['error'], $_FILES['topimg']['tmp_name'], $_FILES['topimg']['size'], $photo_type, false, false);
	}else{
		emDirect("./template.php?action=custom-top");
	}

	include View::getView('header');
	require_once View::getView('template_crop');
	include View::getView('footer');
	View::output();
}

//裁剪图片
if ($action == 'crop') {
	$x1 = isset($_POST['x1']) ? intval($_POST['x1']) : 0;
	$y1 = isset($_POST['y1']) ? intval($_POST['y1']) : 140;
	$width = isset($_POST['width']) ? intval($_POST['width']) : 960;
	$height = isset($_POST['height']) ? intval($_POST['height']) : 134;
	$top_img = isset($_POST['img']) ? $_POST['img'] : '';

	$time = time();

	//create topimg
	$topimg_path = Option::UPLOADFILE_PATH . gmdate('Ym') . '/top-' . $time . '.jpg';
	$ret = imageCropAndResize($top_img, $topimg_path, 0, 0, $x1, $y1, $width, $height, $width, $height);
	if (false === $ret) {
		emDirect("./template.php?action=custom-top&error_a=true");
	}

	//create mini topimg
	$topimg_mini_path = Option::UPLOADFILE_PATH . gmdate('Ym') . '/top-' . $time . '_mini.jpg';
	$ret = imageCropAndResize($topimg_path, $topimg_mini_path, 0, 0, 0, 0, 230, 48, $width, $height);
	if (false === $ret) {
		emDirect("./template.php?action=custom-top&error_a=true");
	}

	@unlink($top_img);

	$custom_topimgs = Option::get('custom_topimgs');
	array_push($custom_topimgs, substr($topimg_path, 3));

	Option::updateOption('topimg', substr($topimg_path, 3));
	Option::updateOption('custom_topimgs', serialize($custom_topimgs));
	$CACHE->updateCache('options');
	emDirect("./template.php?action=custom-top&activated=true");
}

//安装模板
if($action == 'install')
{
	include View::getView('header');
	require_once View::getView('template_install');
	include View::getView('footer');
	View::output();
}

//上传zip模板
if ($action == 'upload_zip') {
	$zipfile = isset($_FILES['tplzip']) ? $_FILES['tplzip'] : '';

	if ($zipfile['error'] == 4){
		emDirect("./template.php?action=install&error_d=1");
	}
	if (!$zipfile || $zipfile['error'] >= 1 || empty($zipfile['tmp_name'])){
		emMsg('模板上传失败');
	}
	if (getFileSuffix($zipfile['name']) != 'zip') {
		emDirect("./template.php?action=install&error_a=1");
	}

	$ret = emUnZip($zipfile['tmp_name'], '../content/templates/', 'tpl');
	switch ($ret) {
		case 0:
			emDirect("./template.php?activate_install=1#tpllib");
			break;
		case -2:
			emDirect("./template.php?action=install&error_e=1");
			break;
		case 1:
		case 2:
			emDirect("./template.php?action=install&error_b=1");
			break;
		case 3:
			emDirect("./template.php?action=install&error_c=1");
			break;
	}
}
