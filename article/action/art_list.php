<?
!defined('IN_WEB') && exit('Access Denied');
$_GET['tid'] || $_GET['tid']=1;
$perpage = $typeinfo['perpage']>0 ? $typeinfo['perpage'] : 1;//每页多少条
$mpurl = 'article.php?ac=list&tid='.$_GET['tid'];


$page = empty($_GET['page'])?1:intval($_GET['page']);
if($page<1) $page = 1;
$start = ($page-1)*$perpage;

$tidlist = getchildidlist($_GET['tid']);
$cond = " and tid in($tidlist)";
$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select count(*) from ".tname('article_content')."  where 1 ".$cond),0);
$artarr = $_SGLOBAL['db']->getall("select * from ".tname('article_content')."  where 1 ".$cond." order by pubdt desc limit  $start,$perpage");

//分页字符串
$multi = multi($count, $perpage, $page, $mpurl);
//不是预览则替换成伪静态
if($_GET['preview']!=1)
$multi = preg_replace("/article\.php\?ac=list&tid=([0-9]+)&page=([0-9]+)/i","list_$1_$2.html",$multi);

$typeinfo =  $_SGLOBAL['db']->getone("select * from ".tname('article_type')."  where id='$_GET[tid]'");
$navstr = _getartnav($typeinfo);
//包含对应的模板
$tmpfile = $typeinfo['isindexpage']==1 ? $typeinfo['tmpindex'] : $typeinfo['tmplist'];
$tmpfile || $tmpfile='list.htm';
$tmpfile = str_replace(".htm",'',$tmpfile);
include template($tmpfile);
?>