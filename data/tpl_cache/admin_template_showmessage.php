<?php if(!defined('IN_WEB')) exit('Access Denied');?><?php $_TPL['title']='提示消息'; ?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php if($_TPL['title'] ) { ?><?=$_TPL['title']?><?php } ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="x-ua-compatible" content="ie=7" />
<link rel="stylesheet" type="text/css" href="admin/images/admin.css">
<script type="text/javascript" src="public/js/jquery.js"></script>
<script type="text/javascript" src="admin/js/admin.js"></script>
</head>
<body> 

<link href="admin/images/login.css" rel="stylesheet" type="text/css" />
<div id="body">
 
    <table   width="600" border="0" cellpadding="8" cellspacing="0" class="login_table">
     <tr>
    <td   class="table_title" style="text-align:center">提示消息</td>
</tr>
    <tr><td align="center"><center>
<?=$message?>
</center>
</td></tr>
<tr><td align="center"><center>
<?php if($url_forward) { ?>
<a href="<?=$url_forward?>">如果页面没跳转请点击此链接...</a>
 	<?php } else { ?>
<a href="javascript:history.back(-1)">返回上一页</a> &nbsp;<script>setTimeout("history.go(-1);",<?=$second?>*1000);</script>
<?php } ?>
</center></td></tr>
    </table>       
    
</div>
<div id="footer">
<small></small><br />
<small></small>
</div>
</body>
</html>