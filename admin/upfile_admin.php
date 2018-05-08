<?
!defined('IN_ADMIN') && exit('Access Denied');
$cookienowurl  = empty($_SCOOKIE['cookienowurld']) ? "admincp.php?ac=upfile" : $_SCOOKIE['cookienowurld'];
include_once(WEB_ROOT."./include/tools/image/uploadfile.class.php");
if(submitcheck('upfilesubmit')){
	if(!$_FILES['fileup'] && !$_FILES['fileswf'])showmessage('请选择要上传的文件');
	$obj_img = new uploadfile();
	$obj_img->setuploaddir(WEB_ROOT,$_SCONFIG['uploadpicpath']);
	if($_POST['uptype']==1){//图片
		$arr = $obj_img->uploadmoreimg($_FILES["fileup"]);
 	}else{//flash
		$arr = $obj_img->uploadimg($_FILES['fileswf'], 2);
	}
	if($_POST['pele']){//需要把当前图片路径设置到输入框中
	?>
	<script language="javascript">
		window.opener.document.getElementById('<?=$_POST['pele']?>').value='http://imgcode.2366.com<?=str_replace('distribdata','',$arr[0][1])?>';
	</script>
	
	<?
	echo '<b>上传成功!请关闭当前窗口</b><script language="javascript">window.close();</script>';
	

	}else{
		showmessage('上传成功',$cookienowurl);
	}	
		exit;
}

if($_GET['op']=='del'){
	if($_GET['imgid']>0){
		$arr = $_SGLOBAL['db']->getone("select * from ".tname('imagelog')." where id='$_GET[imgid]'");
		$_SGLOBAL['db']->query("delete from ".tname('imagelog')." where id='$_GET[imgid]'");
		@unlink(WEB_ROOT.$arr['uploadpath']);
	}
	showmessage('删除操作成功',$cookienowurl);
}elseif($_GET['op']=='filelist'){
	$perpage = 10;$mpurl = 'admincp.php?ac=upfile&op=filelist&username='.$_GET['username']."&imgwh=".$_GET['imgwh'];
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	if($page<1) $page = 1;
	$start = ($page-1)*$perpage;
  	$cond = '';
	$cond .= $_GET['username'] ? " and username='$_GET[username]'" : '';
	$cond .= $_GET['imgwh'] ? " and imgwh='$_GET[imgwh]'" : '';
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select count(*) from ".tname('imagelog')." where 1".$cond),0);
   	$filelistarr = $_SGLOBAL['db']->getall("select * from ".tname('imagelog')." where 1 $cond order by id desc limit $start,$perpage");
	$multi = multi($count, $perpage, $page, $mpurl);//分页字符串
 	//获得尺寸列表
	$imgwharr = $_SGLOBAL['db']->getall("select distinct imgwh from ".tname('imagelog')." order by id desc");
  	ssetcookie('cookienowurld',$_SGLOBAL['operate_nowurl']);
}
?>