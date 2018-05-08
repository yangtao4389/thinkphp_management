<?
//更新指定路径缓存
function cache_makehtml($url){
	$cmd = WEB_ROOT."/../scripts/bin/squidpurge.sh ".$url;
	$rtstr = system($cmd); 
	return $rtstr;
}

/**
 * 获得类别url
 * @param $tid
 * @return unknown_type
 */
function gettypeurl($tid){
	global $_SGLOBAL,$_SCONFIG;
	$typeinfo = $_SGLOBAL['db']->getone("select * from ".tname('article_type')." where tid='$tid'");
  	$seachar = array('[Y]', '[m]', '[d]', '[tid]');
	$repchar = array(date("Y"), date("m"), date("d"), $typeinfo['id']);
	$typeurl  = str_replace($seachar, $repchar, $typearr['domainname'].$typearr['contentdir']);
	return $typeurl;
}

/**
 * 获得文章地址
 * @param $aid
 * @return unknown_type
 */
function getarticle_url($id){
	global $_SGLOBAL,$_SCONFIG;
	//获得文章信息
	$artarr = $_SGLOBAL['db']->getone("select tid from ".tname('article_content')." where id='$id'");
	if(!$artarr)return '';
	$typearr = $_SGLOBAL['db']->getone("select * from ".tname('article_type')." where id='".$artarr['tid']."'");
 	$seachar = array('[Y]', '[m]', '[d]', '[aid]', '[tid]');
	$repchar = array(date("Y"), date("m"), date("d"), $id, $typearr['id']);
	$arturl = $artdomain.str_replace($seachar, $repchar, $typearr['domainname'].$typearr['contentdir']);
 	return $arturl;
}
function getchildidlist($tid=0){
	global $_SGLOBAL;
	//获得此分类的下级分类
	$_tidlist= $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select tidlist from ".tname('article_type')." where id='$_GET[tid]'"),0);
	$tidlist = $_SGLOBAL['db']->getall("select id from ".tname('article_type')." where tidlist like '$_tidlist%'");
	$tt='';
	foreach($tidlist as $value){
		$tt.= $tt=='' ? $value['id'] : ','.$value['id']; 
 	}
	 
	$tt || $tt = 0;
	  
	return $tt;
}
/**
 * 获得类别树
 * @param $pid
 * @return unknown_type
 */
function getarttype_tree($pid=-1,$showstyle='gif'){
	global $_SGLOBAL;
	$cond="";
	$cond .= $pid!=-1 ? " and pid='$pid'" : '';
	$typelist = $_SGLOBAL['db']->getall("select * from ".tname('article_type')." where 1=1 $cond order by tidlist asc,torder asc");
	foreach($typelist as $key=>$value){
		$tnamearr = explode("|",$value['tname']);
		$typelist[$key]['ctypename'] = $tnamearr[$value['degree']-1];
		$typelist[$key]['typenbsp'] = '';
		for($i=0;$i<$value['degree']-1;$i++){
			$typelist[$key]['typenbsp'] .='&nbsp;&nbsp;';
		}
		if($value['degree']>1)$typelist[$key]['typenbsp'].= $showstyle=='gif' ? '<img src="admin/images/treeview/tv-item-last.gif" />' : '|_';
		$typelist[$key]['typenbsp'] .=  $showstyle=='gif' ? '<img src="admin/images/treeview/folder.gif" />' : '';
	}
	return $typelist;
}
//获得导航条
function _getartnav($typeinfo){
	$navstr='';
	$tidarr = explode(',',$typeinfo['tidlist']);
	$tnamearr = explode('|',$typeinfo['tname']);
	$tcount = count($tnamearr)-1;
	$navstr = '';
	for($i=0;$i<$tcount;$i++){
		$navstr .= '<a href="list.php?tid='.$tidarr[$i].'"><b>'.$tnamearr[$i].'</b></a>>';
	}
	return $navstr;
}

 //文章模块基本标签函数
/**
 * @param $tid
 * @param $orderby 默认senddt desc
 * @param $limit 
 * @param $where 自定义where语句
 * @return unknown_type
 */
function artlist_lib($tid=0,$orderby='',$limit=10,$where=''){
	global $_SGLOBAL;
	$orderby || $orderby = ' senddt desc';
	$typearr = $_SGLOBAL['db']->getall("select * from ".tname('article_type')." where tidlist like '$tid,%' order by tidlist asc");
	$tidlist = $comma = '';
 
	foreach($typearr as $value){
 		$tidlist .= $comma.$value['id'];
		$comma=',';
	}
	$cond = '';
	$cond .= $tid>0 ? " and tid in($tidlist)" : '';
	$artlist = $_SGLOBAL['db']->getall("select * from ".tname('article_content').
							"  where 1=1 $cond $where order by $orderby limit $limit");
	
	return $artlist;
}




?>