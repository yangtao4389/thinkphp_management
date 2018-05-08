<?
!defined('IN_WEB') && exit('Access Denied');
	session_start();
	@include_once MEMBER_ROOT.'/../uc_client/client.php';

if($_GET['op']=='loginout'){
	clearcookie();
	showmessage('安全退出成功','index.php');
}
if(submitcheck('loginsubmit')){//登录操作
	$ss=strtoupper($_SESSION["unionseccode"]);
	if($ss!=trim(strtoupper($_POST['seccode'])) )showmessage('验证码不正确');//验证码不对
	if($_POST['loginusername']=='' || $_POST['loginpassword']=='')showmessage('用户名和密码不能为空');
	$islogin = $_SGLOBAL['db']->getone("select * from ".tname('member')." where username='$_POST[loginusername]'");
	if(!$islogin)showmessage('用户名不存在');
	if($islogin['password']!=md5($_POST['loginpassword']))showmessage('用户名或密码错误');
	$_SGLOBAL["member"]["baseinfo"]=$_SGLOBAL['db']->getone("select * from ".tname('member')." where uid=$islogin[uid]");//主表
	$_SGLOBAL['member']['baseinfo']['lt']=$_SGLOBAL["member"]["baseinfo"]['lastlogintime'];
	$_SGLOBAL['db']->query("update ".tname('member')." set lastloginip='$onlineip',lastlogintime='$_SGLOBAL[timestamp]' where uid='$islogin[uid]'");
	ssetcookie('webauth', web_authcode("$islogin[password]\t$islogin[uid]", 'ENCODE'));
	addcredit($islogin[uid]);//增加积分
 	//清理session
	$session = array('uid' => $islogin['uid'], 'username' => $islogin['username'], 'password' => $islogin['password']);
	insertsession($session);
	echo uc_user_synlogin($uid);
	//exit;
	showmessage('登录成功','index.php');
}

?>