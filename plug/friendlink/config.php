<?
include_once(dirname(__FILE__)."/../config.php");
$pluginflag = 'friendlink';
$pluginarr = $_SCONFIG['plugins_config'][$pluginflag];
if($pluginarr['disable']==1)exit('插件已经禁用');
define('PLUS_ROOT',dirname(__FILE__));

$baseurl = 'admincp.php?mod='.$pluginarr['flag'];

?>