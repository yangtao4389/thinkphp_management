<?php if(!defined('IN_WEB')) exit('Access Denied');?> 
<script type="text/javascript">

function gotoMenu(obj,action,param) {
    var selmenu = obj.parentNode;
    var menus = document.getElementById('menu').getElementsByTagName('li');
    if(selmenu){
        selmenu.className = "selected";
        for(var i = 0;i < menus.length;i++) {
            if(menus[i] != selmenu) menus[i].className = "unselected";
        }
        //showSubmenu(action);
        parent.menu.location = 'admincp.php?ac=main&op=menu&tab=' + action;//左侧菜单
        parent.main.location = 'admincp.php?' + param;//右侧内容
    }
    return false;
}
 
</script>
<div id="header">
  <div id="product"> 后台控制面板</div>
  <div id="nav">
    <div class="op">&nbsp;
        你好：<b><?=$_SGLOBAL['super_username']?>,笔名: <?=$_SGLOBAL['member']['baseinfo']['writename']?> </b>
        <a href="/" target="_blank">网站首页</a>&nbsp;
        <a href="admincp.php?ac=iframe" target="_top">后台首页</a>&nbsp;<a href="admincp.php?ac=admin&op=updatepwd" target="main">修改密码</a>&nbsp;
        <a href="admincp.php?ac=logout" target="_top">退出</a>
    </div>
    <ul id="menu">
      <?=$menuNav?>
    </ul>
  </div>
  <div style="clear:both"></div>
</div>
 