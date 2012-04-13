<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script charset="utf-8" src="./editor/kindeditor.js"></script>
<div class=containertitle><b>写日志</b><span id="msg_2"></span></div>
<div id="msg"></div>
  <form action="save_log.php?action=add" method="post" enctype="multipart/form-data" id="addlog" name="addlog">
    <table cellspacing="1" cellpadding="4" width="720" border="0">
      <tbody>
        <tr nowrap="nowrap">
          <td>
          <label for="title" id="title_label">输入日志标题</label>
          <input type="text" maxlength="200" style="width:710px;" name="title" id="title"/>
          </td>
        </tr>
        <tr>
          <td>
          <a href="javascript: displayToggle('FrameUpload', 0);autosave(1);" class="thickbox">附件管理+</a><span id="asmsg">
          <?php doAction('adm_writelog_head'); ?>
          <input type="hidden" name="as_logid" id="as_logid" value="-1"></span><br />
          <div id="FrameUpload" style="display: none;">
		  	<iframe width="720" height="290" frameborder="0" src="attachment.php?action=selectFile"></iframe>
		  </div>
		  <textarea id="content" name="content" cols="100" rows="8" style="width:719px; height:460px;"></textarea>
          <script>loadEditor('content');</script>
          </td>
        </tr>
        <tr nowrap="nowrap">
          <td>
		  <div style="margin:10px 0px 5px 0px;">
		  <label for="tag" id="tag_label">日志标签，逗号或空格分隔</label>
          <input name="tag" id="tag" maxlength="200" style="width:432px;" />

          <select name="sort" id="sort" style="width:130px;">
	        <option value="-1">选择分类...</option>
			<?php foreach($sorts as $val):?>
			<option value="<?php echo $val['sid']; ?>"><?php echo $val['sortname']; ?></option>
			<?php endforeach;?>
	      </select>

	      <input maxlength="200" style="width:139px;" name="postdate" id="postdate" value="<?php echo $postDate; ?>"/>
	      <input name="date" id="date" type="hidden" value="" >
		  </div>
          <?php if (!empty($tags)):?>
		  <div style="color:#2A9DDB;cursor:pointer;"><a href="javascript:displayToggle('tagbox', 0);">选择已有标签+</a></div>
          <?php endif; ?>
          <div id="tagbox" style="width:688px;margin:0px 0px 0px 30px;display:none;">
          <?php 
          $tagStr = '';
          foreach ($tags as $val){
          	$tagStr .=" <a href=\"javascript: insertTag('{$val['tagname']}','tag');\">{$val['tagname']}</a> ";
          }
          echo $tagStr;?>
          </div>
          </td>
        </tr>
	</tbody>
	</table>
	<div id="show_advset" onclick="displayToggle('advset', 1);"><b>高级选项</b></div>
	<table cellspacing="1" cellpadding="4" width="720" border="0" id="advset">
        <tr nowrap="nowrap">
          <td><b>日志摘要：</b><br />
			<textarea id="excerpt" name="excerpt" style="width:719px; height:260px; border:#CCCCCC solid 1px;"></textarea>
            <script>loadEditor('excerpt');</script>
          </td>
        </tr>
        <tr nowrap="nowrap">
          <td><span id="alias_msg_hook"></span><b>链接别名：</b>(用于自定义日志链接。需要<a href="./permalink.php" target="_blank">启用链接别名</a>)<span id="alias_msg_hook"></span><br />
			<input name="alias" id="alias" style="width:711px;" />
          </td>
        </tr>   
        <tr nowrap="nowrap">
          <td><b>引用通告：</b>(每行一条引用地址)<br />
			<textarea name="pingurl" id="pingurl" style="width:715px; height:50px;" class="input"></textarea>
          </td>
        </tr>
        <tr>
          <td><b>日志访问密码：</b>
          <input type="text" value="" name="password" id="password" style="width:80px;" />
          <span id="post_options">
          <input type="checkbox" value="y" name="top" id="top" />
          <label for="top">日志置顶</label>
          <input type="checkbox" value="y" name="allow_remark" id="allow_remark" checked="checked" />
          <label for="allow_remark">允许评论</label>
          <input type="checkbox" value="y" id="allow_tb" name="allow_tb" checked="checked" />
          <label for="allow_tb">允许引用</label>
          </span>
		  </td>
        </tr>
	</table>
	<table cellspacing="1" cellpadding="4" width="720" border="0">
		<tr>
          <td align="center"><br>
          <input type="hidden" name="ishide" id="ishide" value="">
          <input type="submit" value="发布日志" onclick="return checkform();" class="button" />
          <input type="hidden" name="author" id="author" value=<?php echo UID; ?> />	 
          <input type="button" name="savedf" id="savedf" value="保存草稿" onclick="autosave(2);" class="button" />
		  </td>
        </tr>
    </table>
  </form>
<div class=line></div>
<script>
$("#menu_wt").addClass('sidebarsubmenu1');
$("#advset").css('display', $.cookie('em_advset') ? $.cookie('em_advset') : '');
$("#alias").keyup(function(){checkalias();});
$("#title").focus(function(){$("#title_label").hide();});
$("#title").blur(function(){if($("#title").val() == '') {$("#title_label").show();}});
$("#tag").focus(function(){$("#tag_label").hide();});
$("#tag").blur(function(){if($("#tag").val() == '') {$("#tag_label").show();}});
setTimeout("autosave(0)",60000);
</script>