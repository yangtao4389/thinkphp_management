<?php
!defined('IN_WEB') && exit('Access Denied');

$_SGLOBAL['i'] = 0;
$_SGLOBAL['block_search'] = $_SGLOBAL['block_replace'] = array();
/**
 * @param $tplfile
 * @param $objfile
 * @return void
 */
function parse_template($tplfile,$objfile='') {
	global $_SGLOBAL;
	if(!$fp = @fopen($tplfile, 'r')) {
		die("Current template file '{$tplfile}' not found or have no access!");
	}
 	$template = fread($fp, filesize($tplfile));
	fclose($fp);
	$template =	parse_template_str($template);
	
	//write
	if(!@$fp = fopen($objfile, 'w')) {
		die("Template File '{$objfile}' not found or have no access!");
	}
 	flock($fp, 2);
	fwrite($fp, $template);
	fclose($fp);
}

/**
 * 解析字符串，返回解析后的正常html
 *@param $templae
 * @return string
 */
function parse_template_str($template=''){
	global $_SGLOBAL;
	
	//数据调用
 	$template = preg_replace("/\<\!\-\-\{datacallname:([^}]+)\}\-\-\>/ie", "datacallname('\\1')", $template);
	//子模板
	$template = preg_replace("/\<\!\-\-\{template\s+([a-z0-9_\/]+)\}\-\-\>/ie", "readtemplate('\\1')", $template);
	$template = preg_replace("/\<\!\-\-\{template\s+([a-z0-9_\/]+)\}\-\-\>/ie", "readtemplate('\\1')", $template);

 	//时间处理
 	$template = preg_replace("/\<\!\-\-\{date\((.+?)\)\}\-\-\>/ie", "datetags('\\1')", $template);
 	//PHP代码
	$template = preg_replace("/\<\!\-\-\{eval\s+(.+?)\s*\}\-\-\>/ies", "evaltags('\\1')", $template);

	//开始处理
	//变量
	$var_regexp = "((\\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)(\[[a-zA-Z0-9_\-\.\"\'\[\]\$\x7f-\xff]+\])*)";
	$template = preg_replace("/\<\!\-\-\{(.+?)\}\-\-\>/s", "{\\1}", $template);
	$template = preg_replace("/([\n\r]+)\t+/s", "\\1", $template);
	$template = preg_replace("/(\\\$[a-zA-Z0-9_\[\]\'\"\$\x7f-\xff]+)\.([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)/s", "\\1['\\2']", $template);
	$template = preg_replace("/\{(\\\$[a-zA-Z0-9_\[\]\'\"\$\.\x7f-\xff]+)\}/s", "<?=\\1?>", $template);
	$template = preg_replace("/$var_regexp/es", "addquote('<?=\\1?>')", $template);
	$template = preg_replace("/\<\?\=\<\?\=$var_regexp\?\>\?\>/es", "addquote('<?=\\1?>')", $template);
	//逻辑
	$template = preg_replace("/\{elseif\s+(.+?)\}/ies", "stripvtags('<?php } elseif(\\1) { ?>','')", $template);
	$template = preg_replace("/\{else\}/is", "<?php } else { ?>", $template);
	//循环
	for($i = 0; $i < 6; $i++) {
		$template = preg_replace("/\{loop\s+(\S+)\s+(\S+)\}(.+?)\{\/loop\}/ies", "stripvtags('<?php if(is_array(\\1)) { foreach(\\1 as \\2) { ?>','\\3<?php } } ?>')", $template);
		$template = preg_replace("/\{loop\s+(\S+)\s+(\S+)\s+(\S+)\}(.+?)\{\/loop\}/ies", "stripvtags('<?php if(is_array(\\1)) { foreach(\\1 as \\2 => \\3) { ?>','\\4<?php } } ?>')", $template);
		$template = preg_replace("/\{if\s+(.+?)\}(.+?)\{\/if\}/ies", "stripvtags('<?php if(\\1) { ?>','\\2<?php } ?>')", $template);
	}
	//常量
	$template = preg_replace("/\{([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\}/s", "<?=\\1?>", $template);
	
	//替换
	if(!empty($_SGLOBAL['block_search'])) {
		$template = str_replace($_SGLOBAL['block_search'], $_SGLOBAL['block_replace'], $template);
	}
	
	//换行
	$template = preg_replace("/ \?\>[\n\r]*\<\? /s", " ", $template);
	
	//附加处理
	$template = "<?php if(!defined('IN_WEB')) exit('Access Denied');?>$template";
	return $template;
}

function addquote($var) {
	return str_replace("\\\"", "\"", preg_replace("/\[([a-zA-Z0-9_\-\.\x7f-\xff]+)\]/s", "['\\1']", $var));
}

function striptagquotes($expr) {
	$expr = preg_replace("/\<\?\=(\\\$.+?)\?\>/s", "\\1", $expr);
	$expr = str_replace("\\\"", "\"", preg_replace("/\[\'([a-zA-Z0-9_\-\.\x7f-\xff]+)\'\]/s", "[\\1]", $expr));
	return $expr;
}

function evaltags($php) {
	global $_SGLOBAL;

	$_SGLOBAL['i']++;
	$search = "<!--EVAL_TAG_{$_SGLOBAL['i']}-->";
	$_SGLOBAL['block_search'][$_SGLOBAL['i']] = $search;
	$_SGLOBAL['block_replace'][$_SGLOBAL['i']] = "<?php ".stripvtags($php)." ?>";
	
	return $search;
}
function datetags($parameter) {
	global $_SGLOBAL;

	$_SGLOBAL['i']++;
	$search = "<!--DATE_TAG_{$_SGLOBAL['i']}-->";
	$_SGLOBAL['block_search'][$_SGLOBAL['i']] = $search;
	$_SGLOBAL['block_replace'][$_SGLOBAL['i']] = "<?php echo newdate($parameter); ?>";
	return $search;
}
 
function stripvtags($expr, $statement='') {
	$expr = str_replace("\\\"", "\"", preg_replace("/\<\?\=(\\\$.+?)\?\>/s", "\\1", $expr));
	$statement = str_replace("\\\"", "\"", $statement);
	return $expr.$statement;
}

function readtemplate($temp){
  //template($temp);
  $subtplpath = get_tpl_file($temp);
    if(!$fp = @fopen($subtplpath, 'r')) {
		die("sub template file '{$subtplpath}' not found or have no access!");
	}
 	$subtplcontent = fread($fp, filesize($subtplpath));
	fclose($fp);
  return $subtplcontent;
}

?>