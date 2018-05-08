<?
include_once dirname(__FILE__).'/member/member.config.php';
$_GET['ac'] || $_GET['ac']='weberreg';
$ac = trim($_GET['ac']);
$allowac = array('weberreg','lostpwd','login','help','content','avatar');
in_array($ac, $allowac) || showmessage('非法请求');

include_once("member/action/member_{$ac}.php");
include template($ac);
?>