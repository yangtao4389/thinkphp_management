<?php

!defined('IN_ADMIN') && exit('Access Denied');
$cookienowurl  = empty($_SCOOKIE['cookienowurl']) ? "admincp.php?ac=modules" : $_SCOOKIE['cookienowurl'];

$_GET['op'] || $_GET['op']='modlist';
$_GET['moduletype'] || $_GET['moduletype']=1;
if($_GET['mod'] != 'admin') {//加载外部模块
	$configpath = WEB_ROOT.'./'.$_SCONFIG['modules'][$_GET['mod']]['directory'].'/admin/config.php';
	$actionpath = WEB_ROOT.'./'.$_SCONFIG['modules'][$_GET['mod']]['directory'].'/admin/'.$_GET['ac'].'_admin.php';
   	if(!file_exists($configpath)||!file_exists($actionpath))showmessage("模块配置文件加载失败");
    include($configpath);
	include($actionpath);
	exit;    
}
//模块安装与卸载
if(submitcheck('installmodule')){//安装模块
 	$flag = !empty($_POST['flag']) ? trim($_POST['flag']) : showmessage('未填写模块标识。');
	$directory = !empty($_POST['directory']) ? trim($_POST['directory']) : showmessage('未填写目录名称，请返回填写。'); 
	$_POST['moduletype'] || showmessage('请选择是安装类别');
	if($_POST['moduletype']==1){//模块
		$modinsfile = WEB_ROOT.'./'.$directory."/install.php";
 	}else{
		$modinsfile = WEB_ROOT.'./plug/'.$directory."/install.php";
	}
	!file_exists($modinsfile) && showmessage('目录或安装文件不存在，请返回填写。'.$modinsfile);
	$modexist = $_SGLOBAL['db']->getone("SELECT * FROM ".tname('modules')." WHERE flag='$flag'");
 	if($modexist)showmessage('标识名重复,请重新填写');
	
	//读取配置插入数据库
  	include($modinsfile);
	isset($mconfigarr['moduleconfig']) && $mconfigarr['moduleconfig'] = serialize($mconfigarr['moduleconfig']);
	isset($mconfigarr['menuconfig']) && $mconfigarr['menuconfig'] = serialize($mconfigarr['menuconfig']);
 	
	$mconfigarr['flag'] = $flag;$mconfigarr['moduletype'] = intval($_POST['moduletype']);$mconfigarr['iscore'] = 0;
	$mconfigarr['directory'] = $directory;
	
	inserttable('modules',$mconfigarr);//插入模块表 
 	//模块配置缓存
	cache_modulesconfig();cache_pluginsconfig();
 	showmessage("安装成功", $cookienowurl);

}elseif(submitcheck('modconfigsubmit')){//更新配置
	$_POST['mod']['name'] || showmessage('请填写模块名');
	$_POST['mod']['flag'] || showmessage('请填写模块标识');
	$_POST['mod']['directory'] || showmessage('请填写模块文件夹');
	if($_POST['modvaluelist']){
		$mvarr = array();
 		$varr = explode(",",$_POST['modvaluelist']);
 		foreach($varr as $key=>$value){
			if($key==0){
				$mvarr['title'] = trim($value); 
 			}else{
				$mvarr[] = trim($value);
			}
 		}
		$_POST['mod']['menuconfig'] = serialize($mvarr);
	}
	updatetable('modules',$_POST['mod']," moduleid='".$_POST['modid']."'");
	cache_modulesconfig();cache_pluginsconfig();//模块配置缓存
	showmessage('更新模块配置成功',$cookienowurl);
	
}


if($_GET['op']=='unstallmodule'){//卸载模块
 	$moduleid = isset($_GET['moduleid']) ? $_GET['moduleid'] : showmessage('参数错误没有指定模块id'); 
	$moduleinfo = $_SGLOBAL['db']->getone("SELECT * FROM ".tname('modules')." WHERE moduleid='$moduleid'");
	if($moduleinfo['iscore']) showmessage('本模块为核心模块，不允许删除。');
	if($moduleinfo['moduletype']==1){//模块
		$modinsfile = WEB_ROOT.'./'.$moduleinfo['directory']."/unstall.php";
 	}else{
		$modinsfile = WEB_ROOT.'./plug/'.$moduleinfo['directory']."/unstall.php";
	}
	 
	include($modinsfile);
	// 从模块表删除
	$_SGLOBAL['db']->query("DELETE FROM ".tname('modules')." WHERE moduleid='$moduleid' and iscore<>1");
	// 更新缓存
 	cache_modulesconfig();cache_pluginsconfig();
	showmessage($moduleinfo['name'].'卸载完毕。',$cookienowurl);

}elseif($_GET['op']=='disablemod'){//禁用启用模块
 	$_SGLOBAL['db']->query("UPDATE ".tname('modules')." SET disable='".intval($_GET[disable])."' WHERE moduleid='".intval($_GET['moduleid'])."' and iscore=0");
	cache_modulesconfig();cache_pluginsconfig();//模块配置缓存
	showmessage('状态设置完毕。', $cookienowurl);

}elseif($_GET['op']=='modlist'){
	$modlist = $_SGLOBAL['db']->getall("select * from ".tname('modules')." where moduletype='".intval($_GET['moduletype'])."' order by iscore desc,moduleid"
	);
	ssetcookie('cookienowurl', $_SGLOBAL['operate_nowurl']);
	 
}elseif($_GET['op']=='editconfig' && $_GET['modid']>0){//模块配置
	$mod = $_SGLOBAL['db']->getone("select * from ".tname('modules')." where moduleid='".intval($_GET['modid'])."'");
	
}
?>