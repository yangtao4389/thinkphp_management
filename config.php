<?
header('Content-Type: text/html; charset=utf-8');
//基本配置 
$_SCONFIG['onlinetime'] = 1800;//在线时长
$_SCONFIG['cachetype'] = 'file';//file|memcache 缓存方式
$_SCONFIG['memserver'] = array(
	//array('192.168.1.27',11211,20),//ip,端口=11211,权重=10
);
//数据库配置
$_SCONFIG['charset']='utf8';
$_SCONFIG['cookiepre']='cms_';
$_SCONFIG['tablepre']='cms_';
$_SCONFIG['dbhost']='localhost';
$_SCONFIG['dbuser']='root';
$_SCONFIG['dbpw']='root';
$_SCONFIG['dbname']='basecms';
$_SCONFIG['maxpage'] = 100;//最大分页数
$_SCONFIG['db_ro'] = array(//只读服务器
	//array(
//		'dbhost'=>'locahost',
//		'dbuser'=>'root',
//		'dbpw'=>'123'
//	)
);


//模板配置
$_TPL['defaulttmp'] = 'default';//模板风格
$_TPL['basedefault'] = 'template/default/';//起始位置,空则从template/xxx/
?>