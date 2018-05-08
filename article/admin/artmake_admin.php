<?
!defined('IN_ADMIN') && exit('Access Denied');
include_once(dirname(__FILE__)."/../config.php");
$barr = array(
	'arttype'=>$_SCONFIG['baseconfig']['weburl']."newlist/list_[tid]_[page].html",
	'article'=>$_SCONFIG['baseconfig']['weburl']."zixun/article_[id].html"
);
if($_GET['op']=='makearttype'){//生成文章列表页
	if($_GET['arttid']>0){//生成单个分类
		make_arttype($_GET['arttid'],$_GET['mpagenum']);
		showmessage("更新单个类别完成!");
	 }else{//更新所有类别
	 	$perpage=10;
		$page = empty($_GET['page'])?1:intval($_GET['page']);
		if($page<1) $page = 1;
		$start = ($page-1)*$perpage;
	 	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select count(id) from ".tname('article_type')),0);
	 	$_arttarr=$_SGLOBAL['db']->getall("select id,tname from ".tname('article_type')." order by id asc limit  $start,$perpage");
		$totalpage = ceil($count/$perpage);
	 	foreach($_arttarr as $val){
			make_arttype($val['id'],$_GET['mpagenum']);
		}
		if($page>=$totalpage){
			showmessage("生成所有分类完成",$baseurl."&ac=artmake&op=marttypelist");
		}
		showmessage("生成完第".$page."页，共".$totalpage."页",$baseurl."&ac=artmake&op=makearttype&page=".($page+1));
	 }
	 
}elseif($_GET['op']=='makeartlist'){//生成文章页面
	
	$cond = " and "
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select count(id) from ".tname('article_content')." "),0);
   	$artarr = $_SGLOBAL['db']->getall("select art.*,fl.flagname from ".tname('article_content')." art left join ".tname('article_diyflag')." fl on art.diyflag=fl.id  where 1 ".$cond." order by id asc  limit  $start,$perpage");
	
	$mpurl = $baseurl."&ac=artmake&op=makeartlist&page=".($page+1)."&startdt=".$_GET['startdt']."&enddt=".$_GET['enddt'];
	
	
}elseif($_GET['op']=='martlist'){
	$startdt = $enddt = date("Y-m-d");
}

function make_arttype($tid=0,$pagenum=2){
	global $barr;
	for($i=1;$i<=$pagenum;$i++){
			$sarr  = array('[tid]','[page]');
			$rparr = array($tid,$i);
			$url = str_replace($sarr,$rparr,$barr['arttype']);
			cache_makehtml($url);			
	}
}
$arttarr =  getarttype_tree($_GET['tid'],'str');//所有分类

?>