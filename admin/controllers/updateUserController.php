<?php
$idUser=$_GET['id_user'];
$login=$_POST['login'];
$passwd=$_POST['passwd'];
$name=$_POST['name'];
$family=$_POST['family'];
$access=$_POST['access'];
$rayon=$_POST['rayon'];
$email=$_POST['email'];
$tel=$_POST['tel'];
$db = mysql_connect($db_server,$db_user,$db_pass) ;
mysql_select_db($db_name, $db);
$rs = mysql_query("SET NAMES utf8");
$qr = "SELECT * FROM users WHERE id=$idUser";
$rs = mysql_query($qr);
if ($rs)
{
$row = mysql_fetch_assoc($rs);
$pass=$row['password'];
$rez=strCmp($passwd,$pass);
if ($rez==0) $password='';
else {$passwd=md5($passwd);$password=',password="'.$passwd.'"';}

}
mysql_close();

$db = mysql_connect($db_server,$db_user,$db_pass) ;
mysql_select_db($db_name, $db);
$rs = mysql_query("SET NAMES utf8");
$qr = "UPDATE users SET login='$login' $password,name='$name', family='$family', access=$access, rayon='$rayon',
email='$email', telephone='$tel' WHERE id=$idUser";
$rs = mysql_query($qr) or die("Invalid query: " . mysql_error());
$_SESSION['rayon']=$rayon;
//echo $qr;
mysql_close();
echo '
<script language="JavaScript">
    window.location.href = "http://'.$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"].'?cmd=listusers"
</script>';
?>