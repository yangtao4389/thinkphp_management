<?
include_once(dirname(__FILE__)."/common.inc.php");
include_once(WEB_ROOT."/include/tools/image/uploadfile.class.php");

if($_REQUEST['ac']=='imageupload'){

	$file_name = trim($_FILES['imgFile']['name']);
	if(!$file_name)alert("请选择文件。");
	$obj_img = new uploadfile();
	$obj_img->setuploaddir(WEB_ROOT,'distribdata/uploadpic/');
	$farr = $obj_img->uploadimg($_FILES["imgFile"]);
 
	if($_POST['iswater']==1){
		image_watermark(WEB_ROOT.$farr[1],9,WEB_ROOT.$_SCONFIG['waterpath']);
	}
	
	if($farr[0]>0){
 		echo json_encode( array('error' => 0, 'url' => "/".$farr[1]) );
 	}else{
		alert("上传失败!".$farr[0]);
	}
	exit; 
}
function alert($msg) {
 	echo json_encode(array('error' => 1, 'message' => $msg));
	exit;
}
?>