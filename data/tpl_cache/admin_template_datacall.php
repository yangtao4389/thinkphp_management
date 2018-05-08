<?php if(!defined('IN_WEB')) exit('Access Denied');?> 
<div id="body">
    <div class="space">
<?php if($_GET['op']=='datalist') { ?>
        <div class="subtitle">调用管理</div>
<form method="post" action="admincp.php?ac=datacall&op=del">
        <table class="maintable" border="0" cellspacing="0" cellpadding="0">
            <tr class="altbg2"><th colspan="6">
                <ul class="subtab">
 					<?php if(is_array($dataplacearr)) { foreach($dataplacearr as $value) { ?>
                                         <li <?php if($value['id']==$_GET['dpid']) { ?> class="current"<?php } ?>><a href="admincp.php?ac=datacall&op=datalist&dpid=<?=$value['id']?>"><?=$value['placename']?></a></li>
<?php } } ?>
                                </ul>
            </th></tr>
    <tr class="altbg2"><td colspan="6">
            调用说明:在对应php代码<input type="text" value="getdatacall('标识');"  readonly="true" /> 模板中代码<input type="text" size="40" value="<?=$callexample?>"  readonly="true" />
            </td></tr>
            <tr class="altbg1">
                <td width="50">ID</td>
                <td width="70">标题</td>
                <td width="100">标识名</td>
                <td >sql</td>
                <td width="60">缓存(秒)</td> 
                <td>操作</td>
            </tr>
<?php if(is_array($datalistarr)) { foreach($datalistarr as $value) { ?>	
           <tr>
                <td><?=$value['id']?></td>
                <td><?=$value['title']?></td>
                <td><?=$value['flagname']?></td>
                <td><?=$value['dsql']?></td>
                <td><?=$value['cachetime']?></td>
                <td> <a href="admincp.php?ac=datacall&op=editdatacall&id=<?=$value['id']?>">编辑</a>|<a href="admincp.php?ac=datacall&op=del&dlid=<?=$value['id']?>" onClick="return window.confirm('您确认删除吗？');">删除</a></td>
            </tr>
<?php } } ?>	
            <tr class="altbg1">
                <td colspan="6">
                <input type="button" class="btn" onclick="location.href='admincp.php?ac=datacall&op=adddatacall&dpid=<?=$_GET['dpid']?>';" value="新增数据调用" /></td>
            </tr>
                    </table>
</form>

<div class="tab"><div class="pages"><?=$multi?></div></div>

<?php } elseif($_GET['op']=='editdatacall' || $_GET['op']=='adddatacall' ) { ?><!--添加编辑数据调用-->
 
 <div class="subtitle">添加/修改数据调用</div>
 <form method="post" action="admincp.php?ac=datacall">
        <table class="maintable" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td class="altbg1" width="30%"><strong>标题名称:</strong>用于后台标识位置,例如:首页热门游戏。</td>
                <td width="*">
                    <input type="text" name="datacall[title]" id="datacall[title]" class="txtbox2" value="<?=$datacall['title']?>" />
位置:<select name="datacall[dpid]">
<?php if(is_array($dataplacearr)) { foreach($dataplacearr as $value) { ?>
<option value="<?=$value['id']?>" <?php if($value==$datacall['dpid']) { ?>selected<?php } ?>><?=$value['placename']?></option>
<?php } } ?>
</select></td>
            </tr>
            <tr>
                <td class="altbg1"><strong>标识名:</strong>只允许字母数字下划线,且不能重复</td>
                <td> <input type="text" name="datacall[flagname]" id="datacall[flagname]" class="txtbox2" value="<?=$datacall['flagname']?>" /></td>
            </tr>
            <tr>
                <td class="altbg1"><strong>SQL语句:</strong>此处填写完整SQL表达式包括limit部分</td>
                <td><textarea name="datacall[dsql]" rows="4" cols="60"><?=$datacall['dsql']?></textarea></td>
            </tr>
            <tr>
                <td class="altbg1"><strong>数据模板:</strong>可写模板引擎支持的基本标签,当前数组名<br />_SGLOBAL['datacall']['标识名']</td>
                <td><textarea name="datacall[datatmp]" rows="10" cols="60"><?=$datacall['datatmp']?></textarea></td>
            </tr>
      		<tr>
                <td class="altbg1"><strong>缓存时间:</strong>0为不缓存,缓存时间越短对服务器压力越大.</td>
                <td> <input type="text" name="datacall[cachetime]" class="txtbox2" value="<?=$datacall['cachetime']?>" />秒<input type="hidden" value="<?=$datacall['id']?>"  name="dlid"/></td>
            </tr>
        </table>
 		<center><button type="submit" name="datalistsubmit"   class="btn" />保存更改</button>&nbsp;<button type="button"  onclick="history.go(-1);"  class="btn" />返回</button></center>
 		</form>		
<?php } elseif($_GET['op']=='editdataplace' || $_GET['op']=='adddataplace' || $_GET['op']=='placelist' ) { ?>
 <div class="subtitle">位置管理</div>
 
 <form method="post" action="admincp.php?ac=datacall">
<table class="maintable" border="0" cellspacing="0" cellpadding="0">
           <?php if(is_array($dataplacearr)) { foreach($dataplacearr as $value) { ?>
    <tr>
                <td  width="30%"><?=$value['placename']?></td>
                <td width="*"><a href="admincp.php?ac=datacall&op=editdataplace&id=<?=$value['id']?>">编辑</a>&nbsp;<a href="admincp.php?ac=datacall&op=del&dpid=<?=$value['id']?>" onClick="return window.confirm('此位置的所有数据列表也会被删除!您确认删除本位置吗？');">删除</a></td>
            </tr>

   <?php } } ?>
    <tr>
                <td class="altbg1" width="30%"><strong>位置名称:</strong></td>
                <td width="*">
                    <input type="text" name="dataplace[placename]" id="dataplace[placename]" class="txtbox2" value="<?=$dataplace['placename']?>" />
<input type="hidden" value="<?=$dataplace['id']?>"  name="dpid"/><button type="submit" name="dataplacesubmit"   class="btn" />保存更改</button></td>
            </tr>
        </table>
  		</form>
<?php } ?>	
 				
    </div>

</div> 