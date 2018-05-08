<?php

!defined('IN_ADMIN') && exit('Access Denied');

//格式mod|名字|ac|op
$arr_top = array(
	'main'    =>'admin|后台首页|main|main', 
    'member'=>'member|会员管理|member',
	'article' => 'article|文章管理|article|artlist',

    'modules' => 'admin|模块管理|modules|modlist',
	'plugins'=>'admin|插件管理|modules|modlist|moduletype=2',
    'sysadmin' => 'admin|系统管理|help|updatecache',
);
$arr_menu['main'] = array(
    array(
        'title' => '网站设置',
        'admin|基本设置|config',
        'admin|短消息列表|admin|msglist',
		'admin|发送消息|admin|sendmsg'
    ),
);

 
$arr_menu['member'] = array(
	array(
		'title'=>'会员列表',
		'member|会员列表|member|memberlist',
		'member|审核会员|member|memberlist|state=0',
		'member|添加广告主|member|adduserinfo|usertype=1',
		'member|添加网站主|member|adduserinfo|usertype=2'
  	),
); 
$arr_menu['article'] = array(
	array(
		'title'=>'文章管理',
		'article|我的文章列表|article|artlist|own=1',
		'article|全部文章列表|article|artlist',
		'article|自定义标记|arttype|flaglist',
		'article|类别列表|arttype|arttypelist',
		'article|添加文章|article|addarticle',
   	),
	
	array(
		'title'=>'内容自定义',
 		'article|自定义内容列表|diycontent|contentlist',
		'article|位置列表|diycontent|typelist',
   	),
	array(
		'title' => '数据调用',
        'admin|调用管理|datacall|datalist',
        'admin|新增数据调用|datacall|adddatacall',
		'admin|区块管理|datacall|placelist',
  	)
	
); 
 $arr_menu['game'] = array(
	array(
		'title'=>'游戏管理',
		'game|游戏列表|game|gamelist',
		'game|游戏截图|game|gamepiclist',
		'game|游戏类别|game|gametypelist',
	 
   	),
); 

$arr_menu['modules'] = array(
    array(
    'title' => '模块管理',
    'admin|模块列表|modules|modlist',
     ),
);
//模块菜单载入

if(is_array($_SCONFIG['modules_config'])) {
    foreach($_SCONFIG['modules_config'] as $key => $val) {
		if(isset($val['menuconfig']) && $val['menuconfig'])$arr_menu['modules'][] = $val['menuconfig'];
    }
}

//插件菜单载入

$arr_menu['plugins'] = array(
	array(
		'title'=>'插件管理',
		'admin|插件列表|modules|modlist|&moduletype=2'
	),
);
if(is_array($_SCONFIG['plugins_config'])) {
    foreach($_SCONFIG['plugins_config'] as $key => $val) {
		if(isset($val['menuconfig']))$arr_menu['plugins'][] = $val['menuconfig'];
    }
}

$arr_menu['sysadmin'] = array(
    array(
        'title' => '网站工具',
        'admin|更新缓存|help|updatecache',
		'admin|文件管理|upfile|filelist'
    ),
	array(
		'title'=>'管理员',
		'admin|管理员列表|admin|adminlist',
		'admin|用户组列表|admin|usergroup',
		'admin|动作列表|admin|actionlist',
		'admin|修改密码|admin|updatepwd',
	),
	array(
		'title' => '数据调用',
        'admin|调用管理|datacall|datalist',
        'admin|新增数据调用|datacall|adddatacall',
		'admin|区块管理|datacall|placelist',
		'admin|数据库信息|help|dbtable|noparse=1',
 	)
 
);
?>