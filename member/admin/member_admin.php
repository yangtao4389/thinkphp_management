<?
!defined('IN_ADMIN') && exit('Access Denied');//会员列表
include_once(dirname(__FILE__)."/../config.php");
$cookienowurl  = empty($_SCOOKIE['cookienowurl']) ? $baseurl."&ac=member" : $_SCOOKIE['cookienowurl'];
$_GET['op'] || $_GET['op']='memberlist';
if(submitcheck('ubasesubmit')){//添加修改基本信息
	
	if($_POST['minfo']['isadmin']==1 || $_POST['minfo']['gid']>0){//若直接加为管理员
		if($_SGLOBAL['member']['baseinfo']['gid']!=1)showmessage('只有超级管理员有此权限');
	}
	if($_POST['uid']>0){
		if($_POST['minfo']['password']){
			 $_POST['minfo']['password'] = md5($_POST['minfo']['password']);
		}else{
			unset($_POST['minfo']['password']);
		}
		
 		updatetable('member',$_POST['minfo']," uid='".intval($_POST['uid'])."'");
		$tbname = $_POST['minfo']['usertype']==1 ? 'member_ad' : 'member_web';
		updatetable($tbname,$_POST['mexinfo'],"  uid='$_POST[uid]'");//更新扩展表
		showmessage('更新用户资料成功!',$cookienowurl);
	}else{
		if(empty($_POST['minfo']['password']) || empty($_POST['minfo']['username'])) showmessage('请填写用户名和密码');
		$_POST['minfo']['password'] = md5($_POST['minfo']['password']);
		$_POST['minfo']['lastlogintime'] = time();
		//查询用户是否存在
		$ishave = $_SGLOBAL['db']->getone("select * from ".tname('member')." where username='".trim($_POST['minfo']['username'])."'");
		if($ishave)showmessage('添加失败!此用户已经存在!');
		
		$insertid = inserttable('member',$_POST['minfo'],1);
		$tbname = $_POST['minfo']['usertype']==1 ? 'member_ad' : 'member_web';
		$_POST['mexinfo']['uid'] = $insertid;
		inserttable($tbname,$_POST['mexinfo']);
		showmessage('新增用户资料成功!',$cookienowurl);
	}
	
	
}

if($_GET['op']=='del'){//删除
	if($_GET['uid']>0){
		//获得用户信息
 		$_SGLOBAL['db']->query('delete from '.tname('member')." where uid='$_GET[uid]' and isadmin=0");
		//删除附加表
		$_SGLOBAL['db']->query('delete from '.tname('member_web')." where uid='$_GET[uid]' ");//删除网站主
		$_SGLOBAL['db']->query('delete from '.tname('member_ad')." where uid='$_GET[uid]' ");//删除广告主
		showmessage('删除用户信息成功!',$cookienowurl);
	}

}elseif($_GET['op']=='adduserinfo'){//添加用户
	$grouparr = $_SGLOBAL['db']->getall("select * from ".tname('usergroup')." ");
	if($_GET['usertype']==2){
		$minfo['usertype'] = 2;
	}else{
		$minfo['usertype'] = 1;
	}
	
}elseif($_GET['op']=='edituserinfo' && $_GET['uid']>0){//编辑用户
	$grouparr = $_SGLOBAL['db']->getall("select * from ".tname('usergroup')." ");//用户组
	$minfo = $_SGLOBAL['db']->getone('select * from '.tname('member')." where uid='$_GET[uid]'");
  	$tbname = $minfo['usertype']==1 ? 'member_ad' : 'member_web';
	$mexinfo = $_SGLOBAL['db']->getone("select * from ".tname($tbname)." where uid='$_GET[uid]'");
	
}elseif($_GET['op']=='memberlist'){//usertype=1广告主2网站主
	 
   	$mpurl = $baseurl.'&ac=member&op=memberlist&uid='.$_GET['uid'].'&username='.$_GET['username'].'&usertype='.$_GET['usertype'].'&state='.$_GET['state'];
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	if($page<1) $page = 1;
	$start = ($page-1)*$perpage;
  	$cond = '';
	$cond .= $_GET['uid']>0 ? " and uid='$_GET[uid]'" : '';
	$cond .= $_GET['username'] ? " and username like'%$_GET[username]%'" : '';
  	$cond .= (isset($_GET['usertype']) && $_GET['usertype']!=-1) ? " and usertype='$_GET[usertype]'" : ''; 
	$cond .= (isset($_GET['state']) && $_GET['state']!=-1) ? " and state='$_GET[state]' ": '';
	$cond .= ' and isadmin=0';
	
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select count(*) from ".tname('member')."  where 1 ".$cond),0);
   	$memberarr = $_SGLOBAL['db']->getall("select * from ".tname('member')." where 1 ".$cond." order by uid desc limit  $start,$perpage");
 	$multi = multi($count, $perpage, $page, $mpurl);//分页字符串
   	ssetcookie('cookienowurl',$_SGLOBAL['operate_nowurl']);
	
}elseif($_GET['op']=='detail' && $_GET['uid']>0 && $_GET['usertype']>0){//用户详细信息
	$tbname = $_GET['usertype'] ==1 ? 'member_ad' : 'member_web';
 	$detailarr = $_SGLOBAL['db']->getone("select * from ".tname('member_ad')." where uid='$_GET[uid]'");
}


?>