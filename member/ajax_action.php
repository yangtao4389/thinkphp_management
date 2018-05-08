<?
include_once dirname(__FILE__).'/config.php';
set_time_limit(0);
if($_POST['ac']=='reg'){//注册页面ajax

	if($_POST['op']=='checkname'){
		if(!preg_match("/^[a-zA-Z_0-9]{4,20}$/",trim($_POST['username'])) )exit('<font color="#ff0000">错误:用户名只允许4-20字母数字下划线的组合</font>');
		
		
		if(defined('UC_API') && @include_once dirname(__FILE__).'/../uc_client/client.php'){
		
	$isreg = uc_user_checkname(trim($_POST['username']));
		if($isreg!=1){
		exit('<font color="#ff0000">错误:用户名已占用</font>');
		}
		else{
			exit('正确');
		}
	}
		
		
	}
}
exit;
?>