<?
!defined('IN_WEB') && exit('Access Denied');

/***********************memcache 缓存相关函数******************************************/
//$_SGLOBAL['mcache']= getmem_obj();
//用户动态
function getm_usertrend($number=0){
	global $_SGLOBAL;
	if($number<1)return '';
	$trendarr = array();
	$key = 'kuser_trend';
	if(!$trendarr = $_SGLOBAL['cache']->fetch($key)){
		$trendarr = $_SGLOBAL['db']->getone("select * from ".tname('member_trend')." order by id desc limit $number");
		$_SGLOBAL['cache']->store($key,$trendarr,60*60);
	}
	return $trendarr;
}

function delm_usertrend(){
	global $_SGLOBAL;
	$key = 'kuser_trend';
	$_SGLOBAL['cache']->delete($key);	
}
//游戏评论
function getm_gamecomment($gid=0,$number=0){
	global $_SGLOBAL;
	if($gid<1 || $number<1)return '';
	$comarr = array();
	$key = 'kuser_coment';
	if(!$comarr = $_SGLOBAL['cache']->fetch($key)){
		$comarr = $_SGLOBAL['db']->getone("select * from ".tname('game_comment')." where gid='$gid' order by id desc limit $number");
		$_SGLOBAL['cache']->store($key,$comarr,60*60*24);
	}
	return $comarr;
}
function delm_gamecomment(){
	global $_SGLOBAL;
	$key = 'kuser_coment';
	$_SGLOBAL['cache']->delete($key);	
}


/**
 * 判断用户登录,更新用户session表
 * @return void
 */
function checklogin(){
	global $_SGLOBAL,$_SCOOKIE;
	if(!$_SCOOKIE['webauth'])return;
	@list($password, $uid) = explode("\t", web_authcode($_SCOOKIE['webauth'], 'DECODE'));
 	$_SGLOBAL['super_uid'] = intval($uid);
	if($password && $_SGLOBAL['super_uid']) {//检查用户密码合法性
		$member = $_SGLOBAL['db']->getone("SELECT * FROM ".tname('session')." WHERE uid='$_SGLOBAL[super_uid]'");
		if(!$member)$member = $_SGLOBAL['db']->getone("SELECT * FROM ".tname('member')." WHERE uid='$_SGLOBAL[super_uid]'");
		if(!$member || $member['password'] != $password){//session表和member表核对都没有即未登录
			$_SGLOBAL['super_uid'] = 0;
		}else{
 			$_SGLOBAL['super_username'] = addslashes($member['username']);
			if(isset($member['usertype'])){//若session表中没有
				$session = array('uid' => $_SGLOBAL['super_uid'], 'username' => $member['username'], 'password' => $member['password']);
				insertsession($session);
			}
		}//end !member

	}
	if(empty($_SGLOBAL['super_uid']))clearcookie();
}


/**
 * 插入用户session,删除过期用户
 * @param $setarr
 * @return void
 */
function insertsession($setarr){
	global $_SGLOBAL,$_SCONFIG;
	//删除超时用户
	if($_SCONFIG['onlinetime'] < 300) $_SCONFIG['onlinetime'] = 300;
	$_SGLOBAL['db']->query("DELETE FROM ".tname('session')." WHERE uid='$setarr[uid]' OR lastactivity<'".($_SGLOBAL['timestamp']-$_SCONFIG['onlinetime'])."'");
	$ip = getonlineip(1);//返回的是ip数字
	$setarr['lastactivity'] = $_SGLOBAL['timestamp'];
	$setarr['ip'] = $ip;
	inserttable('session',$setarr);
}

/**
 * 获得用户信息存储到$_SGLOBAL['member']['baseinfo'](主表信息)和$_SGLOBAL['member']['extendinfo']（扩展表信息）
 * @param $uid
 * @return void
 */
function getmemberinfo($uid){
	global $_SGLOBAL;
	$_SGLOBAL["member"]["baseinfo"]=$_SGLOBAL['db']->getone("select * from ".tname('member')." where uid=$uid");//主表
	if($_SGLOBAL["member"]["baseinfo"]["usertype"]==2){//普通会员扩展信息
$_SGLOBAL['member']['extendinfo']=$_SGLOBAL['db']->getone("select * from ".tname('member_user')." where uid=$uid");
	}
	elseif ($_SGLOBAL["member"]["baseinfo"]["usertype"]==3) {//厂商扩展信息
$_SGLOBAL['member']['extendinfo']=$_SGLOBAL['db']->getone("select * from ".tname('member_usercomp')." where uid=$uid");
	}
	else{
$_SGLOBAL['member']['extendinfo']="";
	}
}


function getartlist($tid,$limit,$orderby=' id desc'){
	global $_SGLOBAL;
	$arr = $_SGLOBAL['db']->getall("select * from ".tname('plug_board')." where tid='$tid' order by $orderby limit $limit");
	return $arr;
}
?>