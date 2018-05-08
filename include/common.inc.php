<?
//初始化
define('DEBUG', true);
define('IN_WEB', TRUE);
define('WEB_ROOT', substr(dirname(__FILE__), 0, -7));
define('WEB_TMPDIR', WEB_ROOT.'template/');
define('WEB_CACHEDIR', WEB_ROOT.'data/');

DEBUG?error_reporting(7):error_reporting(0);
set_magic_quotes_runtime(0);

$_SGLOBAL=$_TPL=$_SCONFIG=$_SCOOKIE=array();
$timestamp =$_SGLOBAL['timestamp']= time();

include_once(WEB_ROOT."./config.php");
include_once(WEB_ROOT.'./include/function_common.php');//公共函数
include_once WEB_ROOT.'./include/function_template.php';
include_once(WEB_ROOT."./include/function_member.php");//用户登录
include_once(WEB_ROOT."./include/function_cache.php");//缓存函数
//GPC过滤
$magic_quote = get_magic_quotes_gpc();
if(empty($magic_quote)) {
	$_GET = saddslashes($_GET);
	$_POST = saddslashes($_POST);
}

if(!defined('IN_ADMIN')) {//前台程序过滤
    $pattern_arr = array("/ union /i", "/ select /i", "/ update /i", "/ outfile /i", "/ or /i");
    $replace_arr = array('&nbsp;union&nbsp;', '&nbsp;select&nbsp;', '&nbsp;update&nbsp;',
        '&nbsp;outfile&nbsp;', '&nbsp;or&nbsp;');
    $_POST = strip_sql($_POST);
    $_GET = strip_sql($_GET);
    $_COOKIE = strip_sql($_COOKIE);
    unset($pattern_arr, $replace_arr);
}
$prelength = strlen($_SCONFIG['cookiepre']);
foreach($_COOKIE as $key => $val) {//读出cookie
	if(substr($key, 0, $prelength) == $_SCONFIG['cookiepre']) {
		$_SCOOKIE[(substr($key, $prelength))] = empty($magic_quote) ? saddslashes($val) : $val;
	}
}

//初始化用户信息 
$onlineip = getonlineip();
$_SGLOBAL['operate_nowurl'] = getnowurl();//当前操作url
defined('NO_DBCONNECT') || dbconnect();//链接数据库

include_once(WEB_ROOT."./include/cache.class.php");
datacache();//创建一般缓存对象或memcache缓存对象

checklogin();//判断用户登录
if($_SGLOBAL['super_uid']) getmemberinfo($_SGLOBAL['super_uid']);//若登录用户获取登录信息
//加载配置缓存
$cfg_base_config=WEB_CACHEDIR."./cache_data/cachedata_config.php";
if(!file_exists($cfg_base_config))cache_config();
include_once($cfg_base_config);
if($_SCONFIG['baseconfig'])$_SCONFIG = array_merge($_SCONFIG, $_SCONFIG['baseconfig']);//合并配置

//加载插件或模块缓存
$cfg_module_path = WEB_CACHEDIR."./cache_data/cachedata_modules_config.php";
$cfg_plugin_path = WEB_CACHEDIR."./cache_data/cachedata_plugins_config.php";
if(!file_exists($cfg_module_path))cache_modulesconfig();
if(!file_exists($cfg_plugin_path))cache_pluginsconfig();
include_once($cfg_module_path);
include_once($cfg_plugin_path);
if(isset($_SCONFIG['haveadtype']))$_SCONFIG['haveadtype'] = explode(',',$_SCONFIG['haveadtype']);
define('UC_CONNECT', 'mysql');
define('UC_DBHOST', 'localhost');
define('UC_DBUSER', 'root');
define('UC_DBPW', '000000');
define('UC_DBNAME', 'ucenterdc');
define('UC_DBCHARSET', 'utf8');
define('UC_DBTABLEPRE', '`ucenterdc`.uc_');
define('UC_DBCONNECT', '0');
define('UC_KEY', '81e7l016UzxnUeQzXieEqXA0Mz7xcoAgJsWFpw');
define('UC_API', 'http://uc.localhost');
define('UC_CHARSET', 'utf-8');
define('UC_IP', '');
define('UC_APPID', '2');
define('UC_PPP', '20');

?>