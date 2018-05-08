<?php if(!defined('IN_WEB')) exit('Access Denied');?><div id="body">
    <div class="space">
<?php if($_GET['op']=='artlist' ) { ?>
 	<div class="subtitle"><a href="<?=$baseurl?>&ac=article&op=artlist">文章列表</a> > <?=$navstr?></div>
 	    <table class="maintable" border="0" cellspacing="0" cellpadding="0">
<tr class="altbg2">
                <td colspan="7">
<?php if(is_array($typearr)) { foreach($typearr as $val) { ?>
<?php if($val['id']==$_GET['tid']) { ?>
<b><?=$val['ctypename']?></b>
<?php } else { ?>
<a href="<?=$baseurl?>&ac=article&op=artlist&tid=<?=$val['id']?>"><?=$val['ctypename']?></a>
<?php } ?>[<a href="article.php?ac=list&tid=<?=$val['id']?>" target="_blank"><font color="#FF0000">预</font></a>] | 
<?php } } ?><input type="button" class="btn" onclick="location.href='<?=$baseurl?>&ac=article&op=addarticle&tid=<?=$_GET['tid']?>'" value="添加文章" />
</td>
</tr>
 
        <form name="form1" method="get" action="admincp.php">
 <tr class="altbg1">
                <td colspan="7">
标题:<input  type="text" name="title"   class="txtbox2"  value="<?=$_GET['title']?>"/>
 				自定义标识:
<select name="diyflag">
<option value="0">全部</option>
<?php if(is_array($flaglist)) { foreach($flaglist as $val) { ?>
<option value="<?=$val['id']?>" <?php if($_GET['diyflag']==$val['id']) { ?>selected<?php } ?>><?=$val['flagname']?></option>
<?php } } ?>
</select>
                 <input type="hidden" name="mod" value="article" /><input type="hidden" name="ac" value="article" />
 <input type="hidden" name="op" value="artlist" /><input type="hidden" name="tid" value="<?=$_GET['tid']?>" />
                 <input type="submit" name="serach" value="查询"/></td>
          </tr>
  </form>
              <tr class="altbg1">
                <td>id</td>
    <td>标题</td>
                <td>作者</td>
                <td>添加时间</td>
                 <td>发布时间</td>
                 <td>自定义标记</td>
                 <td width="100">操作</td>
            </tr>
            <?php if(is_array($artarr)) { foreach($artarr as $val) { ?>
               <tr>
                <td><?=$val['id']?></td> 
<td><a href="<?=$baseurl?>&ac=article&op=editarticle&id=<?=$val['id']?>"><?=$val['title']?></a></td>
                <td><?=$val['author']?></td>
                <td><?=$val['adddt']?></td>
                <td><?=$val['pubdt']?></td>
                 <td><font color="#FF0000"><?=$val['flagname']?></font></td>
                <td><a href="article.php?ac=content&id=<?=$val['id']?>" target="_blank">预览</a>&nbsp;<a href="<?=$baseurl?>&ac=article&op=editarticle&id=<?=$val['id']?>">修改</a>&nbsp;<a href="<?=$baseurl?>&ac=article&op=del&artid=<?=$val['id']?>" onClick="return window.confirm('本操作不可逆，您确认删除吗？');">删除</a> </td>
            </tr>
           <?php } } ?> 
        
         </table>
   <div class="tab"><div class="pages"><?=$multi?></div></div>
<?php } elseif($_GET['op']=='addarticle' || $_GET['op']=='editarticle' ) { ?>
<link type="text/css" href="public/js/themes/base/ui.all.css" rel="stylesheet" />
 	<script type="text/javascript" src="public/js/ui/ui.core.js"></script>
<script type="text/javascript" src="public/js/ui/ui.datepicker.js"></script>
<script type="text/javascript" src="public/js/ui/i18n/ui.datepicker-zh-CN.js"></script>
<script type="text/javascript" charset="utf-8" src="public/kindeditor/kindeditor.js"></script>
 
<div class="subtitle">添加修改文章</div>
 		<form method="post" action="<?=$baseurl?>&ac=article">
 <table class="maintable" border="0" cellspacing="0" cellpadding="0">

 	<tr>
<td width="10%" class="altbg1"><strong>文章名</strong></td><td><input type="text" name="article[title]" value="<?=$article['title']?>"  class="txtbox2"/></td>
</tr>
<tr>
<td  class="altbg1"><strong>短标题</strong></td><td><input type="text" name="article[shorttitle]" value="<?=$article['shorttitle']?>"  class="txtbox2"/>
类别:<select name="article[tid]">
<?php if(is_array($etypearr)) { foreach($etypearr as $val) { ?>
<option value="<?=$val['id']?>" <?php if($val['id']==$_GET['tid'] || $val['id']==$article['tid'] ) { ?>selected<?php } ?>><?=$val['typenbsp']?> <?php if($val['degree']==1) { ?><font color="#FF0000">*</font><?php } ?><?=$val['ctypename']?></option>
<?php } } ?>
</select>
自定义标记<select name="article[diyflag]">
<option value="0">不用</option>
<?php if(is_array($flaglist)) { foreach($flaglist as $val) { ?>
<option value="<?=$val['id']?>" <?php if($val['id']==$article['diyflag']) { ?>selected<?php } ?>><?=$val['flagname']?></option>
<?php } } ?>
</select></td>
</tr>
<tr>
                <td class="altbg1"><strong>缩略图</strong></td>
                <td><input type="text" name="article[litpic]" value="<?=$article['litpic']?>"   /><input type="button" value="上传图片" onclick="_openwindow('admincp.php?mod=admin&ac=upfile&op=addimg&pele=article[litpic]');"/></td>
           </tr>
   	<tr>
<td  class="altbg1"><strong>参数</strong></td><td>作者:<input type="text" name="article[author]" value="<?=$article['author']?>" size="15"/>发布时间:<input type="text" name="article[pubdt]" value="<?=$article['pubdt']?>" class="dtcl"/>*预发布的话请填写，默认和添加时间相同</td>
</tr>
<tr>
<td  class="altbg1"><strong>简短描述</strong></td><td><textarea name="article[description]" cols="100" rows="5"><?=$article['description']?></textarea></td>
</tr>
 		 
<tr>
<td  class="altbg1"><strong>文章内容</strong>分页标签#page#</td><td><textarea name="article[content]" cols="100"  rows="10"   id="contents1" style="width:800px;height:500px;visibility:hidden;"><?=$article['content']?></textarea></td>
</tr>
      		<tr>
<td  class="altbg1"><strong>自定义模板</strong></td><td><input type="text" name="article[tmpfile]" value="<?=$article['tmpfile']?>"  class="txtbox2"/>*路径从根目录开始例如template/default/d.htm
 </td>
</tr>
  	  </table>
   <center><input type="hidden"  name="artid" value="<?=$article['id']?>" />
<input type="submit" name="articlesubmit" value=" 提交 " class="btn" /></center>
      </form>
 <script type="text/javascript">
  
     KE.show({
        id : 'contents1' ,
//urlType : 'relative',
items : ['source',  'fullscreen', 'undo', 'redo', 'print', 'cut', 'copy', 'paste',
 		'title', 'fontname', 'fontsize', 'textcolor', 'bgcolor', 'bold',
'italic', 'underline', 'strikethrough', 'removeformat', 'image','indent', 'outdent', 
'flash', 'media', 'table','hello','about']
 	    });
    </script>
 <script language="javascript">
 	 $(function(){
   $(".dtcl").datepicker({changeMonth: true,changeYear: true});
 });

</script>
 
  <?php } ?>
 	</div>
</div>