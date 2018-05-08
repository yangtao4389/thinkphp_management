<?
!defined('IN_WEB') && exit('Access Denied');
@include_once MEMBER_ROOT.'/../uc_client/client.php';
if(submitcheck("regsubmit")){//注册
	if(empty($_POST['username']) || empty($_POST['password']))showmessage('请填写用户名和密码');
	if(! preg_match("/^[a-zA-Z_0-9]{4,20}$/",trim($_POST['username'])) )showmessage('错误:用户名只允许4-20字母数字下划线的组合');
	if($_POST['password']!= $_POST['repassword'])showmessage("两次输入密码不一致");
	if(defined('UC_API') && @include_once dirname(__FILE__).'/../uc_client/client.php'){		
		$isreg = uc_user_checkname(trim($_POST['username']));
		if($isreg!=1)showmessage('此用户名已经被占用');		
	}
	else{
		// UC注册
		$uid=uc_user_register($_POST['username'],$_POST['password'],$_POST['email']);
		
		 if($uid<1) {
			 showmessage("此用户名已经被占用或者EMAIL被占用<br><a href='javascript:history.back(-1)'></a> &nbsp;<script>setTimeout('history.go(-1);',3000);</script>");
		 }
	//平台注册
		$baseinarr = array(
		'username'=>$_POST['username'],
		'password'=>md5($_POST['password']),
		'usertype'=>2,
		'lastloginip'=>$onlineip,
		'lastlogintime'=>time(),
		'state'=>1		
		);
	$insertid = inserttable('member',$baseinarr,1);	 
		//进行自动登录
 	ssetcookie('webauth', web_authcode(md5($_POST['password'])."\t$insertid", 'ENCODE'));
 	//清理session
	$session = array('uid' => $insertid, 'username' => $_POST['username'], 'password' => md5($_POST['password']));
	insertsession($session);
	echo uc_user_synlogin($uid);
	showmessage('注册成功，正在登录..','index.php');	 
		}
}
?>