<?php if(!defined('IN_WEB')) exit('Access Denied');?><div id="body">
    <div class="space">
<?php if($_GET['op']=='updatepwd') { ?>
<div class="subtitle">修改密码</div>
 	<form method="post" action="admincp.php?ac=admin">
        <table class="maintable" border="0" cellspacing="0" cellpadding="0">
 <tr>
                <td width="10%" class="altbg1"><strong>笔名:</strong></td>
                <td><input type="text" name="writename" value="<?=$uuinfo['writename']?>" /></td>
            </tr>
            <tr>
                <td width="10%" class="altbg1"><strong>旧密码:</strong></td>
                <td><input type="password" name="oldpassword" /></td>
            </tr>
             <tr>
                <td class="altbg1"><strong>新密码:</strong></td>
                <td><input type="text" name="newpassword" /></td>
            </tr>
        </table>	 
        <center><input type="submit" name="updatepwdsubmit" value=" 提交 " class="btn" /></center>
</form>

    <?php } elseif($_GET['op']=='adminlist') { ?><!--管理员列表--> 
 <div class="subtitle">管理员列表</div>
 	    <table class="maintable" border="0" cellspacing="0" cellpadding="0">
<tr class="altbg2">
                <th colspan="5">
                    <ul class="subtab"><li <?php if(!isset($_GET['gid'])|| $_GET['gid']==0 ) { ?>class="current"<?php } ?>><a href="admincp.php?ac=admin&op=adminlist">全部</a></li> 
<?php if(is_array($usergrouparr)) { foreach($usergrouparr as $value) { ?>
                        <li <?php if($_GET['gid']==$value['gid']) { ?>class="current"<?php } ?>><a href="admincp.php?ac=admin&op=adminlist&gid=<?=$value['gid']?>"><?=$value['groupname']?></a></li>
<?php } } ?>
                     </ul>                </th>
            </tr>
<?php if($_GET['gid']>0) { ?>
<tr><td colspan="5"><?=$currentgroup['descript']?></td></tr>
<?php } ?>
            <tr class="altbg1">
                <td width="20">ID</td>
                <td>用户名</td>
                <td>最后登录时间</td>
                <td>最后登录ip</td>
                <td>操作</td>
            </tr>
            <?php if(is_array($adminarr)) { foreach($adminarr as $val) { ?>
     
             <tr>
                <td><?=$val['uid']?></td>
                <td><a href="admincp.php?ac=admin&op=edituser&uid=<?=$val['uid']?>"><?=$val['username']?></a></td>
                <td><?php echo newdate($val['lastlogintime'],'Y-m-d H:i:s'); ?></td> 
                <td><?=$val['lastloginip']?></td>
                <td>
<a href="admincp.php?ac=admin&op=edituser&uid=<?=$val['uid']?>">修改</a>&nbsp;
<?php if($val['uid']>1) { ?>
  				<a href="admincp.php?ac=admin&op=del&uid=<?=$val['uid']?>" onClick="return window.confirm('确认要删除此用户吗？');">删除</a><?php } ?> 			  </td>
            </tr>
           <?php } } ?> 
          <tr>
               <td colspan="5"><input type="button" class="btn"  onClick="location.href='admincp.php?ac=admin&op=adduser';" value="新增用户"><?php if($_SGLOBAL['super_username']=='admin') { ?><a href="admincp.php?ac=admin&op=adminlog">后台管理日志</a><?php } ?></td>
             </tr>
      </table>
<?php } elseif($_GET['op']=='adminlog') { ?><!--管理日志-->
 <div class="subtitle">管理日志列表</div>
 <table class="maintable" border="0" cellspacing="0" cellpadding="0">
 	<?php if(is_array($logarr)) { foreach($logarr as $val) { ?>
  <tr><td><a href="data/adminlog/<?=$val?>"><?=$val?></a></td></tr>
<?php } } ?>
</table>
<?php } elseif($_GET['op']=='usergroup') { ?>
 <div class="subtitle">用户组列表</div>
 <table class="maintable" border="0" cellspacing="0" cellpadding="0">
             <tr class="altbg1">
                <td width="20">ID</td>
                <td>用户组名</td>
                <td>操作</td>
            </tr>
            <?php if(is_array($usergrouparr)) { foreach($usergrouparr as $val) { ?>
              <tr>
                <td><?=$val['gid']?></td>
                <td><a href="admincp.php?ac=admin&op=setperm&gid=<?=$val['gid']?>"><?=$val['groupname']?></a></td>
                <td>
  <a href="admincp.php?ac=admin&op=editgroup&gid=<?=$val['gid']?>">修改</a>&nbsp;
  <a href="admincp.php?ac=admin&op=setperm&gid=<?=$val['gid']?>">设置权限</a>&nbsp;
  				  <a href="admincp.php?ac=admin&op=del&gid=<?=$val['gid']?>" onClick="return window.confirm('确认要删除此用户组吗？');">删除</a> 			  													     			</td> 
            </tr>
           <?php } } ?>
     <tr class="altbg1">
               <td colspan="3"><input type="button" class="btn"  onClick="location.href='admincp.php?ac=admin&op=addgroup';" value="新增用户组"></td>
             </tr>
                       </table>
<?php } elseif($_GET['op']=='actionlist') { ?><!--动作列表-->
 <div class="subtitle">动作列表</div>
 <table class="maintable" border="0" cellspacing="0" cellpadding="0">
 <tr class="altbg2">
                <th colspan="4">
                    <ul class="subtab">
<?php if(is_array($modarr)) { foreach($modarr as $value) { ?>
                        <li <?php if($_GET['umodule']==$value['umodule']) { ?>class="current"<?php } ?>><a href="admincp.php?ac=admin&op=actionlist&umodule=<?=$value['umodule']?>"><?=$value['umodule']?></a></li>
<?php } } ?>
                    </ul>                </th>
            </tr>
             <tr class="altbg1">
                <td width="20">ID</td>
                <td>动作名</td>
                <td>地址</td>
                <td>操作</td>
            </tr>
            <?php if(is_array($actionlistarr)) { foreach($actionlistarr as $val) { ?>
             <tr>
                <td><?=$val['acid']?></td>
                <td><a href="admincp.php?ac=admin&op=editaction&acid=<?=$val['acid']?>"><?=$val['title']?></a></td>
                <td>admincp.php?mod=<?=$val['umodule']?>&ac=<?=$val['uaction']?>&op=<?=$val['uoperat']?> </td>
                <td>
  <a href="admincp.php?ac=admin&op=editaction&acid=<?=$val['acid']?>">修改</a>&nbsp;
   				  <a href="admincp.php?ac=admin&op=del&acid=<?=$val['acid']?>" onClick="return window.confirm('确认要删除此动作吗？');">删除</a> 			  													     			</td> 
             </tr>
           <?php } } ?>
     <tr class="altbg1">
               <td colspan="4"><input type="button" class="btn"  onClick="location.href='admincp.php?ac=admin&op=addaction';" value="新增动作"></td>
             </tr>
        </table>
<div class="tab"><div class="pages"><?=$multi?></div></div>

<?php } elseif($_GET['op']=='setperm') { ?><!--权限设置-->
<style>
.maintable span{
cursor:pointer;}
</style>
<div class="subtitle"><?=$grouparr['groupname']?> 权限设置</div>
<form method="post" action="admincp.php?ac=admin">
 <table class="maintable" border="0" cellspacing="0" cellpadding="0">
 <tr><td><?=$grouparr['descript']?></td></tr>
 <?php if(is_array($modarr)) { foreach($modarr as $value) { ?>
 	<tr class="altbg1"><td><?=$value['uaction']?> .php</td></tr>
<tr><td>
<?php if(is_array($value['aclist'])) { foreach($value['aclist'] as $value1) { ?>
<span title="admincp.php?mod=<?=$value1['umodule']?>&ac=<?=$value1['uaction']?>&op=<?=$value1['uoperat']?>"><input type="checkbox" name="aclist[]" value="<?=$value1['acid']?>" <?php if(in_array($value1['acid'],explode(',',$grouparr['aclist'])) ) { ?> checked="checked"<?php } ?>><?=$value1['title']?></span>&nbsp;
<?php } } ?>
</td></tr>
 <?php } } ?>
 </table><input type="hidden" value="<?=$_GET['gid']?>" name="gid">
   <center><input type="submit" name="permsubmit" value=" 提交 " class="btn" /></center>
 </form>

<?php } elseif($_GET['op']=='adduser' || $_GET['op']=='edituser') { ?><!--添加编辑用户-->
 <div class="subtitle">用户信息</div>
 	<form method="post" action="admincp.php?ac=admin">
        <table class="maintable" border="0" cellspacing="0" cellpadding="0">

            <tr>
                <td width="20%" class="altbg1"><strong>用户名:</strong></td>
                <td><input type="text" name="memberarr[username]" <?php if($_GET['op']=='edituser') { ?> readonly="1" <?php } ?>class="txtbox" value="<?=$memberarr['username']?>" /></td>
            </tr>
             <tr>
                <td class="altbg1"><strong>密码:</strong></td>
                <td><input type="text" name="password" class="txtbox"   /></td>
            </tr>
<tr>
<td class="altbg1"><strong>权限:</strong></td>
                <td>是否管理员
<select name="memberarr[isadmin]">
<option value="0">否</option>
<option value="1" <?php if($memberarr['isadmin']==1) { ?>selected <?php } ?>>是</option>
</select>用户组
<select name="memberarr[gid]">
<?php if(is_array($usergrouparr)) { foreach($usergrouparr as $val) { ?>
<option value="<?=$val['gid']?>" <?php if($val['gid']==$memberarr['gid']) { ?>selected<?php } ?>><?=$val['groupname']?></option>
<?php } } ?>
</select>前台身份<select name="memberarr[usertype]">
<option value="1">广告主</option>
<option value="2" <?php if($memberarr['usertype']==2) { ?>selected<?php } ?>>网站主</option>
</select></td>
</tr>
  			<tr>
                <td class="altbg1"><strong>网站安全码:</strong></td>
                <td><input type="text" name="safecode" class="txtbox" />提示:名分明</td>
            </tr>
       </table>	<input type="hidden" name="memberid" value="<?=$memberarr['uid']?>">
        <center><input type="submit" name="usersubmit" value=" 提交 " class="btn" /></center>
</form>
  
<?php } elseif($_GET['op']=='addgroup' || $_GET['op']=='editgroup' ) { ?><!--添加编辑用户组-->
 <div class="subtitle">添加编辑用户组</div>
<form method="post" action="admincp.php?ac=admin">
        <table class="maintable" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="20%" class="altbg1"><strong>用户组名:</strong></td>
                <td><input type="text" name="usergroup[groupname]" class="txtbox" value="<?=$usergroup['groupname']?>" /></td>
            </tr>
              <tr>
                <td class="altbg1"><strong>描述:</strong>做个简短描述方便识别</td>
                <td><textarea name="usergroup[descript]" rows="5" cols="40" class="txtarea"><?=$usergroup['descript']?></textarea>
<input type="hidden" name="groupid" value="<?=$usergroup['gid']?>"></td>
            </tr>
        </table>
        <center><input type="submit" name="usergroupsubmit" value=" 提交 " class="btn" /></center>
</form>

<?php } elseif($_GET['op']=='addaction' || $_GET['op']=='editaction' ) { ?><!--添加编辑动作-->
 <div class="subtitle">添加编辑动作</div>
<form method="post" action="admincp.php?ac=admin">
        <table class="maintable" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="20%" class="altbg1"><strong>动作标题:</strong></td>
                <td><input type="text" name="actionarr[title]" class="txtbox" value="<?=$actionarr['title']?>" /></td>
            </tr>
              <tr>
                <td class="altbg1"><strong>设置权限的地址:</strong>mod不填写默认为admin,若不填写op则控制此ac的所有权限</td>
                <td><input  type="text" name="actionurl"  size="80" value="admincp.php?mod=<?=$actionarr['umodule']?>&ac=<?=$actionarr['uaction']?>&op=<?=$actionarr['uoperat']?>"></td>
            </tr>
        </table><input type="hidden" value="<?=$actionarr['acid']?>" name="actionid">
        <center><input type="submit" name="actionsubmit" value=" 提交 " class="btn" /></center>
</form>
<?php } elseif($_GET['op']=='msglist') { ?>	
 <div class="subtitle">短消息列表</div>
 <table class="maintable" border="0" cellspacing="0" cellpadding="0">
 	 <tr class="altbg2">
                <th colspan="4">
                    <ul class="subtab">
                         <li <?php if($_GET['isread']==0 && $_GET['send']!=1) { ?>class="current"<?php } ?>><a href="admincp.php?ac=admin&op=msglist&isread=0">未读消息</a></li> 
<li <?php if($_GET['isread']==1  && $_GET['send']!=1) { ?>class="current"<?php } ?>><a href="admincp.php?ac=admin&op=msglist&isread=1">已读消息</a></li>
     <li <?php if($_GET['send']==1) { ?>class="current"<?php } ?>><a href="admincp.php?ac=admin&op=msglist&send=1">已发送</a></li>
                     </ul>                </th>
            </tr>
             <tr class="altbg1">
 				 <td ><?php if($_GET['send']!=1) { ?>发件人<?php } else { ?>收件人<?php } ?></td>
                 <td>标题</td>
<td>状态</td>
                <td>操作</td>
            </tr>
            <?php if(is_array($msgarr)) { foreach($msgarr as $val) { ?>
              <tr>
                 
<td><a href="javascript:void(0)" title="From:<?=$val['fromuser']?> To:<?=$val['touser']?>"><?php if($_GET['send']!=1) { ?><?=$val['fromuser']?><?php } else { ?><?=$val['touser']?><?php } ?></a></td>
                 <td><a href="admincp.php?ac=admin&op=sendmsg&msgid=<?=$val['id']?>"><?=$val['title']?></a>&nbsp;<?=$val['dttime']?></td>
<td><?php if($_GET['send']==1) { ?>对方<?php } ?><?php if($val['isread']==1) { ?>已读<?php } else { ?><font color="#FF0000">未读</font><?php } ?> </td>
                <td><?php if($_GET['send']!=1) { ?>
 <a href="admincp.php?ac=admin&op=sendmsg&msgid=<?=$val['id']?>">查看/回复</a>
  <?php } ?>
   				</td> 
            </tr>
           <?php } } ?>
                       </table>
   	<div class="tab"><div class="pages"><?=$multi?></div></div>
<?php } elseif($_GET['op']=='sendmsg') { ?>
 <div class="subtitle">发送/回复 短消息</div>
<form method="post" action="admincp.php?ac=admin">
        <table class="maintable" border="0" cellspacing="0" cellpadding="0">
 <tr>
                <td width="20%" class="altbg1"><strong>管理员列表:</strong></td>
                <td><?=$admstr?></td>
            </tr>
    <tr>
                <td width="20%" class="altbg1"><strong>收件人:</strong>发送给多人请用“,”号分隔</td>
                <td><input type="text" name="adminmsg[touser]" class="txtbox" value="<?=$adminmsg['fromuser']?>" /></td>
            </tr>
            <tr>
                <td width="20%" class="altbg1"><strong>标题:</strong></td>
                <td><input type="text" name="adminmsg[title]" class="txtbox" value="<?=$adminmsg['title']?>"/></td>
            </tr>
              <tr>
                <td class="altbg1"><strong>内容:</strong>最多255个字符</td>
                <td><textarea name="adminmsg[content]" rows="5" cols="50"><?=$adminmsg['content']?></textarea></td>
            </tr>
        </table>
        <center><input type="submit" name="sendmsg" value=" 提交 " class="btn" /></center>
</form>
<?php } ?>
  </div> 
</div>