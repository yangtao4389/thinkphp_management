<?php
define('IN_ADMIN', TRUE);
include_once dirname(__FILE__).'/include/common.inc.php';
include_once WEB_ROOT.'./admin/include/function_admin.php';
$_GET['mod'] || $_GET['mod']='admin';//默认模块为admin
$mod = $_GET['mod']; 
$ac = isset($_GET['ac']) ? trim($_GET['ac']) : 'iframe';

if($_SGLOBAL['operate_nowurl']=='admincp.php'){header('Location: admincp.php?ac=iframe');exit;}

//后台初始化

if($_SCONFIG['cachetype']=='file'){//若是文件缓存设置缓存路径
	$cachepath = WEB_CACHEDIR."cache_data/";
	file_exists($cachepath) || mkdir($cachepath, 0777);
	$_SGLOBAL['cache']->setpath($cachepath);
}

$_TPL['tpldirbase']=getmodpath($mod)."admin/template/";//模板起始路径,若此不存在则在basedefault下查找
$_TPL['basedefault'] = "admin/template/";//默认查找路径
//////

if(submitcheck('loginsubmit')){//登录操作
	$username = !empty($_POST['username']) ? trim($_POST['username']) : showmessage('用户名不能为空');
	$password = !empty($_POST['password']) ? trim($_POST['password']) : showmessage('密码不能为空');
	if(!checkadminlogin($username,$password)){writeadminlog($username." ".$password."尝试登录失败"); showmessage('用户名或密码错误');}
	
	writeadminlog($username.'登录成功');
	
	showmessage("登录成功",'admincp.php?ac=iframe');
}
if($ac=='logout'){//退出
	clearcookie();
 	showmessage("退出成功","admincp.php?ac=login");
}
if($ac=='login'){ include_once template('login');exit; }//登录页面

if(!$_SGLOBAL['super_uid']){clearcookie();showmessage('您未登录','admincp.php?ac=login');}
if(!$_SGLOBAL['member']['baseinfo']['isadmin']){showmessage('您不是管理员!','admincp.php?ac=login');}

if(!checkadmin())showmessage('您没有权限进行此操作','javascript:;');



if($mod=='admin' && $ac=='iframe'){//ac为空即不调用任何文件则输出框架

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html><head>
<title>后台管理系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body style="margin: 0px" scroll="no">
<div style="position: absolute;top: 0px;left: 0px; z-index: 2;height: 65px;width: 100%">
<iframe frameborder="0" id="header" name="header" src="admincp.php?ac=main&op=menuheader" scrolling="no" style="height: 65px; visibility: inherit; width: 100%; z-index: 1;"></iframe><!--头部-->
</div>
<table border="0" cellPadding="0" cellSpacing="0" height="100%" width="100%" style="table-layout: fixed;">
<tr><td width="188" height="65"></td><td></td></tr>
<tr>
<td><iframe frameborder="0" id="menu" name="menu" src="admincp.php?ac=main&op=menu&tab=main" scrolling="auto" style="height: 100%; visibility: inherit; width: 100%; z-index: 1;overflow: auto; "></iframe><!--左侧菜单--></td>
<td><iframe frameborder="0" id="main" name="main" src="admincp.php?ac=main&op=main" scrolling="yes" style="height: 100%; visibility: inherit; width: 100%; z-index: 1;overflow: auto;"></iframe><!--右侧内容--></td>
</tr></table>
</body>
</html>
<?
exit;
}
if($mod=='admin'){
	$modpath = 'admin';
}else{//加载插件后台
    $modpath = getmodpath($mod)."admin";
}
if($_SGLOBAL['super_username']!='admin' && $_GET['ac']!='main'){
	//记录用户访问过的文件
	writeadminlog('访问过'.$_SGLOBAL['operate_nowurl']);
}
$incfile = WEB_ROOT."./$modpath/{$ac}_admin.php";
!file_exists($incfile) && exit("文件不存在".$incfile);
//自定义配置文件
$cfg_diyfile_path = WEB_ROOT."./$modpath/config.php";
if(file_exists($cfg_diyfile_path)) include_once($cfg_diyfile_path);
if(defined('NOHEADER_ADMIN')){//若不需要包含公共头尾
	include_once($incfile);	
	exit;
}
//查看是否有最新消息
$newadminmsg = $_SGLOBAL['db']->getall("select * from ".tname('adminmsg')." where isread=0 and touser='$_SGLOBAL[super_username]' order by id desc"); 
ob_start();
include template('header');//包含头部
include ($incfile);//包含php文件
if($newadminmsg){
  foreach($newadminmsg as $value) 
  	echo '<div>您有新消息:<a href="admincp.php?mod=admin&ac=admin&op=sendmsg&msgid='.$value['id'].'"><font color="#ff0000">'.$value['title'].'</font>&nbsp;'.$value['dttime'].'</a></div>';
}
include template($ac);//包含模板
include template('footer');//包含尾部
ob_end_flush();
?>