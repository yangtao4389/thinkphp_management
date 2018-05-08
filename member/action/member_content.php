<?
!defined('IN_WEB') && exit('Access Denied');
$_GET['id']>0 || showmessage('无效id');
$contentarr = $_SGLOBAL['db']->getone("select * from ".tname('plug_board')." where id='".intval($_GET['id'])."'");
if(!$contentarr)showmessage('文章不存在');

?>