<?php 
!defined('IN_WEB') && exit('Access Denied');
include_once(ART_ROOT."/include/function_art.php");
$_GET['id'] || exit('no id pass');
$content = _getart_content($_GET['id'],$_GET['page']);
 
$typeinfo = $_SGLOBAL['db']->getone("select * from ".tname('article_type')." where id='$content[tid]'");
//分页
$navstr = _getartnav($typeinfo);
//获得内容页模板
$tmpfile = $content['tmpfile'] ? $content['tmpfile'] : $typeinfo['tmpcontent'];//模板文件
$tmpfile || $tmpfile = 'content.htm';
$tmpfile = str_replace(".htm",'',$tmpfile);


$dt =date("Y-m-d H:i:s");

 
include template($tmpfile);

?>