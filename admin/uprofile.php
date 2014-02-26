<?php
header('Refresh: 3; URL=http://localhost/bsi/www/admin/');
include('settings.php');
$uid=$_POST['uid'];
$email=$_POST['email'];
$c_name=$_POST['c_name'];
$passwd=$_POST['passwd'];
$passwd1=$_POST['passwd1'];


$db = mysql_connect($db_server,$db_user,$db_pass) ;
mysql_select_db($db_name, $db);
$att1='';
if(($passwd==$passwd1)&&($passwd!=''))
{
$att1=",passwd='".md5($passwd)."'";
}
$rs = mysql_query("SET NAMES utf8");
$qr = "UPDATE users SET uid='".$uid."'".$att1.",email='".$email."',c_name='".$c_name."' WHERE id=1";
$rs = mysql_query($qr);
echo '
<table width="100%" cedllspacing="0" cellpadding="8px" border="0">
<tbody>
<tr>
<td align="right" colspan="2" style="background-color:#3E5A2A; color:#ffffff;"><a href="'.$base_path.'/admin/?cmd=profile" style="color:white;">Профиль</a>&nbsp;&nbsp;&nbsp;<a href="'.$base_path.'/admin/?cmd=logout" style="color:white;">Виход</a>&nbsp;</td>
</tr>
<tr>
<td colspan="2" style="background-color:#3E5A2A; color:#ffffff;">'.$menu.'</td>
</tr>
<tr>
<td valign="top">
<div style="padding:6px; background-color:#b0cb9e; width:98%;" ><a href="'.$base_path.'/admin/?cmd=profile">/ Редактирование профиля /</a></div>
<br>';
echo 'Через 3 сек. вы будете перенаправлены на новую страницу.';
$rs = mysql_query($qr);

mysql_close();
echo '</tbody>';
echo '</table>';

exit;


?>
