<?
!defined('IN_ADMIN') && exit('Access Denied');
include_once(dirname(__FILE__)."/../config.php");
//处理ajax请求
if($_GET['op']=='getbanner' && $_GET['adid']>0){//获得账户余额
		$adinfo = $_SGLOBAL['db']->getone("select al.*,asize.adwidth,asize.adheight,asize.pvnum,asize.ipnum from ".tname('member_adlist')." al left join ".tname('member_adsize')." asize  on al.adsizeid=asize.id where al.id='$_GET[adid]'");
	 
 		$adinfo['userbalance'] = getader_balance($adinfo['aderid'],1);//广告主当前余额
		$html = '<b>广告标题:</b>'.$adinfo['adtitle'].'&nbsp;<b>广告类型:</b>'.$adinfo['adtype'].'&nbsp;<b>广告尺寸:</b>'.$adinfo['adwidth']."*".
		 	    $adinfo['adheight'].'<b>广告价格:</b>'.$adinfo['adprice'].'元/'.$adinfo['adpernum']."次&nbsp;<br><b>已投放量:</b>".$adinfo['usedputs']."<b>拥有量(pv/ip):</b>".$adinfo['pvnum']."/".$adinfo['ipnum'];
		exit($html);		
}

?>