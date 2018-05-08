<?
!defined('IN_ADMIN') && exit('Access Denied');

$cookienowurl  = empty($_SCOOKIE['cookienowurl']) ? "admincp.php?ac=admin" : $_SCOOKIE['cookienowurl'];

if(submitcheck('usersubmit')){//添加修改管理员
	
	if($_POST['memberarr']['isadmin']==0)$_POST['memberarr']['gid']=0;
	//验证安全码
	$safecode = md5($_POST['memberarr']['username'].date("md"));
	$_POST['memberarr']['state']=1;//管理员不需要审核直接通过
	if(md5($_POST['safecode'])!=$safecode)showmessage('网站安全码不正确,不能修改');
	if($_POST['password']){
 		$_POST['memberarr']['password'] = md5($_POST['password']);
	}
 	if($_POST['memberid']>0){//update
 		updatetable('member',$_POST['memberarr']," uid='".intval($_POST['memberid'])."'");
		writeadminlog('修改管理员信息:'.$_POST['memberarr']['username']);
 	}else{
		$_POST['memberarr']['username'] || showmessage('请填写用户名');
		$_POST['password'] || showmessage('请填写密码');
		inserttable('member',$_POST['memberarr']);
		writeadminlog('新增管理员:'.$_POST['memberarr']['username']);
	}
	showmessage('操作成功','admincp.php?ac=admin&op=adminlist');

}elseif(submitcheck('usergroupsubmit')){//用户组
	$_POST['usergroup']['groupname'] || showmessage('请填写用户组名称');
	$_POST['usergroup']['descript'] || showmessage('请填写用户组描述');
	if($_POST['groupid']>0){
		updatetable('usergroup',$_POST['usergroup']," gid='".intval($_POST['groupid'])."'");
	}else{
		inserttable('usergroup',$_POST['usergroup']);
	}
	showmessage('操作成功','admincp.php?ac=admin&op=usergroup');

}elseif(submitcheck('actionsubmit')){//动作
	$_POST['actionarr']['title'] || showmessage('请填写动作标题');
	$_POST['actionurl'] || showmessage('请填写权限地址');
	$_POST['actionurl'] = str_replace('admincp.php?','',$_POST['actionurl']);
 	parse_str($_POST['actionurl'],$acarr);
 
	$acarr['mod'] || $acarr['mod']='admin';
	$_POST['actionarr']['umodule'] = $acarr['mod'];
	$_POST['actionarr']['uaction'] = $acarr['ac'];
	$_POST['actionarr']['uoperat'] = $acarr['op'];
	if($_POST['actionid']>0){
		updatetable('useraction',$_POST['actionarr']," acid='".intval($_POST['actionid'])."'");
	}else{
		inserttable('useraction',$_POST['actionarr']);
	}
	showmessage('操作成功',$cookienowurl);
	
}elseif(submitcheck('permsubmit')){//权限设置
	$_POST['aclist'] || showmessage('请选择一个选项');
	$_POST['gid'] || showmessage('无效的用户组');
	$_SGLOBAL['db']->query("update ".tname('usergroup')." set aclist='".implode(",",$_POST['aclist'])."' where  gid='".intval($_POST['gid'])."'");
	showmessage('更新权限完成',$cookienowurl);
}elseif(submitcheck("updatepwdsubmit")){
	$_POST['oldpassword'] || showmessage('请填写旧密码');
	$_POST['newpassword'] || showmessage('请填写新密码');
	$uinfo = $_SGLOBAL['db']->getone("select * from ".tname('member')." where uid='".$_SGLOBAL['super_uid']."'");
	if($uinfo['password']!=md5($_POST['oldpassword']))showmessage('旧密码填写错误');
	$_SGLOBAL['db']->query("update ".tname('member')." set password='".md5(trim($_POST['newpassword']))."',writename='$_POST[writename]' where uid='".$_SGLOBAL['super_uid']."'");
	
	clearcookie();
	showmessage('修改密码成功','admincp.php?ac=admin&op=updatepwd');

}elseif(submitcheck('sendmsg')){//发送回复短消息
	$_POST['adminmsg']['touser'] || showmessage('收件人不能为空');
	$_POST['adminmsg']['title'] || showmessage('标题不能为空');
	$_POST['adminmsg']['content'] || showmessage('内容不能为空');
	$_POST['adminmsg']['fromuser']=$_SGLOBAL['super_username'];
	$_POST['adminmsg']['dttime']=date("Y-m-d H:i:s");
	$userarr = explode(",",$_POST['adminmsg']['touser']);
	foreach($userarr as $value){
		if(!$value)continue;
		$_POST['adminmsg']['touser'] = $value;
 		inserttable('adminmsg',$_POST['adminmsg']);
	}
	showmessage('发送短消息成功','admincp.php?ac=admin&op=msglist&send=1');
}


if($_GET['op']=='del'){
	if($_GET['uid']>0){//管理员
		$_SGLOBAL['db']->query("delete from ".tname('member')." where uid='".intval($_GET['uid'])."'");
	}elseif($_GET['gid']>0){//用户组
		$_SGLOBAL['db']->query("delete from ".tname('usergroup')." where gid='".intval($_GET['gid'])."'");
	}elseif($_GET['acid']>0){//action
		$_SGLOBAL['db']->query("delete from ".tname('useraction')." where acid='".intval($_GET['acid'])."'");
	}
	showmessage('删除成功',$cookienowurl);

}elseif($_GET['op']=='adminlist'){//管理员列表
	$cond='';
	if($_GET['gid']>0){
		$currentgroup = $_SGLOBAL['db']->getone("select * from ".tname('usergroup')." where gid='".intval($_GET['gid'])."'");
		$cond .=' and gid='.intval($_GET['gid']);
	}
	$adminarr = $_SGLOBAL['db']->getall("select * from ".tname('member')." where isadmin=1 $cond");
	ssetcookie('cookienowurl',$_SGLOBAL['operate_nowurl']);

}elseif($_GET['op']=='actionlist'){//动作列表
	$perpage = 30;$mpurl = 'admincp.php?ac=admin&op=actionlist&umodule='.$_GET['umodule'];
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	if($page<1) $page = 1;
	$start = ($page-1)*$perpage;
  	$cond = '';
	$cond .= $_GET['umodule'] ? " and umodule='$_GET[umodule]'" : '';
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select count(*) from ".tname('useraction')." where 1".$cond),0);
   	$actionlistarr = $_SGLOBAL['db']->getall("select * from ".tname('useraction')." where 1 $cond order by acid asc limit $start,$perpage");
	 
	$multi = multi($count, $perpage, $page, $mpurl);//分页字符串
  //获得唯一标识组
	$modarr = $_SGLOBAL['db']->getall("select DISTINCT  umodule from ".tname('useraction'));
  	ssetcookie('cookienowurl',$_SGLOBAL['operate_nowurl']);
	
}elseif($_GET['op']=='usergroup'){//用户组列表
	ssetcookie('cookienowurl',$_SGLOBAL['operate_nowurl']);
	
}elseif($_GET['op']=='setperm' && $_GET['gid']>0){//权限设置
	$grouparr = $_SGLOBAL['db']->getone("select * from ".tname('usergroup')." where gid='$_GET[gid]'");
	
	$modarr = $_SGLOBAL['db']->getall("select DISTINCT  uaction from ".tname('useraction'));
	foreach($modarr as $key=>$value){
		$modarr[$key]['aclist'] = getaclistbymod($value['uaction']);
		  
	}
}elseif($_GET['op']=='editaction'&& $_GET['acid']>0){//编辑动作
	$actionarr = $_SGLOBAL['db']->getone("select * from ".tname('useraction')." where acid='$_GET[acid]'");
	
}elseif($_GET['op']=='edituser' && $_GET['uid']>0){
	$memberarr = $_SGLOBAL['db']->getone("select * from ".tname('member')." where uid='$_GET[uid]'");

}elseif($_GET['op']=='editgroup' && $_GET['gid']>0){
	$usergroup = $_SGLOBAL['db']->getone("select * from ".tname('usergroup')." where gid='$_GET[gid]'");
}elseif($_GET['op']=='adminlog'){
	$logarr = sreaddir(WEB_CACHEDIR."adminlog/");
	 rsort($logarr);
	 
}elseif($_GET['op']=='msglist'){//短消息列表
	$perpage = 20;$mpurl = 'admincp.php?ac=config&op=msglist&isread='.$_GET['isread']."&send=".$_GET['send'];
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	if($page<1) $page = 1;
	$start = ($page-1)*$perpage;
	$_GET['isread'] ||$_GET['isread']=0;
 	$cond = '';
	$cond .= $_GET['isread']==1 ? " and isread=1" : " and isread=0";
  	$cond .= " and touser='".$_SGLOBAL['super_username']."'";
	 
	if($_GET['send']==1){//已发送
 		$cond=" and fromuser='$_SGLOBAL[super_username]'";
	}
 	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select count(*) from ".tname('adminmsg')." where 1".$cond),0);
   	$msgarr = $_SGLOBAL['db']->getall("select * from ".tname('adminmsg')." where 1 ".$cond." order by id desc limit  $start,$perpage");
	$multi = multi($count, $perpage, $page, $mpurl);//分页字符串
   	ssetcookie('cookienowurl',$_SGLOBAL['operate_nowurl']);
	if($count>50){
		$delnum = $count-50;
		$_SGLOBAL['db']->query("delete from ".tname('adminmsg')." order by id asc limit $delnum");
	} 

}elseif($_GET['op']=='sendmsg'){//发送回复短消息
	//当前管理员列表
	$admarr = $_SGLOBAL['db']->getall("select * from ".tname('member')." where isadmin=1");
	$admstr = '';
	foreach($admarr as $value){
		$admstr .= $value['username'].",";
	}
 	if($_GET['msgid']>0){
		$cond = " and id='$_GET[msgid]'";
		$cond .= " and (touser='$_SGLOBAL[super_username]' or fromuser='".$_SGLOBAL['super_username']."')";
		$adminmsg=$_SGLOBAL['db']->getone("select * from ".tname('adminmsg')." where 1  $cond ");
		$adminmsg['title']='Re:'.$adminmsg['title'];
		$adminmsg['content']=">".str_replace("\r\n","\r\n>",$adminmsg['content']);
		$_SGLOBAL['db']->query("update ".tname('adminmsg')." set isread=1 where touser='$_SGLOBAL[super_username]' and id='$_GET[msgid]'");
 	} 
	
}elseif($_GET['op']=='updatepwd'){
	$uuinfo = $_SGLOBAL['db']->getone("select * from ".tname('member')." where uid='$_SGLOBAL[super_uid]'");

}
//通过mod获得action列表
function getaclistbymod($uaction=''){
	global $_SGLOBAL;
	if(!$uaction)return array();
	$aclist = $_SGLOBAL['db']->getall("select * from ".tname('useraction')." where uaction='$uaction' order by umodule asc,uaction asc,uoperat asc");
	return $aclist;
}
$usergrouparr = $_SGLOBAL['db']->getall("select * from ".tname('usergroup')." where 1");//用户组列表
 
?>