<?
define('MEMBER_ROOT',dirname(__FILE__));
include_once(MEMBER_ROOT."/../include/common.inc.php");
include_once(MEMBER_ROOT."/include/function_member.php");
$baseurl = 'admincp.php?mod=member';
$_SCONFIG['credittype']=array(
1=>'每日奖励',
2=>'提交有效BUG',
3=>'发表文章'
);
$_SCONFIG['userlog']=array(
1=>'评价',
2=>'试玩'
);
$_SCONFIG['usertype']=array(
1=>'普通用户',
2=>'VIP'
);
?>