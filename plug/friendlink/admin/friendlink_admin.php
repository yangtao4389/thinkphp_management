<?
!defined('IN_ADMIN') && exit('Access Denied');
include_once(dirname(__FILE__)."/../config.php");
$cookienowurl  = empty($_SCOOKIE['cookienowurl']) ? $baseurl."&ac=boardlist" : $_SCOOKIE['cookienowurl'];
$_GET['op'] || $_GET['op'] = 'boardlist';

if(submitcheck('fdlsubmit')){//添加或修改公告
	$_POST['friend']['webname'] || showmessage('请填写网站标题');
	$_POST['friend']['weburl'] || showmessage('请填写网站url');
 	if($_POST['fdlid']>0){
		updatetable('plug_friendlink',$_POST['friend']," id='$_POST[fdlid]'");
	 
	}else{
		$_POST['friend']['adddt'] = date("Y-m-d H:i:s");
 		//查询是否存在
		$ishave = $_SGLOBAL['db']->getone('select * from '.tname('plug_friendlink')." where webname='".$_POST['friend']['webname']."'");
		$ishave && showmessage('此网站已经存在');
		inserttable('plug_friendlink',$_POST['friend']);
	}
	showmessage('操作成功',$cookienowurl);
}

if($_GET['op']=='del'){
	if($_GET['fdlid']>0){
 		$_SGLOBAL['db']->query("delete from ".tname('plug_friendlink')." where id='$_GET[fdlid]'");
 	} 
	showmessage('删除成功',$cookienowurl);
	
}elseif($_GET['op']=='addfriendlink'){
 
}elseif($_GET['op']=='editfriendlink' && $_GET['id']>0){
	$friend = $_SGLOBAL['db']->getone("select * from ".tname('plug_friendlink')." where id='$_GET[id]'");
	
}elseif($_GET['op']=='friendlinklist'){//公告列表
	$perpage = 30;
  	$mpurl = $baseurl.'&ac=friendlink&op=friendlinklist';
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	if($page<1) $page = 1;
	$start = ($page-1)*$perpage;
  	$cond = '';
  	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select count(*) from ".tname('plug_friendlink')." where 1 ".$cond),0);
   	$friendarr = $_SGLOBAL['db']->getall("select * from ".tname('plug_friendlink')." where 1 ".$cond." order by id desc limit  $start,$perpage");
	$multi = multi($count, $perpage, $page, $mpurl);//分页字符串
   	ssetcookie('cookienowurl',$_SGLOBAL['operate_nowurl']);
	
}
?>