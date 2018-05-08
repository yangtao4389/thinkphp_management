<?php
if(!defined('IN_WEB')) exit('Access Denied');
$_SCONFIG['modules_config']=Array
	(
	'member' => Array
		(
		'moduleid' => 9,
		'moduletype' => 1,
		'flag' => 'member',
		'iscore' => 1,
		'name' => '会员模块',
		'introduce' => '包括广告点击流程',
		'directory' => 'member',
		'disable' => '0',
		'moduleconfig' => Array
			(

			),
		'menuconfig' => Array
			(

			),
		'version' => '1.0',
		'author' => 'bobboy007'
		),
	'article' => Array
		(
		'moduleid' => 12,
		'moduletype' => 1,
		'flag' => 'article',
		'iscore' => '0',
		'name' => 'cms系统',
		'introduce' => 'cms发布系统',
		'directory' => 'article',
		'disable' => '0',
		'moduleconfig' => Array
			(

			),
		'menuconfig' => Array
			(

			),
		'version' => '1.0',
		'author' => 'bobboy007'
		)
	)
?>