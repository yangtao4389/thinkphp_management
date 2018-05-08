<?php if(!defined('IN_WEB')) exit('Access Denied');?><?php $_TPL['title']='管理后台登录'; ?>
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

<script language="JavaScript">
if(self.parent.frames.length != 0) {
self.parent.location=document.location;
}
function checkform(){
if($("#username").val()=='' || $("#password").val()==''){
alert('请填写用户名和密码');
return false;
}
return true;
}
</script>
<link href="admin/images/login.css" rel="stylesheet" type="text/css" />
<table width="600" border="0" cellpadding="8" cellspacing="0" class="login_table">
<form method="post" action="admincp.php" name="login" onsubmit="return checkform();">
<tr>
    <td colspan="2" class="table_title">管理后台登录</td>
</tr>
<tr>
    <td colspan="2" height="50"></td>
</tr>
<tr>
    <td width="200" align="right">登录名</td>
    <td width="*">
      <input type="text" name="username" id="username" style="width:150px;" />
     </td>
</tr>
<tr>
    <td align="right">密&nbsp;&nbsp;&nbsp;&nbsp;码</td>
    <td><input type="password" name="password" id="password" style="width:150px;" /></td>
</tr>
<tr>
    <td></td>
    <td><input type="submit" class="button" name="loginsubmit" value=" 登 录 " /></td>
</tr>
 
</form>
</table>

</html>