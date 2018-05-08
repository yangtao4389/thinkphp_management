<?php
!defined('IN_WEB') && exit('Access Denied');
!file_exists(WEB_CACHEDIR."./cache_data/") && mkdir(WEB_CACHEDIR."./cache_data/",0777);
//配置缓存 
function cache_config() {
	global $_SGLOBAL;
 	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('config')."  ORDER BY variable");
    $result = array();
    while ($config = $_SGLOBAL['db']->fetch_array($query)) {
			$result[$config['variable']] = $config['ismix']==0 ? $config['vardata'] : @unserialize($config['vardata']);
    }
	write_cache('config',"_SCONFIG['baseconfig']" ,$result);
}
 
//更新插件缓存
function cache_pluginsconfig() {
    $result = getmodulelist(2);
 	write_cache('plugins_config',"_SCONFIG['plugins_config']", $result);
}
//模块配置缓存
function cache_modulesconfig(){
	$result = getmodulelist(1);
 	write_cache('modules_config',"_SCONFIG['modules_config']", $result);
}
//获得插件或模块缓存
function getmodulelist($moduletype=0){
	global $_SGLOBAL;
	$result = array();
    $query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('modules')." WHERE disable=0 and moduletype='$moduletype'");
    while($row = $_SGLOBAL['db']->fetch_array($query)) {
		if($row['moduleconfig'])$row['moduleconfig'] = unserialize($row['moduleconfig']);
		if($row['menuconfig'])$row['menuconfig'] = unserialize($row['menuconfig']);
        $result[$row['flag']] = $row;
    }
	return $result;
}
/*********更新缓存*******************/
//更新模板文件
function update_tpl_cache() {
	$dir = WEB_CACHEDIR.'./tpl_cache';
	$files = sreaddir($dir);
	foreach ($files as $file) {
		@unlink($dir.'/'.$file);
	}
}
 
 
//更新数据调用缓存
function update_datacall_cache(){
	global $_SGLOBAL;
	$datacallarr = $_SGLOBAL['db']->getall('select flagname from '.tname('datacall_list')." order by id asc");
	foreach($datacallarr as $value){
		del_datacall_cache($value['flagname']);
	}
}
/************更新缓存************/
//创建缓存
function write_cache($name, $var, $values){
    $cachefile = WEB_CACHEDIR . './cache_data/cachedata_' . $name . '.php';
    $cachetext = "<?php\r\n" . "if(!defined('IN_WEB')) exit('Access Denied');\r\n" .
        '$' . $var . '=' . arrayeval($values) . "\r\n?>";
		
    if (!swritefile($cachefile, $cachetext)) {
        exit("File: $cachefile write error.");
    }
}
//数组转换成字串
function arrayeval($array, $level = 0) {
	$space = '';
	for($i = 0; $i <= $level; $i++) {
		$space .= "\t";
	}
	$evaluate = "Array\n$space(\n";
	$comma = $space;
	foreach($array as $key => $val) {
		$key = is_string($key) ? '\''.addcslashes($key, '\'\\').'\'' : $key;
		$val = !is_array($val) && (!preg_match("/^\-?\d+$/", $val) || strlen($val) > 12 || substr($val, 0, 1)=='0') ? '\''.addcslashes($val, '\'\\').'\'' : $val;
		if(is_array($val)) {
			$evaluate .= "$comma$key => ".arrayeval($val, $level + 1);
		} else {
			$evaluate .= "$comma$key => $val";
		}
		$comma = ",\n$space";
	}
	$evaluate .= "\n$space)";
	return $evaluate;
}
?>