<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="navi">
<a href="./" id="active">首页</a>
<a href="./?action=tw">碎语</a>
<a href="./?action=com">评论</a>
<?php if(ISLOGIN === true): ?>
<a href="./?action=write">写日志</a> 
<a href="./?action=logout">退出</a>
<?php else:?>
<a href="<?php echo BLOG_URL; ?>m/?action=login">登录</a>
<?php endif;?>
</div>
<div id="m">
	<div class="posttitle"><?php echo $log_title; ?></div>
	<div class="postinfo">post by:<?php echo $user_cache[$author]['name'];?> <?php echo gmdate('Y-n-j G:i', $date); ?>
	<?php if(ROLE == 'admin' || $author == UID): ?>
	<a href="./?action=dellog&gid=<?php echo $logid;?>">删除</a>
	<?php endif;?>
	</div>
	<div class="postcont"><?php echo $log_content; ?></div>
	<div class="t">评论：</div>
	<div class="c">
		<?php foreach($commentStacks as $cid):
			$comment = $comments[$cid];
			$comment['poster'] = $comment['url'] ? '<a href="'.$comment['url'].'" target="_blank">'.$comment['poster'].'</a>' : $comment['poster'];
		?>
		<div class="l">
		<b><?php echo $comment['poster']; ?></b>
		<div class="info"><?php echo $comment['date']; ?> <a href="./?action=reply&cid=<?php echo $comment['cid'];?>">回复</a></div>
		<div class="comcont"><?php echo $comment['content']; ?></div>
		</div>
		<?php endforeach; ?>
		<div id="page"><?php echo $commentPageUrl;?></div>
	</div>
	<div class="t">发表评论：</div>
	<div class="c">
		<form method="post" action="./index.php?action=addcom&gid=<?php echo $logid; ?>">
		<?php if(ISLOGIN == true):?>
		当前已登录为：<b><?php echo $user_cache[UID]['name']; ?></b><br />
		<?php else: ?>
		昵称<br /><input type="text" name="comname" value="" /><br />
		邮件地址 (选填)<br /><input type="text" name="commail" value="" /><br />
		个人主页 (选填)<br /><input type="text" name="comurl" value="" /><br />
		<?php endif; ?>
		内容<br /><textarea name="comment" rows="10"></textarea><br />
		<?php echo $verifyCode; ?><br /><input type="submit" value="发表评论" />
		</form>
	</div>
</div>