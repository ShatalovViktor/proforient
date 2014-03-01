<?php
$login=$_POST['login'];
$passwd=md5($_POST['passwd']);
$name=$_POST['name'];
$family=$_POST['family'];
$email=$_POST['email'];
$tel=$_POST['tel'];
$access=$_POST['access'];
if (!isset($_POST)) $rayon='1';
else $rayon=$_POST['rayon'];

$db = mysql_connect($db_server,$db_user,$db_pass) ;
mysql_select_db($db_name, $db);
$rs = mysql_query("SET NAMES utf8");
$qr = 'INSERT INTO users (users.login, users.password, users.name, users.family, users.access, users.rayon, users.email, users.telephone)
				values ("'.$login.'", "'.$passwd.'", "'.$name.'", "'.$family.'", '.$access.', '.$rayon.', "'.$email.'", "'.$tel.'")';


echo $qr;
$rs = mysql_query($qr);

mysql_close();
echo '
<script language="JavaScript">
  window.location.href = "http://'.$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"].'?cmd=listusers"
</script>';
?>