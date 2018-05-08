<?
!defined('IN_ADMIN') && exit('Access Denied');
 
//处理数据库信息,帮助手册
if($_GET['op']=='dbtable'){//显示数据库中的表信息
		$query = $_SGLOBAL['db']->query("SHOW TABLE STATUS");
        $rows_total = $plugin_rows_total = $other_rows_total = $index_length = $other_index_length = $data_free = $data_free = $data_length = $other_data_length = 0;
		$table_info=$other_table_info=array();
        while($info = $_SGLOBAL['db']->fetch_array($query)) {
			$info['fieldarr'] = gettablefield($info['Name']);
            $info['Index_length_unit'] += sizeunit(@intval($info['Index_length']));
            $info['Data_free_unit'] += sizeunit(@intval($info['Data_free']));
            $info['Data_length_unit'] += sizeunit(@intval($info['Data_length']));
            if(substr($info['Name'],0,strlen($_SCONFIG['tablepre'])) == $_SCONFIG['tablepre']) {
                $table_info[] = $info;
                $rows_total += $info['Rows'];
                $index_length += $info['Index_length'];
                $data_free += $info['Data_free'];
                $data_length += $info['Data_length'];
            } else {
                $other_table_info[] = $info;
                $other_rows_total += $info['Rows'];
                $other_index_length += $info['Index_length'];
                $other_data_free += $info['Data_free'];
                $other_data_length += $info['Data_length'];
            }
        }
	
}

if(submitcheck('cachesubmit')){//更新缓存
 	foreach($_POST['cache'] as $value){
  		  function_exists($value) &&  $value();
 	}	
 	 showmessage('更新缓存完成','admincp.php?ac=help&op=updatecache');
}
?>