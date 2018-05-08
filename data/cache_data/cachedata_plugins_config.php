<?php
if(!defined('IN_WEB')) exit('Access Denied');
$_SCONFIG['plugins_config']=Array
	(
	'board' => Array
		(
		'moduleid' => 10,
		'moduletype' => 2,
		'flag' => 'board',
		'iscore' => '0',
		'name' => '文章发布',
		'introduce' => '简单文章发布',
		'directory' => 'board',
		'disable' => '0',
		'moduleconfig' => Array
			(

			),
		'menuconfig' => Array
			(
			'title' => '文章发布',
			0 => 'board|文章列表|boardlist',
			1 => 'board|文章类型|boardlist|boardtypelist'
			),
		'version' => '1.0',
		'author' => 'bobboy007'
		)
	)
?>