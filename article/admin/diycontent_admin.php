<?php
!defined('IN_ADMIN') && exit('Access Denied');//文章内容自定义
include_once(dirname(__FILE__)."/../config.php");
$diycontenturl  = empty($_SCOOKIE['cookienowurl']) ? $baseurl."&ac=member" : $_SCOOKIE['cookienowurl'];

if(submitcheck('typesubmit')){//发布位置
	if(empty($_POST['ptype']['typename']))showmessage('请填写名称');
	foreach($_POST['ptype'] as $key=>$value){
		$_POST['ptype'][$key] = trim($value);
	}
	if($_POST['typeid']){
		updatetable('article_placetype',$_POST['ptype'],array('id'=>intval($_POST['typeid'])) );
	}else{
 		inserttable('article_placetype',$_POST['ptype']);
	}
	showmessage('操作成功',$diycontenturl);
}elseif(submitcheck('contentsubmit')){//发布内容
	if(empty($_POST['pcontent']['ptid']) ||  empty($_POST['pcontent']['title']))showmessage("类别和标题id不能为空!");
	$_POST['pcontent']['diydt'] = empty($_POST['pcontent']['diydt']) ? time() : strtotime($_POST['pcontent']['diydt']);
 	$_POST['pcontent']['adddt'] = time();
	$_POST['pcontent']['prow']==0 || $_POST['pcontent']['prow']=1;
	if($_POST['contentid']>0){
			updatetable('article_placecontent', $_POST['pcontent'], array('id'=>intval($_POST['contentid'])) );
	}else{//添加时
 		if($_POST['dellast'] && $_POST['pcontent']['prow']==1){//删除最后一条
 			//自增一
			$_SGLOBAL['db']->query("update ".tname('article_placecontent')." set prow=prow+1 where ptid='".$_POST['pcontent']['ptid']."'");
			$_SGLOBAL['db']->query("delete from ".tname('article_placecontent')." where ptid='".$_POST['pcontent']['ptid']."'  order by prow desc,adddt asc limit 1");
		}
		inserttable('article_placecontent',$_POST['pcontent']);
	}
  	showmessage('添加内容成功',$diycontenturl);
}



if($_GET['op']=='del'){//删除 
 	if($_GET['contentid']>0){
		//获取本id的类别
	  $ptid = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select ptid from ".tname('article_placecontent')." where id='$_GET[contentid]'"),0);
	  $_SGLOBAL['db']->query("delete from ".tname('article_placecontent')." where id='$_GET[contentid]'");
		
	}elseif($_GET['typeid']>0){
 		$_SGLOBAL['db']->query("delete from ".tname('article_placetype')." where id='$_GET[typeid]'");
			
 	}
	showmessage('删除成功',$diycontenturl);

}elseif($_GET['op']=='typeedit' && $_REQUEST['typeid']>0){//编辑位置
 	$ptype = $_SGLOBAL['db']->getone("SELECT * FROM ".tname('article_placetype')." WHERE id='$_REQUEST[typeid]'");
	//placetype表的字段
	$fieldarr =$_SGLOBAL['db']->getall("describe ".tname('article_placecontent'));
}elseif($_GET['op']=='typeadd'){
	//placetype表的字段
	$fieldarr =$_SGLOBAL['db']->getall("describe ".tname('article_placecontent'));
}elseif($_GET['op']=='contentadd'){//添加内容
  	$pcontent['diydt'] = $pcontent['adddt'] = time();
	$pcontent['prow']=1; $pcontent['ptid']=$_GET['ptid']; 
	if($_GET['ptid']){
		$pcontent['ptid'] = $_GET['ptid'];
 		$_ptarr = $_SGLOBAL['db']->getone("select * from ".tname('article_placetype')." where id='$_GET[ptid]'");
		if($_ptarr['defaultvalue']){
			$_dfarr = explode(",",$_ptarr['defaultvalue']);
			foreach($_dfarr as $key=>$value){
				$_fv = explode("|",$value);//pic|http://abc.com/1.gif
				$pcontent[$_fv[0]] = $_fv[1];
			}
		}
		$disfarr=array();
		if($_ptarr['displayfield']){
			$_dsfarr = explode(",",$_ptarr['displayfield']);
			foreach($_dsfarr as $key=>$value){
				$_dfv = explode("|",$value);
				$disfarr[$_dfv[0]] = $_dfv[1];
			}
		}	 
	}//end ptid
	if($_GET['field1'])$pcontent['field1']=$_GET['field1']; 
	
}elseif($_GET['op']=='contentedit'&&$_REQUEST['contentid']>0){//编辑内容

	$contentid = $_GET['contentid']>0 ? $_GET['contentid'] : $_POST['contentid'];
 	$query = $_SGLOBAL['db']->query("select * from ".tname('article_placecontent')." where id='$contentid'");
	$pcontent = $_SGLOBAL['db']->fetch_array($query);	
	$query = $_SGLOBAL['db']->query("select * from ".tname('article_placetype')." where id='$pcontent[ptid]'");
	$_ptarr = $_SGLOBAL['db']->fetch_array($query);
	$disfarr=array();
	if($_ptarr['displayfield']){
		$_dsfarr = explode(",",$_ptarr['displayfield']);
		foreach($_dsfarr as $key=>$value){
			$_dfv = explode("|",$value);
			$disfarr[$_dfv[0]] = $_dfv[1];
		}
	}
	
}elseif($_GET['op']=='typelist'){

	ssetcookie('cookienowurl',$_SGLOBAL['operate_nowurl']);
}elseif($_GET['op']=='contentlist'){//列出当前内容
 	
  	$ptid =$_GET['ptid'];
	if($ptid<1){
	$ptid = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select id from ".tname('article_placetype')." order by id asc limit 1"),0);
	 }
 	
 	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('article_placecontent')." WHERE ptid='$ptid'   order by prow asc, diydt desc");
	$qcarr = array();
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$qcarr[] = $value;
	}
	 
 	ssetcookie('cookienowurl',$_SGLOBAL['operate_nowurl']); 
}


 
//位置列表
$typearr = $_SGLOBAL['db']->getall("select * from ".tname('article_placetype')." order by porder asc, id asc ");
 


?>