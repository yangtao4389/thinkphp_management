<?
!defined('IN_WEB') && exit('Access Denied');
if($_SGLOBAL['super_uid']>0)showmessage('您已经登录无需找回密码');
$_GET['step'] || $_GET['step']=1;
if($_GET['step']==1){//第一步显示用户的

	
}elseif($_GET['step']==2 && submitcheck('checknamesubmit')){//验证用户名
    
	$_POST['lostusername'] || showmessage('请填写用户名');
	$ishave = $_SGLOBAL['db']->getone("select * from ".tname('member')." where username='$_POST[lostusername]' and isadmin=0 and state=1");
	if(!$ishave) showmessage('用户不存在或为未审核用户');
 	//显示用户的答案信息
	$tbname = $ishave['usertype']==1 ? "member_ad" : "member_web";
	$exuarr = $_SGLOBAL['db']->getone("select * from ".tname($tbname)." where uid='$ishave[uid]'");
	if(!$exuarr['question'])showmessage('您未填写问题答案，不能采用此方式找回，请联系网站客服');
	 
}elseif($_GET['step']==3 && submitcheck('checkanswersubmit')){//验证答案
	$_POST['answer'] || showmessage('请填写问题答案');
 	$tbname = $_POST['usertype']==1 ? "member_ad" : "member_web";
	$exuarr = $_SGLOBAL['db']->getone("select * from ".tname($tbname)." where uid='$_POST[uid]' and question='$_POST[question]' and answer='$_POST[answer]'");
	if(!$exuarr)showmessage('问题答案不对，请返回修改');
	$newpassword = genrandstr(10);
	$_SGLOBAL['db']->query("update ".tname('member')." set password='".md5($newpassword)."'  where uid='$_POST[uid]' and isadmin=0 and state=1");
	
}



?>