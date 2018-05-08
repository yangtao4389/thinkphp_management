<?
!defined('IN_ADMIN') && exit('Access Denied');
$cookienowurl  = empty($_SCOOKIE['cookienowurl']) ? "admincp.php?ac=config" : $_SCOOKIE['cookienowurl'];
$_GET['op'] || $_GET['op'] = 'base';
if(submitcheck('configsubmit')){//网站设置提交
 	$setarr=array();
	foreach ($_POST['config'] as $variable => $value) {
		$ismix=0;
		if(is_array($variable)){//若是数组则是混合数据
			$value = serialize($variable);
			$ismix=1;
		}else{
			$value = trim($value);
		}
		$setarr[] = "('$variable', '$value','$ismix')";
	}
	if($setarr) {
		$_SGLOBAL['db']->query("REPLACE INTO ".tname('config')." (`variable`, `vardata`, `ismix`) VALUES ".implode(',', $setarr));
	}
	cache_config();//更新配置缓存
	showmessage('配置更新成功',$cookienowurl);
}


$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('config')."  ORDER BY variable");
$config = array();
while ($row = $_SGLOBAL['db']->fetch_array($query)) {
		$config[$row['variable']] = $row['ismix']==0 ? $row['vardata'] : @unserialize($row['vardata']);
}
ssetcookie('cookienowurl',$_SGLOBAL['operate_nowurl']);
$howcalled = "\$_SCONFIG['baseconfig'][变量名]";
?>