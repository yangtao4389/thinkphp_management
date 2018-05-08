<?
include_once(dirname(__FILE__).'/config.php');
if($_GET['pflag']==1){
	$obj = _get_province_city(1);
	echo json_encode($obj);
	exit;
}elseif($_GET['pflag']==2){
	$obj = _get_province_city(2);
	echo json_encode($obj);
	exit;
}

function _get_province_city($pflag=1){
	global $_SGLOBAL;
	$parr = $_SGLOBAL['db']->getall('select * from '.tname('city')." where pflag='$pflag'");
 	$obj = new stdclass();
	$obj->province=array();
	$obj->city=array();
	foreach($parr as $key=>$value){
		
		$sarr = array('name'=>$value['pname'],'code'=>$value['pcode']);
		if($value['pflag']==1){
			$obj->province[] = (object)$sarr;
		}else{
			$obj->city[] = (object)$sarr;
		}
	}
 	return $obj;
}
?>