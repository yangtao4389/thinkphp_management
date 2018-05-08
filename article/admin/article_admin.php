<?
!defined('IN_ADMIN') && exit('Access Denied');
include_once(dirname(__FILE__)."/../config.php");
$artcookienowurl  = empty($_SCOOKIE['artcookienowurl']) ? $baseurl."&ac=article" : $_SCOOKIE['artcookienowurl'];


if(submitcheck('articlesubmit')){
	$_POST['article']['title'] || showmessage('请填写标题');
	$_POST['article']['author'] ||$_POST['article']['author']=$_SGLOBAL['member']['baseinfo']['writename'];
   	if($_POST['artid']>0){
		updatetable('article_content',$_POST['article']," id='$_POST[artid]'");
  	}else{
		$_POST['article']['adddt'] = date("Y-m-d H:i:s");
		if($_POST['article']['pubdt']){
			$_POST['article']['pubdt'] = $_POST['article']['pubdt'];
		}else{
			$_POST['article']['pubdt'] = date("Y-m-d H:i:s");
		}
		$_POST['article']['adminname'] = $_SGLOBAL['super_username'];
		$ishave = $_SGLOBAL['db']->getone('select * from '.tname('article_content')." where title='".$_POST['article']['title']."'");
   		$ishave && showmessage('此标题已经存在');
 		inserttable('article_content',$_POST['article']);
 	}
	showmessage('操作成功',$artcookienowurl);
}


if($_GET['op']=='del'){
	if($_GET['artid']>0){
 		$_SGLOBAL['db']->query("delete from ".tname('article_content')." where id='$_GET[artid]'");
		$_SGLOBAL['db']->query("delete from ".tname('article_content_1')." where artid='$_GET[artid]'");
	}
	showmessage('删除成功',$artcookienowurl);
	
}elseif($_GET['op']=='addarticle'){
	$_GET['tid']>0 && $article['tid'] = $_GET['tid'];//添加文章
	$etypearr = getarttype_tree(-1,'str');
	 

}elseif($_GET['op']=='editarticle' && $_GET['id']>0){//编辑文章
	$article = $_SGLOBAL['db']->getone("select * from ".tname('article_content')." where id='$_GET[id]'");
  	$etypearr = getarttype_tree(-1,'str');
	
}elseif($_GET['op']=='artlist'){//文章列表
	$perpage = 30;
	 
 	$mpurl = $baseurl.'&ac=article&op=artlist&diyflag='.$_GET['diyflag'].
	"&orderby=".$_GET['orderby']."&tid=".$_GET['tid']."&title=".$_GET['title']."&own=".$_GET['own'];
	
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	if($page<1) $page = 1;
	$start = ($page-1)*$perpage;
  	$cond = '';
	if($_GET['tid']>0)$cond .= " and art.tid in(".getchildidlist($_GET['tid']).")";
 	$cond .= $_GET['diyflag'] ? " and art.diyflag='$_GET[diyflag]'" : " ";
	if($_GET['own']==1){
		$cond .= " and art.adminname='$_SGLOBAL[super_username]'";
	}else{
		$cond .= $_GET['adminname'] ? " and art.adminname='$_GET[adminname]'" : " ";//查看某个人的
	}
 	$cond .= $_GET['title'] ? " and art.title like '%".$_GET['title']."%'" : "";
	
	$_GET['orderby'] || $_GET['orderby'] = 'art.id desc';
 	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select count(art.id) from ".tname('article_content')." art where 1 ".$cond),0);
   	$artarr = $_SGLOBAL['db']->getall("select art.*,fl.flagname from ".tname('article_content')." art left join ".tname('article_diyflag')." fl on art.diyflag=fl.id  where 1 ".$cond." order by $_GET[orderby]  limit  $start,$perpage");
	 
	$multi = multi($count, $perpage, $page, $mpurl);//分页字符串
 	if($_GET['tid']>0)
	$nowtypeinfo = $_SGLOBAL['db']->getone("select * from ".tname('article_type')." where id='$_GET[tid]'");
	$tidarr = explode(',',$nowtypeinfo['tidlist']);
	$tnamearr = explode('|',$nowtypeinfo['tname']);
	$tcount = count($tnamearr)-1;
	$navstr = '';
	for($i=0;$i<$tcount;$i++){
		$navstr .= '<a href="'.$baseurl.'&ac=article&op=artlist&tid='.$tidarr[$i].'"><b>'.$tnamearr[$i].'</b></a>>';
	}
	ssetcookie('artcookienowurl',$_SGLOBAL['operate_nowurl']);
}
$flaglist = $_SGLOBAL['db']->getall("select * from ".tname('article_diyflag')." order by id asc");
$_GET['tid'] || $_GET['tid'] = 0;
$typearr = getarttype_tree($_GET['tid'],'str');//所有分类
 
 
?>