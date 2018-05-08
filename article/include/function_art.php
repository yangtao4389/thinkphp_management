<?

//获得内容
function _getart_content($id,$page=0){
	global $_SGLOBAL;
	$pagestr=''; $perflag = '#page#'; $mpurl = 'article.php?ac=content&id='.$id;
 	//获取内容
	$content = $_SGLOBAL['db']->getone("select * from ".tname('article_content')." where id='$id'");
	if(!$content)return '';
 	if(!strpos($content['content'],$perflag))return $content;
	  
	//计算页数
	$contentarr = explode($perflag,$content['content']);
	$totalpage = count($contentarr);

	$page = min($page,$totalpage);
	
	if($page<1)$page=1;
	$pagestr = multi($totalpage, 1, $page, $mpurl);
	
	if($_GET['preview']!=1)$pagestr = preg_replace("/article\.php\?ac=content&id=([0-9]+)&page=([0-9]+)/i","article_$1_$2.html",$pagestr);
	
	$content['pagestr']=$pagestr;
 	$content['content'] = $contentarr[$page-1];
	return $content;
}

?>