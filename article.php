<?
//网站主
include_once(dirname(__FILE__)."/article/config.php");
$ac = $_GET['ac'] = $_GET['ac'] ? trim($_GET['ac']) : 'index';
$allowac = array('index','list','content');
in_array($ac, $allowac) || exit('非法访问');

$_TPL['tpldirbase']="article/template/default/";//模板起始路径,若此不存在则在basedefault下查找
$_TPL['basedefault'] = "template/default/";//默认查找路径
include_once("article/action/art_{$ac}.php");

?>