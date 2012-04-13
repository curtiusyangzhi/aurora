<?php
/**
 * 个人资料
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';

if ($action == '') {
	$User_Model = new User_Model();
	$row = $User_Model->getOneUser(UID);
	extract($row);
	$icon = '';
	if ($photo && file_exists($photo)){
		$imgsize = chImageSize($photo, Option::ICON_MAX_W, Option::ICON_MAX_H);
		$icon = "<img src=\"{$photo}\" width=\"{$imgsize['w']}\" height=\"{$imgsize['h']}\" style=\"border:1px solid #CCCCCC;padding:1px;\" />
		<br /><a href=\"javascript: em_confirm(0, 'avatar');\">删除头像</a>";
	}
	include View::getView('header');
	require_once(View::getView('blogger'));
	include View::getView('footer');
	View::output();
}

if ($action == 'update') {
	$User_Model = new User_Model();
	$photo = isset($_POST['photo']) ? addslashes(trim($_POST['photo'])) : '';
	$nickname = isset($_POST['name']) ? addslashes(trim($_POST['name'])) : '';
	$email = isset($_POST['email']) ? addslashes(trim($_POST['email'])) : '';
	$description = isset($_POST['description']) ? addslashes(trim($_POST['description'])) : '';

	if(strlen($nickname) > 20) {
		emDirect("./blogger.php?error_a=true");
	}else if($email != '' && !checkMail($email)) {
		emDirect("./blogger.php?error_b=true");
	}

	$photo_type = array('gif', 'jpg', 'jpeg','png');
	if($_FILES['photo']['size'] > 0)
	{
		$usericon = uploadFile($_FILES['photo']['name'], $_FILES['photo']['error'], $_FILES['photo']['tmp_name'], $_FILES['photo']['size'], $photo_type, true);
	}else{
		$usericon = $photo;
	}
	$User_Model->updateUser(array('nickname'=>$nickname, 'email'=>$email, 'photo'=>$usericon, 'description'=>$description), UID);
	$CACHE->updateCache('user');
	emDirect("./blogger.php?active_edit=true");
}

if ($action == 'delicon') {
	$DB = MySql::getInstance();
	$query = $DB->query("select photo from ".DB_PREFIX."user where uid=" . UID);
	$icon = $DB->fetch_array($query);
	$icon_1 = $icon['photo'];
	if(file_exists($icon_1)){
		$icon_2 = str_replace('thum-', '', $icon_1);
		if($icon_2 != $icon_1 && file_exists($icon_2)){
			unlink($icon_2);
		}
		$icon_3 = preg_replace("/^(.*)\/(.*)$/", "\$1/thum52-\$2", $icon_2);
		if($icon_3 != $icon_2 && file_exists($icon_3)){
			unlink($icon_3);
		}
		unlink($icon_1);
	}
	$DB->query("UPDATE ".DB_PREFIX."user SET photo='' where uid=" . UID);
	$CACHE->updateCache('user');
	emDirect("./blogger.php?active_del=true");
}

if ($action == 'update_pwd') {

	$User_Model = new User_Model();

	$login = isset($_POST['username']) ? addslashes(trim($_POST['username'])) : '';
	$newpass = isset($_POST['newpass']) ? addslashes(trim($_POST['newpass'])) : '';
	$oldpass = isset($_POST['oldpass']) ? addslashes(trim($_POST['oldpass'])) : '';
	$repeatpass = isset($_POST['repeatpass']) ? addslashes(trim($_POST['repeatpass'])) : '';

	$PHPASS = new PasswordHash(8, true);
	$ispass = checkPassword($oldpass, $userData['password']);

	if(!$ispass)
	{
		emMsg('错误的当前密码');
	}elseif(!empty($login) && $User_Model->isUserExist($login, UID)){
		emMsg('用户名已存在');
	}elseif(strlen($newpass)>0 && strlen($newpass) < 6){
		emMsg('密码长度不得小于6位');
	}elseif(!empty($newpass) && $newpass != $repeatpass){
		emMsg('两次输入的密码不一致');
	}

	if(!empty($newpass) && empty($login))//只修改密码
	{
		$newpass = $PHPASS->HashPassword($newpass);
		$User_Model->updateUser(array('password'=>$newpass), UID);
		emMsg('密码修改成功!','./');
	}elseif(!empty($newpass) && !empty($login))//修改密码及用户
	{
		$newpass = $PHPASS->HashPassword($newpass);
		$User_Model->updateUser(array('username'=>$login, 'password'=>$newpass), UID);
		emMsg('密码和后台登录名修改成功!请重新登录','./');
	}elseif(empty($newpass) && !empty($login))//只修改后台登录名
	{
		$User_Model->updateUser(array('username'=>$login), UID);
		emMsg('后台登录名修改成功!请重新登录','./');
	}else{
		emMsg('请输入要修改的项目');
	}
}
