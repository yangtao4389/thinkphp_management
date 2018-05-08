<?php
function ckavatar($uid) {
	global  $_SCONFIG;

	$type = empty($_SCONFIG['avatarreal'])?'virtual':'real';
	include_once(WEB_ROOT.'./uc_client/client.php');
		$file_exists = uc_check_avatar($uid, 'middle', $type);
		return $file_exists;

}
/**
 *判断是否为VIP 返回BOOL
 * */
 function isvip($uid){
 	global $_SGLOBAL;
	$vipflag=false;
	$_SGLOBAL["member"]["baseinfo"]=$_SGLOBAL['db']->getone("select * from ".tname('member')." where uid=$uid");//主表
	$stop=$_SGLOBAL['member']['baseinfo']['stopvip'];
	if ($stop>$_SGLOBAL['timestamp']) {
	$vipflag=true;
	}
	return $vipflag;
}
/**
 *增加减少会员积分
 *$uid,用户ID，$credit,要增加减少的分数,$action，操作原因int
 * */
 function insertcredit($uid,$credit,$action=1){
	global $_SGLOBAL;
	$creditnumarr=array(
	'userid'=>$uid,
	'uname'=>$_SGLOBAL["member"]["baseinfo"]['username'],
	'creditnum'=>$credit,
	'changedt'=>$_SGLOBAL['timestamp'],
	'changereson'=>$action
	);
	inserttable("member_credit_log",$creditarr,1);
	$_SGLOBAL['db']->query("update ".tname('member')." set credit=credit+".$credit." where uid=".$uid); //更新主表积分信息
 }

/**
 *查询用户行为(首页列表)
 * */
 function indexuserlog(){
 	global $_SCONFIG,$_SGLOBAL;
 	$loglist=array();
	$query=$_SGLOBAL['db']->query("select uid,uname,trendtmpid,opertime,trendtmpmsg  from ".tname('member_trend')."  group by userid  order by opertime  desc limit 0,9");
	while($value=$_SGLOBAL['db']->fetch_array($query)){
		$loglist[]=$value;
	}
	return $loglist;

 }

/**
 * 增加用户行为
 * */
function insertuserlog($uid,$type=1,$content=""){
	global $_SGLOBAL;
	$countlog=$_SGLOBAL['db']->getone("select count(uid) as num from ".tname('member_trend')." where uid=$uid");
	if($countlog['num']>10){
		$lastid=$_SGLOBAL['db']->getone("select id from ".tname('member_trend')." where uid=$uid");
		$_SGLOBAL['db']->query('delete from  cms_member_trend where id='.$lastid['id']);
	}
	$trendarr=array(
	'uid'=>$uid,
	'trendtmpid'=>$type,
	'trendtmpmsg'=>$content,
	'opertime'=>time(),
	'uname'=>$_SGLOBAL["member"]["baseinfo"]['username']
	);
	inserttable("member_trend",$trendarr,1);

}
/**
 * 每日首次登陆增加积分
 * */
function addcredit($uid){
	global $_SGLOBAL;
	if(date("Y-m-d",$_SGLOBAL['member']['baseinfo']['lt'])!=date("Y-m-d",$_SGLOBAL['timestamp'])){//判断是否为当天首次登陆
	$where='1';
	isvip($uid)==true?$where='2':$where='1';
	$credits=$_SGLOBAL['db']->getone("select * from ".tname('oper_def')." where id='$where'");
	$_SGLOBAL['db']->query("update ".tname('member')." set credit=credit+".$credits['content']." where uid=".$uid); //更新主表积分信息
	$_SGLOBAL['db']->query("insert into ".tname('member_credit_log'). " set uname='".$_SGLOBAL['member']['baseinfo']['username']."', uid=".$uid.",creditnum=".$credits['content'].",changedt=".$_SGLOBAL['timestamp'].",changereson=1"); //增加积分记录
	}
}

?>