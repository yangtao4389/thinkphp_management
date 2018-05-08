<?php if(!defined('IN_WEB')) exit('Access Denied');?><div id="body">
    <div class="space">
<?php if($_GET['op']=='memberlist') { ?>
<div class="subtitle">网站会员列表</div>
 <table class="maintable" border="0" cellspacing="0" cellpadding="0"> 
    <tr class="altbg2"><th>
                <ul class="subtab">
   <li  <?php if(!isset($_GET['usertype']) || $_GET['usertype']==-1) { ?> class="current" <?php } ?>><a href="<?=$baseurl?>&ac=member&op=memberlist&usertype=-1">全部</a></li>
                      <li  <?php if($_GET['usertype']==1) { ?> class="current" <?php } ?>><a href="<?=$baseurl?>&ac=member&op=memberlist&usertype=1">广告主</a></li>
  <li  <?php if($_GET['usertype']==2) { ?> class="current" <?php } ?>><a href="<?=$baseurl?>&ac=member&op=memberlist&usertype=2">网站主</a></li>
  
           </ul>
            </th></tr>
 
  </table>	
 	    <table class="maintable" border="0" cellspacing="0" cellpadding="0"> 
 <form name="form1" method="get" action="admincp.php">
 <tr class="altbg2">
                <td colspan="7">
用户id:<input  type="text" name="uid" size="10" value="<?=$_GET['uid']?>"/>
用户名:<input  type="text" name="username" value="<?=$_GET['username']?>"/>
状态:<select name="state">
<option value="-1">全部</option>
<option value="0" <?php if($_GET['state']==0) { ?>selected<?php } ?>>未审核</option>
<option value="1" <?php if($_GET['state']==1) { ?>selected<?php } ?>>已审核</option>
</select>
                 <input type="hidden" name="mod" value="member" /><input type="hidden" name="ac" value="member" />
 <input type="hidden" name="op" value="memberlist" /><input type="hidden" name="usertype" value="<?=$_GET['usertype']?>" />
                 <input type="submit" name="serach" value="查询"/>                 </td>
          </tr>
  </form>
             <tr class="altbg1">
                <td>id</td>
    <td>用户名</td>
                <td>用户类型</td>
                <td>最后登录IP</td>
                <td>最后登录时间</td>
                <td>状态</td>
                <td width="100">操作</td>
            </tr>
            <?php if(is_array($memberarr)) { foreach($memberarr as $val) { ?>
       
          
             <tr>
                <td><?=$val['uid']?></td> 
<td><?=$val['username']?></td>
                <td><?php if($val['usertype']==1) { ?>广告主<?php } elseif($val['usertype']==2) { ?>网站主<?php } ?></td>
                <td><?=$val['lastloginip']?></td>
                 <td><?php echo newdate($val['lastlogintime'],'Y-m-d H:i:s'); ?></td>
                 <td><?php if($val['state']==1) { ?>已审核<?php } else { ?>未审核<?php } ?></td>
                <td><a href="<?=$baseurl?>&ac=member&op=edituserinfo&uid=<?=$val['uid']?>">修改</a>&nbsp;<?php if($val['usertype']==2) { ?><a href="<?=$baseurl?>&ac=weblist&op=weblist&uid=<?=$val['uid']?>">网站列表</a> <?php } ?><a href="<?=$baseurl?>&ac=member&op=del&uid=<?=$val['uid']?>" onClick="return window.confirm('本操作不可逆，您确认删除吗？');">删除</a> </td>
            </tr>
           <?php } } ?>
      <tr>
               <td colspan="7"><input type="button" class="btn" onclick="location.href='<?=$baseurl?>&ac=member&op=adduserinfo&usertype=<?=$_GET['usertype']?>'" value="添加用户" /></td>
             </tr>
         </table>
  <div class="tab"><div class="pages"><?=$multi?></div></div>

<?php } elseif($_GET['op']=='adduserinfo' || $_GET['op']=='edituserinfo' ) { ?>

<div class="subtitle">添加/修改 [<?php if($minfo['usertype']==1) { ?>广告主<?php } elseif($_GET['usertype']==2) { ?>网站主<?php } ?>]资料</div>
 
 		<form method="post" action="<?=$baseurl?>&ac=member">
 <table class="maintable" border="0" cellspacing="0" cellpadding="0">
 	<tr>
<td width="20%" class="altbg1"><strong>用户名:</strong></td><td><input type="text" name="minfo[username]" value="<?=$minfo['username']?>" class="txtbox2"/>状态<select name="minfo[state]">
<option value="0">未审核</option>
<option value="1" <?php if($minfo['state']==1) { ?>selected<?php } ?>>已审核</option>
</select></td>
</tr>
            <tr>
                <td   class="altbg1"><strong>密码:</strong></td>
                <td><input  type="text" name="minfo[password]"  class="txtbox2" /><input type="hidden" name="minfo[usertype]" value="<?=$minfo['usertype']?>"/></td>
            </tr>
<?php if($_SGLOBAL['member']['baseinfo']['gid']==1) { ?>
 
<tr><td  class="altbg1"><strong>是否管理员:</strong></td><td><select name="minfo[isadmin]">
<option value="0">否</option>
<option value="1" <?php if($minfo['isadmin']==1) { ?>selected<?php } ?>>是</option>
</select>管理员组<select name="gid">
 			<?php if(is_array($grouparr)) { foreach($grouparr as $value) { ?>
<option value="<?=$value['gid']?>" <?php if($value['gid']==$minfo['gid']) { ?>selected<?php } ?>><?=$value['groupname']?></option>
<?php } } ?>
</select></td></tr>
 <tr>
                <td   class="altbg1"><strong>安全信息:</strong></td>
                <td>问题:<?=$mexinfo['question']?>答案:<?=$mexinfo['answer']?></td>
          </tr>
 			<?php } ?>
<tr><td colspan="2" class="altbg1">扩展资料</td></tr>
  		 <tr>
                <td   class="altbg1"><strong>服务QQ:</strong></td>
                <td><input  type="text" name="mexinfo[serviceqq]" value="<?=$mexinfo['serviceqq']?>"  class="txtbox2" /></td>
          </tr>
 <?php if($minfo['usertype']==1) { ?> 
 		<tr>
                <td   class="altbg1"><strong>合作key:</strong>若广告主需要获得注册数时用,此功能技术人员设置</td>
                <td><input  type="text" name="mexinfo[authkey]" value="<?=$mexinfo['authkey']?>"  class="txtbox2" /></td>
          </tr>
 <?php } ?> 
  <tr>
                <td   class="altbg1"><strong>网站名:</strong></td>
                <td><input  type="text" name="mexinfo[webname]" value="<?=$mexinfo['webname']?>"  class="txtbox2" /></td>
          </tr>
  <tr>
                <td   class="altbg1"><strong>网站地址:</strong>例如http://www.abc.com/</td>
                <td><input  type="text" name="mexinfo[weburl]" value="<?=$mexinfo['weburl']?>"  class="txtbox2" /></td>
          </tr>
  <tr>
                <td   class="altbg1"><strong>联系方式:</strong></td>
                <td>电话<input  type="text" name="mexinfo[telnum]" value="<?=$mexinfo['telnum']?>"/><br />QQ/MSN<input  type="text" name="mexinfo[qqmsn]" value="<?=$mexinfo['qqmsn']?>"/><br />Email<input  type="text" name="mexinfo[email]" value="<?=$mexinfo['email']?>"/></td>
          </tr>
 		<?php if($minfo['usertype']==2) { ?>
 <tr>
                <td   class="altbg1"><strong>银行帐号:</strong></td>
                <td>真实名:<input  type="text" name="mexinfo[realname]" value="<?=$mexinfo['realname']?>"  class="txtbox2" /><br />
银行名:(工行/招行等)<input  type="text" name="mexinfo[bankname]" value="<?=$mexinfo['bankname']?>"  class="txtbox2" /><br />
开户行:<input  type="text" name="mexinfo[bankaddress]" value="<?=$mexinfo['bankaddress']?>"  class="txtbox2" /><br />
帐号:<input  type="text" name="mexinfo[bankaccounts]" value="<?=$mexinfo['bankaccounts']?>"  class="txtbox2" /><br /></td>
          </tr>
   <?php } ?>
 	  </table>
   <center><input type="hidden"  name="uid" value="<?=$minfo['uid']?>" />
<input type="submit" name="ubasesubmit" value=" 提交 " class="btn" /></center>
      </form>
 
 
<?php } ?>
 	</div>
</div>