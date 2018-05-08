<?
!defined('IN_ADMIN') && exit('Access Denied');
include_once(dirname(__FILE__)."/../config.php");
$artcookienowurl  = empty($_SCOOKIE['artcookienowurl']) ? $baseurl."&ac=arttype" : $_SCOOKIE['artcookienowurl'];

if(submitcheck('typesubmit')){//类别添加修改
	$_POST['arttype']['pid'] || $_POST['arttype']['degree']=1;
	$tidlist = '';
	$_POST['arttype']['tmplist'] || $_POST['arttype']['tmplist']=$_SCONFIG['baseconfig']['deftmplist'];
	$_POST['arttype']['tmpcontent'] || $_POST['arttype']['tmpcontent']=$_SCONFIG['baseconfig']['deftmpcontent'];
	
	$parr = $_SGLOBAL['db']->getone("select * from ".tname('article_type')." where id='".intval($_POST['arttype']['pid'])."'");
	$_POST['arttype']['tname'] = $parr['tname'].trim($_POST['arttype']['tname']).'|';
	$tidlist = $parr['tidlist'];
	$_POST['arttype']['tidlist']  = $tidlist.$_POST['arttypeid'].",";
 	if($_POST['arttypeid']){//更新分类
 		updatetable('article_type',$_POST['arttype'], " id='$_POST[arttypeid]'");
	}else{//新增分类
		$insertid = inserttable('article_type',$_POST['arttype'],1);
		$tidlist .= $insertid.",";
		$_SGLOBAL['db']->query("update ".tname('article_type')." set tidlist='$tidlist' where id='$insertid'");
	}
	showmessage('操作成功',$artcookienowurl);
	
}elseif(submitcheck('flagsubmit')){//添加自定义标识
	$_POST['artflag']['flagname'] || showmessage('标识名不能为空!');
	if($_POST['flagid']){//更新分类
 		updatetable('article_diyflag',$_POST['artflag'], " id='$_POST[flagid]'");
	}else{//新增分类
 		inserttable('article_diyflag',$_POST['artflag']);
	 
	}
	showmessage('操作成功!',$artcookienowurl);
}


if($_GET['op']=='del'){
	if($_GET['tid']>0){//删除此分类和此分类下的所有分类
		$tidlist = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select tidlist from ".tname('article_type')." where id='$_GET[tid]'"),0);
		$_SGLOBAL['db']->query("delete from ".tname('article_type')." where tidlist like '$tidlist%'");
	
	}elseif($_GET['flagid']>0){//删除flag
		$_SGLOBAL['db']->query("delete from ".tname('article_diyflag')." where id='$_GET[flagid]'");
	}
	showmessage('删除成功',$artcookienowurl);
	
}elseif($_GET['op']=='arttypelist'){//类别列表
	$pid = $_GET['pid']>0 ? $_GET['pid'] : -1 ;
	$typearr = getarttype_tree($pid);//所有分类
	 
 	ssetcookie('artcookienowurl',$_SGLOBAL['operate_nowurl']);
 
}elseif($_GET['op']=='addtype'){//添加类别
	if($_GET['tid']>0)
	$ctypearr = $_SGLOBAL['db']->getone("select * from ".tname('article_type')." where id='$_GET[tid]'");
 	$prexarr[0] = substr(str_replace("|",'>',$ctypearr['tname']),0,-1);
	$arttype['pid']=$ctypearr['id'];
	$arttype['degree'] = $ctypearr['degree']+1;
	
}elseif($_GET['op']=='edittype' && $_GET['id']>0){//编辑类别
	$arttype = $_SGLOBAL['db']->getone("select * from ".tname('article_type')." where id='$_GET[id]'");
 	$prexarr=getprex($arttype);
	$arttype['tname'] =$prexarr[1];
 	
}elseif($_GET['op']=='editflag' && $_GET['id']>0){
	$artflag = $_SGLOBAL['db']->getone("select * from ".tname('article_diyflag')." where id='$_GET[id]'");
	
}elseif($_GET['op']=='flaglist'){
	$flagarr = $_SGLOBAL['db']->getall("select * from ".tname('article_diyflag')."  order by id asc");
	ssetcookie('artcookienowurl',$_SGLOBAL['operate_nowurl']);
}
 function getprex($arttype){
 		$arttarr = explode("|",$arttype['tname']);
		$count = count($arttarr);
		$prex='';
		$tname = $arttarr[$count-2];
		for($i=0;$i<$count-2;$i++){
			$prex .= $prex=='' ? $arttarr[$i] : '>'.$arttarr[$i];
		}
		return array($prex,$tname);
 }
 
?>