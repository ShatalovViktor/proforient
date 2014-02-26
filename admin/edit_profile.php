<?php
$db = mysql_connect($db_server,$db_user,$db_pass) ;
mysql_select_db($db_name, $db);
$rs = mysql_query("SET NAMES utf8");
$qr = "SELECT * FROM users ";
$rs = mysql_query($qr);
if($rs)
{
$row = mysql_fetch_array($rs);
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
<br>
';
//if($_GET['done']=='true')echo('<font color=green><b>Данные обновлены успешно!</b></font><br><br>');
echo '
<form action="'.$base_path.'/admin/uprofile.php" method="POST">
<b>Ваш логин:</b><br>
<input name="uid" type="text" value="'.$row['uid'].'" class="input_text"><br>
<b>Ваш мыйл:</b><br>
<input name="email" type="text" value="'.$row['email'].'" class="input_text"><br>
<b>Название компании:</b><br>
<input name="c_name" type="text" value="'.$row['c_name'].'" class="input_text"><br>
<hr style="border-bottom:solid 1px #eeeeee;">
<b>Новый пароль:</b><br>
<input name="passwd" type="text" value="" class="input_text"><br>
<b>Подтверждение пароля:</b><br>
<input name="passwd1" type="text" value="" class="input_text"><br>
<br>
<input class="input_button" type="submit" value="Сохранить"><br>
</form>
';

mysql_free_result($rs);
echo '</tbody>';
echo '</table>';
}

mysql_close();

echo '
</td>
</tr>
</tbody>
</table>
';

?>