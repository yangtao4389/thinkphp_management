<?php if(!defined('IN_WEB')) exit('Access Denied');?><script language="javascript">
function checkselect() {
  	for (var i=0;i<document.form1["moduleids[]"].length;i++) {
var e=document.form1["moduleids[]"][i];
e.checked=!e.checked;
}
}

</script><div id="body">



    <div class="space">
      
    <?php if($_GET['op']=='modlist') { ?><!--模块列表--> 
 <div class="subtitle">模块插件管理</div>
 <form method="post" id="form1" name="form1" action="admincp.php?ac=modules">
    <table class="maintable" border="0" cellspacing="0" cellpadding="0">
<tr class="altbg2">
                <th colspan="10">
                    <ul class="subtab">
                        <li <?php if($_GET['moduletype']==1) { ?>class="current"<?php } ?>><a href="admincp.php?ac=modules&moduletype=1">模块</a></li>
                        <li <?php if($_GET['moduletype']==2) { ?>class="current"<?php } ?>><a href="admincp.php?ac=modules&moduletype=2">插件</a></li> 
                    </ul>                </th>
            </tr>
            <tr class="altbg1">
                <td width="20">ID</td>
                <td width="25">核心</td>
                <td width="80">名称</td>
                <td width="35">类型</td>
                <td width="50">标识</td>
                <td width="80">目录</td>
                <td>描述</td>
                <td width="80">版本</td>
                <td width="80">作者</td>
                <td width="100">操作</td>
            </tr>
           
           <?php if(is_array($modlist)) { foreach($modlist as $val) { ?>
     
            <tr>
                <td><?=$val['moduleid']?></td>
                <td><?php if($val['iscore']==1) { ?>√<?php } else { ?>-<?php } ?></td>
                <td><?=$val['name']?></td>
                <td><?php if($val['moduletype']==1) { ?>模块<?php } else { ?>插件<?php } ?></td>
                <td><?=$val['flag']?></td>
                <td><?=$val['directory']?></td>
                <td><?=$val['introduce']?></td>
                <td><?=$val['version']?></td>
                <td><?=$val['author']?></td>
                <td>
<a href="admincp.php?ac=modules&op=editconfig&modid=<?=$val['moduleid']?>">修改</a>&nbsp;
<?php if(!$val['iscore']) { ?><!--非核心模块-->
<?php if($val['disable']==1) { ?>
<a href="admincp.php?ac=modules&op=disablemod&disable=0&moduleid=<?=$val['moduleid']?>">启用</a>&nbsp;
<?php } else { ?>
<a href="admincp.php?ac=modules&op=disablemod&disable=1&moduleid=<?=$val['moduleid']?>">禁用</a>
<?php } ?>
 					<a href="admincp.php?ac=modules&op=unstallmodule&moduleid=<?=$val['moduleid']?>" onClick="return window.confirm('本操作不可逆，您确认卸载本模块吗？');">卸载</a>
 				<?php } ?>
                                               </td>
            </tr>
           <?php } } ?>
   <tr class="altbg1">
                <td colspan="10">安装<?php if($_GET['moduletype']==1) { ?>模块<?php } else { ?>插件<?php } ?>&nbsp;&nbsp;&nbsp;
                    标 识：<input type="text" class="txtbox3" name="flag" id="flag" />&nbsp;
                    目 录：<input type="text" class="txtbox2" name="directory" id="directory"/>&nbsp;<input type="hidden" name="moduletype" value="<?=$_GET['moduletype']?>">
 <button type="submit" class="btn" name="installmodule" value="yes">提交</button>&nbsp; <button type="submit" class="btn" name="updatecache" value="yes">更新缓存</button>
                </td>
            </tr>
                      </table></form>
<?php } elseif($_GET['op']=='editconfig') { ?> <!--编辑模块配置-->					 
 	<div class="subtitle">更改模块配置</div>
<form method="post" action="admincp.php?ac=modules">
        <table class="maintable" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="30%" class="altbg1"><strong>名字:</strong></td>
                <td><input type="text" name="mod[name]" class="txtbox2"  value="<?=$mod['name']?>" /></td>
            </tr>
<tr>
                <td class="altbg1"><strong>标识:</strong></td>
                <td><input type="text" name="mod[flag]" class="txtbox2"  value="<?=$mod['flag']?>" /></td>
            </tr>
<tr>
                <td  class="altbg1"><strong>文件夹:</strong></td>
                <td><input type="text" name="mod[directory]" class="txtbox2"  value="<?=$mod['directory']?>" /></td>
            </tr>
<tr><td class="altbg1"><strong>菜单配置:</strong>每个值用,分割菜单配置: mod|modname|ac|op</td>
    <td>
<?php $marr = unserialize($mod['menuconfig']); ?>
 			 <input type="text" name="modvaluelist" value="<?php echo implode(" , ",$marr); ?>" size=100 />
</td>
</tr>
<tr>
                <td  class="altbg1"><strong>介绍:</strong></td>
                <td><input type="text" name="mod[introduce]" class="txtbox2"  value="<?=$mod['introduce']?>" /></td>
            </tr>

         </table>	 
        <center><input type="hidden" name="modid" value="<?=$mod['moduleid']?>" /><input type="submit" name="modconfigsubmit" value=" 提交 " class="btn" /></center>
</form>

<?php } ?>
     </div>


</div>