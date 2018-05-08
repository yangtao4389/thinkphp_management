<?
//插件安装文件
!defined('IN_ADMIN') && exit('Access Denied');
//模块信息配置
$mconfigarr = array(
 			'name'=>'友情链接',
 			'introduce'=>'友情链接的管理',// 介绍
			'author'=>'bobboy007',// 作者
 			'version'=>'1.0',// 版本
 			'moduleconfig'=>array(//模块默认配置信息
			),
			'menuconfig'=>array(
			   'title'=>'友情链接',
 			   'friendlink|友情链接列表|friendlink|friendlinklist',
    		   'friendlink|添加友情链接|friendlink|addfriendlink',
  			),
);
//需要运行的sql,表前缀用#@__代替
$sqlbatch = <<<EOT

CREATE TABLE `#@__plug_friendlink` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`webname` VARCHAR( 250 ) NULL ,
`weburl` varchar(250) NULL ,
`logpic` varchar(250) NULL ,
`adddt` datetime default NULL
) ENGINE = MYISAM ;
EOT;

runquery($sqlbatch);

?>