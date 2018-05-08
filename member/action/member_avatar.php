<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp_avatar.php 13149 2009-08-13 03:11:26Z liguode $
*/

!defined('IN_WEB') && exit('Access Denied');

if(submitcheck('avatarsubmit')) {
	showmessage('修改', 'member.php?ac=avatar', 0);
}
//头像
@include_once MEMBER_ROOT.'/../uc_client/client.php';
$uc_avatarflash = uc_avatar($_SGLOBAL['super_uid'], (empty($_SCONFIG['avatarreal'])?'virtual':'real'));

//判断用户是否设置了头像
echo "<img src=http://uc.localhost/avatar.php?uid=".$_SGLOBAL['super_uid']."&size=big/>
";
$avatar_exists = ckavatar($_SGLOBAL['super_uid']);
if($avatar_exists) {
echo "上传了头像";
}
else{
	echo "修改头像";
	}

include template("avatar");

?>