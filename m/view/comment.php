<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="navi">
<a href="./">首页</a> 
<a href="./?action=tw">碎语</a> 
<a href="./?action=com" id="active">评论</a> 
<?php if(ISLOGIN === true): ?>
<a href="./?action=write">写日志</a> 
<a href="./?action=logout">退出</a>
<?php else:?>
<a href="<?php echo BLOG_URL; ?>m/?action=login">登录</a>
<?php endif;?>
</div>
<div id="m">
<?php 
foreach($comment as $value):
	$ishide = ISLOGIN === true && $value['hide']=='y'?'<font color="red" size="1">[待审]</font>':'';
?>
<div class="comcont"><a href="<?php echo BLOG_URL; ?>m/?post=<?php echo $value['gid']; ?>"><?php echo $value['content']; ?></a>
<?php if(ISLOGIN === true): ?>
<a href="./?action=delcom&id=<?php echo $value['cid'];?>"><font size="1">[删除]</font></a>
<?php endif;?>
</div>
<?php if(ISLOGIN === true): ?>
<div class="info">所属日志：<?php echo $value['title']; ?></div>
<?php endif;?>
<div class="cominfo">
<?php if(ISLOGIN === true && $value['hide'] == 'n'): ?>
<a href="./?action=hidecom&id=<?php echo $value['cid'];?>">屏蔽</a>
<?php elseif(ISLOGIN === true && $value['hide'] == 'y'):?>
<a href="./?action=showcom&id=<?php echo $value['cid'];?>">审核</a>
<?php endif;?>
<a href="./?action=reply&cid=<?php echo $value['cid'];?>">回复</a>
<br />
<?php if(ISLOGIN === true): ?>
<?php echo $value['date']; ?> by:<?php echo $value['poster']; ?>
<?php else:?>
by:<?php echo $value['name']; ?>
<?php endif;?>
</div>
<?php endforeach; ?>
<div id="page"><?php echo $pageurl;?></div>
</div>