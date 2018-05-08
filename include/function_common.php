<?
!defined('IN_WEB') && exit('Access Denied');

//获取任何一天本周的开始和结束时间
function getWeekRang($day){
	$dayt = trim(date("l",strtotime($day)));
	$rarr=array();
	if($dayt=='Monday'){
		$rarr['startday'] = $day;
		$rarr['endday'] = date("Y-m-d",strtotime("+6days",strtotime($day)));
	}else{
		$rarr['startday'] = date("Y-m-d", strtotime("last Monday",strtotime($day)) );
		$rarr['endday'] = date("Y-m-d", strtotime('Sunday',strtotime($day)) );
	}
	return $rarr;
}


function writeadminlog($msg=''){
	global $_SCONFIG,$_SGLOBAL;
	$logpath =WEB_CACHEDIR."adminlog/"; 
	is_dir($logpath) || mkdir($logpath, 0777);
	error_log(date("Y-m-d H:i:s")."	".$_SGLOBAL['super_username']."	".$msg."	\r\n", 3, $logpath.date("Ymd").".txt");
}
//*****template**************

/**
 * 数据调用缓存
 * @param $flagname
 * @return datatemplate
 */
function datacallname($flagname){//模板函数
	global $_SGLOBAL;
	$data = getdatacall($flagname);
 	return $data['datatmp'];
}

/**
 * 获得缓存数据
 * @param $flagname
 * @return arr
 */
function getdatacall($flagname){
	global $_SGLOBAL;
	if(!$data = $_SGLOBAL['cache']->fetch($flagname)){
		$done = $_SGLOBAL['db']->getone("select dsql,cachetime,datatmp from ".tname('datacall_list')." where flagname='$flagname'");
		$data['data'] = $_SGLOBAL['db']->getall($done['dsql']);
		$data['datatmp'] = $done['datatmp'];
		$_SGLOBAL['cache']->store($flagname,$data,$done['cachetime']);
	}
	$_SGLOBAL['datacall'][$flagname] = $data['data'];
	return $data;

}
/**
 * 获得随机字符串
 * @param $len
 * @return string
 */
function genrandstr($len){
		$chars = array(
			"a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
			"l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
			"w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",
			"H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
			"S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",
			"3", "4", "5", "6", "7", "8", "9"
		);
		$charsLen = count($chars) - 1;
		shuffle($chars);
		$output = "";
		for ($i=0; $i<$len; $i++){
			$output .= $chars[mt_rand(0, $charsLen)];
		}
		return $output;
}

/**
 * 格式化时间为 xx秒前
 * @param $date
 * @param $format y-m-d
 * @param $dnum
 * @param $dunit 个月
 * @return unknown_type
 */
function newdate($date, $format='Y-m-d', $dnum=2, $dunit='个月') {
    $timestamp = time();
    $date == 'NOW'||!$date ? $timestamp : $date;
    $date = is_numeric($date) ? $date : (!$date ? $timestamp : strtotime($date));
    $date = ($date == -1 || !$date) ? $timestamp : $date;
    if($format != 'w2style') {
        return date($format, $date);
    } else {
        $tm = $timestamp - $date;
        $num = 0;
        if($tm < 60) {
            $num = $tm;
            $unit = '秒钟';
        } elseif($tm < 3600) {
            $num = floor($tm / 60);
            $unit = '分钟';
        } elseif($tm < 3600*24) {
            $num = floor($tm / 3600);
            $unit = '小时';
        } elseif($tm < 3600*24*30) {
            $num = floor($tm / (3600*24));
            $unit = '天';
        } elseif($tm < 3600*24*30*365) {
            $num = floor($tm / (3600*24*30));
            $unit = '个月';
        }
        if($dnum<=$num && $dunit==$unit) {
            return date('Y-m-d H:i', $date);
        }
        return $num > 0 ? $num.$unit.'前' : date('Y-m-d', $date);
    }
}
//*****************end template*****

/**
 * 删除数据缓存
 * @param $key
 * @return void
 */
function del_datacall_cache($key){
	global $_SGLOBAL;
	$_SGLOBAL['cache']->delete($key);
}

/**
 * 批量运行sql
 * @param $sql
 * @return void
 */
function runquery($sql) {
	global $_SGLOBAL,$_SCONFIG; 
 	$sql = str_replace('#@__', $_SCONFIG['tablepre'], $sql);
	$ret = array();
	$sqlarr = explode(";",$sql);
	foreach($sqlarr as $query){
		if(empty($query))continue;
		$_SGLOBAL['db']->query($query);
	}
}

/**
 * 转化html为 javascript
 * @param $html
 * @return unknown_type
 */
function html2js($html=''){
	$html = str_replace('"', '\"',$html);
	$html = str_replace("\r", "\\r",$html);
	$html = str_replace("\n", "\\n",$html);
	$html = "<!--\r\ndocument.write(\"{$html}\");\r\n-->\r\n";
	return $html;
}

/**
 * 返回当前url
 * @return string
 */
function getnowurl(){
	if(!isset($_SERVER['REQUEST_URI'])) {//获得当前url   
		$_SERVER['REQUEST_URI'] = $_SERVER['PHP_SELF'];
		if(isset($_SERVER['QUERY_STRING'])) $_SERVER['REQUEST_URI'] .= '?'.$_SERVER['QUERY_STRING'];
	}
	return $_SERVER['REQUEST_URI'];
}

 

/**
 * 写入文件
 * @param $filename
 * @param $writetext
 * @param $openmod
 * @return bool
 */
function swritefile($filename, $writetext, $openmod='w') {
	if(@$fp = fopen($filename, $openmod)) {
		flock($fp, 2);
		fwrite($fp, $writetext);
		fclose($fp);
		return true;
	} 
 	return false;
 
}

/**
 * 读取文件
 * @param $fname
 * @return string
 */
function sreadfile($fname=''){
	$fp = fopen($fname,'r');
	$content = fread($fp,filesize($fname));
	fclose($fp);
	return $content;
}




/**
 * cookie设置
 * @param $var
 * @param $value
 * @param $life
 * @return void
 */
function ssetcookie($var, $value, $life=0) {
	global $_SCONFIG,$timestamp;
 	setcookie($_SCONFIG['cookiepre'].$var, $value, $life?($timestamp+$life):0, "/");
}

/**
 * 清空cookie,delete session,webaut='',super_uid=0,super_username='',member=array()
 * @return void
 */
function clearcookie() {
	global $_SGLOBAL;
 	ob_clean();
    $_SGLOBAL['db']->query("delete from ".tname('session')." where uid='".$_SGLOBAL['super_uid']."'");
	ssetcookie('webauth', '', -86400 * 365);
  	$_SGLOBAL['super_uid'] = 0;
	$_SGLOBAL['super_username'] = '';
	$_SGLOBAL['member'] = array();
	
}

/**
 * 字符串截取eg:utf8Substr('中国abc的',0,3);中国a
 * @param $str
 * @param $from
 * @param $len
 * @return string
 */
function utf8substr($str, $from, $len){ 
    return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'. 
                       '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s', 
                       '$1',$str); 
}
 

/**
 * 获取到表名
 * @param $name
 * @return string
 */
function tname($name) {
	global $_SCONFIG;
	return $_SCONFIG['tablepre'].$name;
}

//SQL ADDSLASHES
function saddslashes($string) {
	if(is_array($string)) {
		foreach($string as $key => $val)$string[$key] = saddslashes($val);
 	} else { $string = addslashes(trim($string));	}
	return $string;
}

/**
 * 过滤危险sql代码
 * @param $string
 * @return array
 */
function strip_sql($string) {
    global $pattern_arr, $replace_arr;
    return is_array($string) ? array_map('strip_sql', $string) : preg_replace($pattern_arr, $replace_arr, $string);
}

/**
 * 取消HTML代码
 * @param $string
 * @return unknown_type
 */
function shtmlspecialchars($string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = shtmlspecialchars($val);
		}
	} else {
		$string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1',
			str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string));
	}
	return $string;
}


/**
 * 判断提交是否正确
 * @param $var
 * @return bool
 */
function submitcheck($var) {
	if(!empty($_POST[$var]) && $_SERVER['REQUEST_METHOD'] == 'POST') {
		if((empty($_SERVER['HTTP_REFERER']) || preg_replace("/https?:\/\/([^\:\/]+).*/i", "\\1", $_SERVER['HTTP_REFERER']) == preg_replace("/([^\:]+).*/", "\\1", $_SERVER['HTTP_HOST']))) {
			return true;
		} else {
			showmessage('submit_invalid');
		}
	} else {
		return false;
	}
}


/**
 * 数据库连接
 * @return void
 */
function dbconnect() {
	global $_SGLOBAL,$_SCONFIG;
	include_once(WEB_ROOT.'./include/mysql.class.php');
 	if(empty($_SGLOBAL['db'])) { 
		$_SGLOBAL['db'] = new mysql();
		$_SGLOBAL['db']->charset = $_SCONFIG['charset'];
		$_SGLOBAL['db']->connect($_SCONFIG['dbhost'], $_SCONFIG['dbuser'], $_SCONFIG['dbpw'], $_SCONFIG['dbname']);
		if($_SCONFIG['db_ro'])$_SGLOBAL['db']->set_ro_list($_SCONFIG['db_ro']);//只读服务器
	}
} 

/**
 * 创建缓存对象
 * @return void
 */
function datacache(){
	global $_SCONFIG,$_SGLOBAL;
 	if(empty($_SGLOBAL['cache'])) {
		if($_SCONFIG['cachetype']=='file'){
			 $_SGLOBAL['cache'] = new Cache_File();
			
		}elseif($_SCONFIG['cachetype']=='memcache'){
			$_SGLOBAL['cache'] = getmem_obj();
 		}//end elseif
	}//end empty
}
function getmem_obj(){
	global $_SCONFIG,$_SGLOBAL;
	$_scache = new Cache_MemCache();
	foreach($_SCONFIG['memserver'] as $server){
		if(!isset($server[1]))$server[1]=11211;
		if(!isset($server[2]))$server[1]=10;
		$_scache->addServer($server[0],$server[1],$server[2]); 
	}
	return $_scache;
}
/**
 * 获取目录下文件列表
 * @param $dir
 * @param $extarr
 * @return array
 */
function sreaddir($dir, $extarr=array()) {
	$dirs = array();
	if($dh = opendir($dir)) {
		while (($file = readdir($dh)) !== false) {
			if(!empty($extarr) && is_array($extarr)) {
				if(in_array(strtolower(fileext($file)), $extarr)) {
					$dirs[] = $file;
				}
			} else if($file != '.' && $file != '..') {
				$dirs[] = $file;
			}
		}
		closedir($dh);
	}
	return $dirs;
}


/**
 * 添加数据
 * @param $tablename
 * @param $insertsqlarr
 * @param $returnid
 * @param $replace
 * @param $silent
 * @return void or lastid
 */
function inserttable($tablename, $insertsqlarr, $returnid=0, $replace = false, $silent=0) {
	global $_SGLOBAL;

	$insertkeysql = $insertvaluesql = $comma = '';
	foreach ($insertsqlarr as $insert_key => $insert_value) {
		$insertkeysql .= $comma.'`'.$insert_key.'`';
		$insertvaluesql .= $comma.'\''.$insert_value.'\'';
		$comma = ', ';
	}
	$method = $replace?'REPLACE':'INSERT';
	$_SGLOBAL['db']->query($method.' INTO '.tname($tablename).' ('.$insertkeysql.') VALUES ('.$insertvaluesql.')', $silent?'SILENT':'');
	if($returnid && !$replace) {
		return $_SGLOBAL['db']->insert_id();
	}
}


/**
 * 更新数据
 * @param $tablename
 * @param $setsqlarr
 * @param $wheresqlarr
 * @param $silent
 * @return void
 */
function updatetable($tablename, $setsqlarr, $wheresqlarr, $silent=0) {
	global $_SGLOBAL;

	$setsql = $comma = '';
	foreach ($setsqlarr as $set_key => $set_value) {
		$setsql .= $comma.'`'.$set_key.'`'.'=\''.$set_value.'\'';
		$comma = ', ';
	}
	$where = $comma = '';
	if(empty($wheresqlarr)) {
		$where = '1';
	} elseif(is_array($wheresqlarr)) {
		foreach ($wheresqlarr as $key => $value) {
			$where .= $comma.'`'.$key.'`'.'=\''.$value.'\'';
			$comma = ' AND ';
		}
	} else {
		$where = $wheresqlarr;
	}
	$_SGLOBAL['db']->query('UPDATE '.tname($tablename).' SET '.$setsql.' WHERE '.$where, $silent?'SILENT':'');
}



/**
 * 语言替换
 * @param $text
 * @param $vars
 * @return string
 */
function lang_replace($text, $vars) {
	if($vars) {
		foreach ($vars as $k => $v) {
			$rk = $k + 1;
			$text = str_replace('\\'.$rk, $v, $text);
		}
	}
	return $text;
}

/**
 * 对话框
 * @param $msgkey
 * @param $url_forward
 * @param $second
 * @param $values
 * @return void
 */
function showmessage($msgkey, $url_forward='', $second=2, $values=array()) {
	global $_SGLOBAL;
	ob_clean();
  
	//语言
	//include_once(S_ROOT.'./language/lang_showmessage.php');
	if(isset($_SGLOBAL['msglang'][$msgkey])) {
		$message = lang_replace($_SGLOBAL['msglang'][$msgkey], $values);
	} else {
		$message = $msgkey;
	}
 	 
	//显示
	if(empty($_SGLOBAL['inajax']) && $url_forward && empty($second)) {
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: $url_forward");
	} else {
		if($_SGLOBAL['inajax']) {
			if($url_forward) {
				$message = "<a href=\"$url_forward\">$message</a><ajaxok>";
			}
 			echo $message;
			ob_out();
		} else {
			if($url_forward) {
				if(preg_match('/script:/i',$url_forward)){
					$message = "<a href='$url_forward'>$message</a>";
				}else{
					$message = "<a href=\"$url_forward\">$message</a><script>setTimeout(\"window.location.href ='$url_forward';\", ".($second*1000).");</script>";
				}
			}
			include template('showmessage');
		}
	}
	exit();
}


/**
 * 获得ip format=1 返回去除点的数字
 * @param $format
 * @return ip or numlist
 */
function getonlineip($format=0) {
	global $_SGLOBAL;
 	if(empty($_SGLOBAL['onlineip'])) {
		if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
			$onlineip = getenv('HTTP_CLIENT_IP');
		} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
			$onlineip = getenv('HTTP_X_FORWARDED_FOR');
		} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
			$onlineip = getenv('REMOTE_ADDR');
		} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
			$onlineip = $_SERVER['REMOTE_ADDR'];
		}
		preg_match("/[\d\.]{7,15}/", $onlineip, $onlineipmatches);
		$_SGLOBAL['onlineip'] = $onlineipmatches[0] ? $onlineipmatches[0] : 'unknown';
	}
	if($format) {//把ip组装成数字
		$ips = explode('.', $_SGLOBAL['onlineip']);
		for($i=0;$i<3;$i++) {
			$ips[$i] = intval($ips[$i]);
		}
		return sprintf('%03d%03d%03d', $ips[0], $ips[1], $ips[2]);
	} else {
		return $_SGLOBAL['onlineip'];
	}
}


/**
 * 重写file_get_contents
 * @param $url
 * @return string
 */
function file_get_contents_diy($url=''){
	 	if(!$url)return;
	 	$cnt=0;$str='';
 		while($cnt < 3 && ($str=@file_get_contents($url))===FALSE)
		 $cnt++;
		 return $str;
}


/**
 *
 *获得模板文件的路径
 * @param $tpl
 * @return string
 */
function get_tpl_file($tpl){
	global $_TPL;
    $tplfile 			   =   WEB_TMPDIR.$_TPL['defaulttmp']."/$tpl.htm";
	!file_exists($tplfile) &&  $tplfile = WEB_TMPDIR."default/$tpl.htm";
    //处理自定义路径模板
	$_TPL['tpldirbase']    &&  $tplfile = WEB_ROOT.$_TPL['tpldirbase']."$tpl.htm";
	if(!file_exists($tplfile)){
		if($_TPL['basedefault']) $tplfile = WEB_ROOT.$_TPL['basedefault']."$tpl.htm";
	}
	return $tplfile;
}

/**
 * 模板解析函数
 *$_TPL['defaulttmp']='2366';
 *template('index')=>/template/default/index.htm
 *$_TPL['tpldirbase']='admin/template/';
 *template('index')=>/admin/template/index.htm
 * @param $tpl
 * @return string
 */
function template($tpl='') {
	$tplfile = get_tpl_file($tpl); 
 	$cachefname = str_replace(array(WEB_ROOT,'.htm','/'),array('','','_'),$tplfile);
 	$objfile = WEB_CACHEDIR."tpl_cache/$cachefname.php";//缓存文件
	if(!file_exists($objfile) || (@filemtime($tplfile) > @filemtime($objfile)) ) {
         parse_template($tplfile, $objfile);
    }
 	return $objfile;
}


/**
 * 分页函数
 * @param $num
 * @param $perpage
 * @param $curpage
 * @param $mpurl
 * @param $ajaxdiv
 * @param $todiv
 * @return string
 */
function multi($num, $perpage, $curpage, $mpurl,  $ajaxdiv='', $todiv='') {
	global $_SGLOBAL;
 	if(empty($ajaxdiv) && $_SGLOBAL['inajax']){
		$ajaxdiv = $_GET['ajaxdiv'];
	}
	$page = 5;
	if($_SGLOBAL['showpage']) $page = $_SGLOBAL['showpage'];
	
 	$multipage = '';
	$mpurl .= strpos($mpurl, '?') ? '&' : '?';
	$realpages = 1;
	if($num > $perpage) {
		$offset = 2;
	    $realpages = @ceil($num / $perpage);
 		$pages = $_SCONFIG['maxpage'] && $_SCONFIG['maxpage'] < $realpages ? $_SCONFIG['maxpage'] : $realpages;
		if($page > $pages) {
			$from = 1;
			$to = $pages;
		} else {
			$from = $curpage - $offset;
			$to = $from + $page - 1;
			if($from < 1) {
				$to = $curpage + 1 - $from;
				$from = 1;
				if($to - $from < $page) {
					$to = $page;
				}
			} elseif($to > $pages) {
				$from = $pages - $page + 1;
				$to = $pages;
			}
		}
		$multipage = '';
		$urlplus = $todiv?"#$todiv":'';
		if($curpage - $offset > 1 && $pages > $page) {
			$multipage .= "<a ";
			if($_SGLOBAL['inajax']) {
				$multipage .= "href=\"javascript:;\" onclick=\"ajaxget('{$mpurl}page=1&ajaxdiv=$ajaxdiv', '$ajaxdiv')\"";
			} else {
				$multipage .= "href=\"{$mpurl}page=1{$urlplus}\"";
			}
			$multipage .= " class=\"first\">1 ...</a>";
		}
		if($curpage > 1) {
			$multipage .= "<a ";
			if($_SGLOBAL['inajax']) {
				$multipage .= "href=\"javascript:;\" onclick=\"ajaxget('{$mpurl}page=".($curpage-1)."&ajaxdiv=$ajaxdiv', '$ajaxdiv')\"";
			} else {
				$multipage .= "href=\"{$mpurl}page=".($curpage-1)."$urlplus\"";
			}
			$multipage .= " class=\"prev\">&lsaquo;&lsaquo;</a>";
		}
		for($i = $from; $i <= $to; $i++) {
			if($i == $curpage) {
				$multipage .= '<strong>'.$i.'</strong>';
			} else {
				$multipage .= "<a ";
				if($_SGLOBAL['inajax']) {
					$multipage .= "href=\"javascript:;\" onclick=\"ajaxget('{$mpurl}page=$i&ajaxdiv=$ajaxdiv', '$ajaxdiv')\"";
				} else {
					$multipage .= "href=\"{$mpurl}page=$i{$urlplus}\"";
				}
				$multipage .= ">$i</a>";
			}
		}
		if($curpage < $pages) {
			$multipage .= "<a ";
			if($_SGLOBAL['inajax']) {
				$multipage .= "href=\"javascript:;\" onclick=\"ajaxget('{$mpurl}page=".($curpage+1)."&ajaxdiv=$ajaxdiv', '$ajaxdiv')\"";
			} else {
				$multipage .= "href=\"{$mpurl}page=".($curpage+1)."{$urlplus}\"";
			}
			$multipage .= " class=\"next\">&rsaquo;&rsaquo;</a>";
		}
		if($to < $pages) {
			$multipage .= "<a ";
			if($_SGLOBAL['inajax']) {
				$multipage .= "href=\"javascript:;\" onclick=\"ajaxget('{$mpurl}page=$pages&ajaxdiv=$ajaxdiv', '$ajaxdiv')\"";
			} else {
				$multipage .= "href=\"{$mpurl}page=$pages{$urlplus}\"";
			}
			$multipage .= " class=\"last\">... $realpages</a>";
		}
		if($multipage) {
			$multipage = '<em>&nbsp;'.$num.'&nbsp;</em>'.$multipage;
		}
	}
	return $multipage;
}

/**
 *  远程打开URL
 *  @param string $url		打开的url，　如 http://www.baidu.com/123.htm
 *  @param int $limit		取返回的数据的长度
 *  @param string $post		要发送的 POST 数据，如uid=1&password=1234
 *  @param string $cookie	要模拟的 COOKIE 数据，如uid=123&auth=a2323sd2323
 *  @param bool $bysocket	TRUE/FALSE 是否通过SOCKET打开
 *  @param string $ip		IP地址
 *  @param int $timeout		连接超时时间
 *  @param bool $block		是否为阻塞模式
 *  @return			取到的字符串
 */
function web_fopen($url, $limit = 0, $post = '', $cookie = '', $bysocket = FALSE, $ip = '', $timeout = 15, $block = TRUE) {
	$return = '';
	$matches = parse_url($url);
	!isset($matches['host']) && $matches['host'] = '';
	!isset($matches['path']) && $matches['path'] = '';
	!isset($matches['query']) && $matches['query'] = '';
	!isset($matches['port']) && $matches['port'] = '';
	$host = $matches['host'];
	$path = $matches['path'] ? $matches['path'].($matches['query'] ? '?'.$matches['query'] : '') : '/';
	$port = !empty($matches['port']) ? $matches['port'] : 80;
	if($post) {
		$out = "POST $path HTTP/1.0\r\n";
		$out .= "Accept: */*\r\n";
		//$out .= "Referer: $boardurl\r\n";
		$out .= "Accept-Language: zh-cn\r\n";
		$out .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
		$out .= "Host: $host\r\n";
		$out .= 'Content-Length: '.strlen($post)."\r\n";
		$out .= "Connection: Close\r\n";
		$out .= "Cache-Control: no-cache\r\n";
		$out .= "Cookie: $cookie\r\n\r\n";
		$out .= $post;
	} else {
		$out = "GET $path HTTP/1.0\r\n";
		$out .= "Accept: */*\r\n";
		//$out .= "Referer: $boardurl\r\n";
		$out .= "Accept-Language: zh-cn\r\n";
		$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
		$out .= "Host: $host\r\n";
		$out .= "Connection: Close\r\n";
		$out .= "Cookie: $cookie\r\n\r\n";
	}
	$fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
	if(!$fp) {
		return '';//note $errstr : $errno \r\n
	} else {
		stream_set_blocking($fp, $block);
		stream_set_timeout($fp, $timeout);
		@fwrite($fp, $out);
		$status = stream_get_meta_data($fp);
		if(!$status['timed_out']) {
			while (!feof($fp)) {
				if(($header = @fgets($fp)) && ($header == "\r\n" ||  $header == "\n")) {
					break;
				}
			}

			$stop = false;
			while(!feof($fp) && !$stop) {
				$data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
				$return .= $data;
				if($limit) {
					$limit -= strlen($data);
					$stop = $limit <= 0;
				}
			}
		}
		@fclose($fp);
		return $return;
	}
}

/**
 * 字符串加密解密
 * @param $string
 * @param $operation
 * @param $key
 * @param $expiry
 * @return string
 */
function web_authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {

	$ckey_length = 4;	//note 随机密钥长度 取值 0-32;
				//note 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
				//note 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
				//note 当此值为 0 时，则不产生随机密钥

	$key = md5($key ? $key : 'webkeyfds');
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);

	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);

	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}

	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}

/**
 * 循环创建目录
 *
 * @param string $dir
 * @param integer $mode
 * @return bool
 */
function mk_dir($dir, $mode = 0755)
{
    if (is_dir($dir) || @mkdir($dir, $mode))
        return true;
    if (!mk_dir(dirname($dir), $mode))
        return false;
    return @mkdir($dir, $mode);
}
?>