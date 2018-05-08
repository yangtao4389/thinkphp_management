<?
!defined('IN_ADMIN') && exit('Access Denied');
$sqlbatch = <<<EOT
DROP TABLE `#@__plug_friendlink`;
EOT;
runquery($sqlbatch);


?>