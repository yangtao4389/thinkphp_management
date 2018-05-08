<?
!defined('IN_WEB') && exit('Access Denied');
$cuinfo = $_SGLOBAL['db']->getone("select * from ".tname('member')." where uid='$_SGLOBAL[super_uid]'");

if($_GET['op']=='editdetail'){
	$detailuinfo = $_SGLOBAL['db']->getone("select * from ".tname('member_web')." where uid='$_SGLOBAL[super_uid]'");
	$qqmsn = explode("/",$detailuinfo['qqmsn']);
	$detailuinfo['qq'] = $qqmsn[0];$detailuinfo['msn'] = $qqmsn[1];
}
//用户信息相关
if(submitcheck('passwordsubmit')){//修改密码
	if(empty($_POST['oldpwd']) || empty($_POST['newpwd']) )showmessage('旧密码和新密码不能为空');
 	if(md5($_POST['oldpwd'])!=$cuinfo['password'])showmessage('旧密码错误');
	if($_POST['newpwd']!=$_POST['renewpwd'])showmessage('两次输入的密码不一样');
	$_SGLOBAL['db']->query("update ".tname('member')." set password='".md5(trim($_POST['newpwd']))."' where uid='$_SGLOBAL[super_uid]' and isadmin=0");
	clearcookie();
	showmessage('密码修改成功,请重新登录','weber.php?ac=userinfo&op=editpwd');
	
}elseif(submitcheck('detailsubmit')){//详细信息修改
	$duinfo = $_SGLOBAL['db']->getone("select * from ".tname('member_web')." where uid='$_SGLOBAL[super_uid]'");
	if($_POST['qq'] && !preg_match("/^[0-9]\d{4,10}$/",$_POST['qq']))showmessage('qq号码位数不对');
	if($_POST['msn'] && !preg_match("/^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/",$_POST['msn']))showmessage('msn格式不对');
	$_POST['uinfo']['qqmsn'] = $_POST['qq']."/".$_POST['msn'];
	//银行信息填写后就不允许修改
	if($duinfo['realname'])  unset($_POST['uinfo']['realname']);
	if($duinfo['bankname']) unset($_POST['uinfo']['bankname']);
	if($duinfo['bankaddress']) unset($_POST['uinfo']['bankaddress']);
	if($duinfo['bankaccounts']) unset($_POST['uinfo']['bankaccounts']);
	updatetable('member_web',$_POST['uinfo']," uid='$_SGLOBAL[super_uid]'");
	showmessage('修改用户资料成功','weber.php?ac=userinfo&op=editdetail');
}
?>