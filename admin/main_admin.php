<?
!defined('IN_ADMIN') && exit('Access Denied');
include_once("admin/menuinfo.php");
if($_GET['op']=='menuheader'){//加载头部
	$menuNav='';
	foreach($arr_top as $key => $value) {
 	 	list($mod,$name,$ac,$op,$otherparam) = explode("|", $value);
		$param = "mod=$mod&ac=$ac&op=$op&$otherparam";
		$menuNav .= "\t".'<li class="unselected"><a href="javascript:;" onclick="return gotoMenu(this,'."'$key',"."'$param'".');" onfocus="this.blur()">'.$name.'</a></li>'."\r\n";
 	}
 	include template("menuheader");
	exit;
	
}elseif($_GET['op']=='menu'){//左侧菜单
	$menuarr = isset($arr_menu[$_GET['tab']]) ? $arr_menu[$_GET['tab']] : $arr_menu['main'];//左侧默认显示那块菜单
	$showmenu = '';
	$items = 0;
	foreach($menuarr as $menuvalue) {
		$closeli = $items > 3 ? ' class="closed"' : '';
		if(!is_array($menuvalue))continue;
		$showmenu .= "<li{$closeli}>\r\n";
	 	foreach($menuvalue as $k => $y) {
			$m_mod = $m_caption = $m_ac = $m_op = '';
 			if($k === 'title') {
				$items++;
				$showmenu .= "\t<span class=\"folder\">$y</span>\r\n";
				$showmenu .= "\t\t<ul>\r\n";
			} else {
				list($m_mod,$m_caption,$m_ac,$m_op,$otherparam) = explode('|', $y);
				$params['mod'] = 'mod='.$m_mod;
				$m_ac && $params[] = 'ac='.$m_ac;
				$m_op && $params[] = 'op='.$m_op;
				$otherparam && $params[] = $otherparam;
				$showmenu .= "\t\t\t".'<li><span class="file"><a href="admincp.php?'.implode('&amp;',$params).'" target="main">'.$m_caption.'</a></span></li>'."\r\n";
				unset($params);
			}
		}
		$showmenu .= "\t\t</ul>\r\n";
		$showmenu .= "</li>\r\n";
	}
	include template("menu");
	exit;
	
}elseif($_GET['op']=='main'){//右侧默认内容
	$server['time'] = date('Y-m-d H:i:s', $timestamp);
	$server['upfile'] = (ini_get('file_uploads')) ? '允许 ' . ini_get('upload_max_filesize') : '关闭';//是否允许上传
	$server['register_globals'] = (ini_get('register_globals')) ? '允许' : '关闭';//register_globals
	$server['safe_mode'] = (ini_get('safe_mode')) ? '允许' : '关闭';//安全模式
	$server['magic_quotes_gpc'] = (ini_get('magic_quotes_gpc')) ? '开启' : '关闭';
 	$server['phpver'] = phpversion(); 
	$server['mysqlver'] = $_SGLOBAL['db']->version();//mysql版本
	$s = function_exists('gd_info') ? gd_info() : '<span class="font_1"><strong>Not Support</strong></span>';
	$server['gd'] = is_array($s) ? ($s['GD Version']) : $s;//是否支持图形处理
	function_exists('memory_get_usage') && $server['memory'] = round(memory_get_usage()/1024,2);
	
	$memberinfo = $_SGLOBAL['member']['baseinfo'];
	include template("main");
	exit;
}
?>