<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b>修改作者资料</b>
<?php if(isset($_GET['error_login'])):?><span class="error">用户名不能为空</span><?php endif;?>
<?php if(isset($_GET['error_exist'])):?><span class="error">该用户名已存在</span><?php endif;?>
<?php if(isset($_GET['error_pwd_len'])):?><span class="error">密码长度不得小于6位</span><?php endif;?>
<?php if(isset($_GET['error_pwd2'])):?><span class="error">两次输入密码不一致</span><?php endif;?>
</div>
<div class=line></div>
<form action="user.php?action=update" method="post">
<div id="user_edit">
	<li><input type="text" value="<?php echo $username; ?>" name="username" style="width:200px;" /> 用户名</li>
	<li><input type="text" value="<?php echo $nickname; ?>" name="nickname" style="width:200px;" /> 昵称</li>
	<li><input type="password" value="" name="password" style="width:200px;" /> 新密码(不修改请留空)</li>
	<li><input type="password" value="" name="password2" style="width:200px;" /> 重复新密码</li>
	<li><input type="text"  value="<?php echo $email; ?>" name="email" style="width:200px;" /> 电子邮件</li>
	<li>
	<select name="role">
		<option value="writer" <?php echo $ex1; ?>>作者</option>
		<option value="admin" <?php echo $ex2; ?>>管理员</option>
	</select>
	</li>
	<li>个人描述<br />
	<textarea name="description" rows="5" style="width:260px;"><?php echo $description; ?></textarea></li>
	<li>
	<input type="hidden" value="<?php echo $uid; ?>" name="uid" />
	<input type="submit" value="保 存" class="submit" />
	<input type="button" value="取 消" class="submit" onclick="window.location='user.php';" /></li>
</div>
</form>
<script>
setTimeout(hideActived,2600);
$("#menu_user").addClass('sidebarsubmenu1');
</script>