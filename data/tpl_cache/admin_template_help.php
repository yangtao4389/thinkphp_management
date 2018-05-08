<?php if(!defined('IN_WEB')) exit('Access Denied');?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="x-ua-compatible" content="ie=7" />
<link rel="stylesheet" type="text/css" href="./images/admin/admin.css">
<script type="text/javascript" src="./data/cachefiles/config.js"></script>
<script type="text/javascript" src="./include/javascript/jquery.js"></script>
<script type="text/javascript" src="./include/javascript/common.js"></script>
<script type="text/javascript" src="./include/javascript/admin.js"></script>
</head>
<body>
<div id="body">
<?php if($_GET['op']=='updatecache' ) { ?>

 <div class="subtitle">更新网站缓存</div>
<form method="post" action="admincp.php?ac=help">
  <table class="maintable" border="0" cellspacing="0" cellpadding="0">
               <tr>
                <td><input type="checkbox" value="cache_config" name="cache[]" />配置缓存&nbsp;<input type="checkbox" value="cache_modulesconfig" name="cache[]" />模块缓存&nbsp;<input type="checkbox" value="cache_pluginsconfig" name="cache[]" />插件缓存&nbsp;<input type="checkbox" value="update_tpl_cache" name="cache[]" />模板缓存&nbsp;<input type="checkbox" value="update_datacall_cache" name="cache[]" />数据调用缓存</td>
             </tr>
</table>
 <button type="submit" name="cachesubmit"   class="btn" />保存更改</button>	
</form> 
<?php } elseif($_GET['op']=='dbtable') { ?>
 
    <div class="space">
        <div class="subtitle">网站数据表信息</div>
        <table class="maintable" border="0" cellspacing="0" cellpadding="0">
               <tr>
                <td><strong>站内表合计:</strong>&nbsp;<?php echo count($table_info); ?>个表</td>
                <td></td>
                <td></td>
                <td><?=$rows_total?></td>
                <td><?php echo sizeunit($data_length); ?></td>
                <td><?php echo sizeunit($index_length); ?></td>
                <td><?php echo sizeunit($data_free); ?></td>
            </tr>
 <tr class="altbg1">
                <td width="20%">数据表名称</td>
                <td width="20%">创建时间</td>
                <td width="20%">最后更新时间</td>
                <td width="10%">记录数</td>
                <td width="10%">数据</td>
                <td width="10%">索引</td>
                <td width="10%">碎片</td>
            </tr>
<?php if(is_array($table_info)) { foreach($table_info as $value) { ?>
 
            <tr class="altbg2">
                <td><?=$value['Name']?></td>
                <td><?=$value['Create_time']?></td>
                <td><?=$value['Check_time']?></td>
                <td><?=$value['Rows']?></td>
                <td><?php echo sizeunit($value['Data_length']); ?></td>
                <td><?php echo sizeunit($value['Index_length']); ?></td>
                <td><?php echo sizeunit($value['Data_free']); ?></td>
            </tr>
<tr ><td colspan="7" >
<?php if(is_array($value['fieldarr'])) { foreach($value['fieldarr'] as $value1) { ?>
[<?=$value1?>]&nbsp;
<?php } } ?>
</td></tr>

          <?php } } ?>
      </table>
    </div>
    <div class="space">
        <div class="subtitle">其他数据表信息</div>
        <table class="maintable" border="0" cellspacing="0" cellpadding="0">
         <tr>
                <td><strong>其他表合计:</strong>&nbsp;<?php echo count($other_table_info); ?>个表</td>
                <td></td>
                <td></td>
                <td><?=$other_rows_total?></td>
                <td><?php echo sizeunit($other_data_length); ?></td>
                <td><?php echo sizeunit($other_index_length); ?></td>
                <td><?php echo sizeunit($other_data_free); ?></td>
            </tr>
 <tr class="altbg1">
                <td width="20%">数据表名称</td>
                <td width="20%">创建时间</td>
                <td width="20%">最后更新时间</td>
                <td width="10%">记录数</td>
                <td width="10%">数据</td>
                <td width="10%">索引</td>
                <td width="10%">碎片</td>
            </tr>
<?php if(is_array($other_table_info)) { foreach($other_table_info as $value) { ?>
 
            <tr class="altbg2">
                <td><?=$value['Name']?></td>
                <td><?=$value['Create_time']?></td>
                <td><?=$value['Check_time']?></td>
                <td><?=$value['Rows']?></td>
                <td><?php echo sizeunit($value['Data_length']); ?></td>
                <td><?php echo sizeunit($value['Index_length']); ?></td>
                <td><?php echo sizeunit($value['Data_free']); ?></td>
            </tr>
<tr ><td colspan="7">
<?php if(is_array($value['fieldarr'])) { foreach($value['fieldarr'] as $value1) { ?>
[<?=$value1?>]&nbsp;
<?php } } ?>
</td></tr>

          <?php } } ?>
                    </table>
    </div>
<?php } ?>



</div> 