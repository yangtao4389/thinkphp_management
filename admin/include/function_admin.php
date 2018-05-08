<?
!defined('IN_WEB') && exit('Access Denied');

/**
 * 检查管理员操作权限
 * @return bool
 */
function checkadmin(){
	global $_SGLOBAL;
	if(!$_SGLOBAL['super_uid'])return false;
	if($_SGLOBAL['member']['baseinfo']['gid']==1)return true;//超级管理员组不受限制 
	//判断是否有权限操作此链接
	$urlarr = parse_url ($_SGLOBAL['operate_nowurl']);
	$nowurl = strstr($urlarr['query'],'op=') ? $urlarr['query'] : $urlarr['query'].'&op=';

 	$exceparr= array(
		'ac=main',
		'ac=iframe',
		'mod=admin&ac=admin&op=updatepwd'
	);//排除数组
	 
	foreach($exceparr as $value){
		if(strstr($nowurl,$value)!==false)return true; 
	}
	  
	//当前用户组的action
	$usergroup_aclist =  $_SGLOBAL['member']['baseinfo']['aclist'];
	$acurlarr = $_SGLOBAL['db']->getall("select * from ".tname('useraction')." where acid in($usergroup_aclist)");
	$checkuser=false;
	foreach($acurlarr as $value){
		$actionurl = 'mod='.$value['umodule'].'&ac='.$value['uaction']."&op=".$value['uoperat'];
	 
		if(strstr($nowurl,$actionurl)!==false) $checkuser=true;
	}
  
 	return $checkuser;
}

/**
 * 后台登录验证
 * @param $username
 * @param $password
 * @return bool
 */
function checkadminlogin($username,$password){
	global $_SGLOBAL,$onlineip;
 	$userarr = $_SGLOBAL['db']->getone("select * from ".tname('member')." where isadmin=1 and username='$username' and password='".md5($password)."'");
	if(!$userarr)return false;
	$_SGLOBAL['db']->query("update ".tname('member')." set lastloginip='$onlineip',lastlogintime='$_SGLOBAL[timestamp]' where uid='$userarr[uid]'");
	ssetcookie('webauth', web_authcode("$userarr[password]\t$userarr[uid]", 'ENCODE'));
 	//清理session
	$session = array('uid' => $userarr['uid'], 'username' => $userarr['username'], 'password' => $userarr['password']);
	insertsession($session);
	return true;
}

/**
 * 用于计算数据库表大小单位
 * @param $filesize
 * @return string
 */
function sizeunit($filesize) {
	if($filesize >= 1073741824) {
		$filesize = round($filesize / 1073741824 * 100) / 100 . ' GB';
	} elseif($filesize >= 1048576) {
		$filesize = round($filesize / 1048576 * 100) / 100 . ' MB';
	} elseif($filesize >= 1024) {
		$filesize = round($filesize / 1024 * 100) / 100 . ' KB';
	} else {
		$filesize = $filesize . ' bytes';
	}
	return $filesize;
}

/**
 * 获得数据库表字段
 * @param $table
 * @return array
 */
function gettablefield($table){
	global $_SGLOBAL;
	$query = $_SGLOBAL['db']->query("select * from $table");
	$fieldnum = $_SGLOBAL['db']->num_fields($query);
	$farr = array();
	for($i=0;$i<$fieldnum;$i++){
		$farr[] = $_SGLOBAL['db']->field_name($query,$i);
	}
	return $farr;
}

/**
 * 获得模块起始路径,eg member/
 * @param $mod
 * @return string
 */
function getmodpath($mod){
	global $_SCONFIG;
	$tplpath = '';
	if($_SCONFIG['plugins_config'][$mod]['moduletype']==2){//插件
		$tplpath = 'plug/'.$_SCONFIG['plugins_config'][$mod]['directory']."/"; 
	}elseif($_SCONFIG['modules_config'][$mod]['moduletype']==1){//模块
		$tplpath = $_SCONFIG['modules_config'][$mod]['directory']."/"; 	
	}else{//系统核心
		$tplpath = '';
	}
  	return $tplpath; 
}

?>