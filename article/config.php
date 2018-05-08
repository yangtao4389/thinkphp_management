<?
//文章发布模块
define('ART_ROOT',dirname(__FILE__));
include_once(ART_ROOT."/../include/common.inc.php");
//error_reporting(E_ALL);
include_once(ART_ROOT."/include/function_common.php");
$baseurl = 'admincp.php?mod=article';
$_SCONFIG['article']=array(
	'listdir'=>$_SCONFIG['baseconfig']['weburl'].'artlist/',
	'contentdir'=>$_SCONFIG['baseconfig']['weburl'].'content/',
);
?>