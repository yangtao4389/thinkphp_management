<?
!defined('IN_ADMIN') && exit('Access Denied');
$cookienowurl  = empty($_SCOOKIE['cookienowurl']) ? "admincp.php?ac=datacall" : $_SCOOKIE['cookienowurl'];

if(submitcheck('datalistsubmit')){//添加数据调用
	$_POST['datacall']['title'] || showmessage("标题不能为空");
	$_POST['datacall']['flagname'] || showmessage("标识名不能为空");
	$_POST['datacall']['dsql'] || showmessage("sql语句不能为空");
 	$_POST['datacall']['datatmp'] || showmessage("数据模板不能为空");
	if(!preg_match("/^\w+$/i",$_POST['datacall']['flagname']))showmessage('标识名只允许字母,数字,下划线');
 	if($_POST['dlid']>0){//编辑
		updatetable("datacall_list", $_POST['datacall'], " id='".intval($_POST['dlid'])."'");
  	}else{//添加
		//查询此标记是否已经存在
		$dataarr = $_SGLOBAL['db']->getone("select id from ".tname('datacall_list')." where flagname='".trim($_POST['datacall']['flagname'])."'");
		if($dataarr)showmessage("此 标识名 已经存在请返回修改");
		inserttable("datacall_list", $_POST['datacall'],1);
	}
	del_datacall_cache($_POST['datacall']['flagname']);//删除缓存
 	showmessage("数据调用添加成功", $cookienowurl);
	
}elseif(submitcheck('dataplacesubmit')){//位置添加编辑
	$_POST['dataplace']['placename'] || showmessage('请填写位置名称');
	if($_POST['dpid']>0){//编辑
		updatetable("datacall_place", $_POST['dataplace'], " id='".intval($_POST['dpid'])."'");
 	}else{//添加
		inserttable("datacall_place", $_POST['dataplace']);
	}
	showmessage("数据位置添加成功", $cookienowurl);
}

if($_GET['op']=='datalist'){//数据调用列表
	$perpage = 30;$mpurl = 'admincp.php?ac=datacall&op=datalist&dpid='.$_GET['dpid'];
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	if($page<1) $page = 1;
	$start = ($page-1)*$perpage;
	
 	$cond = '';
	$cond .= $_GET['dpid']>0 ? " and dpid='$_GET[dpid]'" : '';
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select count(*) from ".tname('datacall_list')." where 1".$cond),0);
   	$datalistarr = $_SGLOBAL['db']->getall("select dl.*,dp.placename from ".tname('datacall_list')." dl left join ".tname('datacall_place')." dp on dl.dpid=dp.id where 1 ".$cond." order by dl.id asc limit  $start,$perpage");
	$multi = multi($count, $perpage, $page, $mpurl);//分页字符串
	$callexample = '<!--{datacallname:标识}-->';
  	ssetcookie('cookienowurl',$_SGLOBAL['operate_nowurl']);
	
}elseif($_GET['op']=='del'){
	if($_GET['dlid']){//删除数据列表
  		$dlarr = $_SGLOBAL['db']->getall('select flagname from '.tname('datacall_list')." where id='".intval($_GET['dlid'])."'");		
		
  		del_datacall_cache($dlarr['flagname']);//删除缓存
		
  		$_SGLOBAL['db']->query("delete from ".tname('datacall_list')." where id='".$_GET['dlid']."'");
		showmessage('删除成功',$cookienowurl);
	}elseif($_GET['dpid']){//删除位置
		 
		$_SGLOBAL['db']->query("delete from ".tname('datacall_place')." where id='".intval($_GET['dpid'])."'");//删除位置
		$ddarr = $_SGLOBAL['db']->getall("select flagname from ".tname('datacall_list')." where dpid='".intval($_GET['dpid'])."'");
		foreach($ddarr as $value){//删除位置数据缓存
			del_datacall_cache($ddarr['flagname']);
		}
 		$_SGLOBAL['db']->query("delete from ".tname('datacall_list')." where dpid='".intval($_GET['dpid'])."'");//删除此位置的数据
		showmessage('删除操作成功',$cookienowurl);
	}
	showmessage('删除操作失败,请选择内容');
	
}elseif($_GET['op']=='editdatacall' && $_GET['id']>0){//编辑数据调用
	$datacall = $_SGLOBAL['db']->getone('select * from '.tname('datacall_list').' where id='.intval($_GET['id']));
    
	
}elseif($_GET['op']=='adddatacall' ){//添加数据调用的字段默认值
	$datacall['cachetime'] = 60*60;//默认缓存时间
	if($_GET['dpid'])$datacall['dpid'] = intval($_GET['dpid']);

}elseif($_GET['op']=='editdataplace' && $_GET['id']>0){//编辑位置
	$dataplace = $_SGLOBAL['db']->getone('select * from '.tname('datacall_place').' where id='.intval($_GET['id']));
	
}elseif($_GET['op']=='placelist'){
	ssetcookie('cookienowurl',$_SGLOBAL['operate_nowurl']);
}
$dataplacearr = $_SGLOBAL['db']->getall("select * from ".tname('datacall_place')." order by id asc");//位置列表

?>