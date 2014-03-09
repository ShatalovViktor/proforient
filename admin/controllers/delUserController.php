<?php
$idUser=$_GET['id_user'];
$db = mysql_connect($db_server,$db_user,$db_pass) ;
mysql_select_db($db_name, $db);
$rs = mysql_query("SET NAMES utf8");
$qr = "DELETE FROM users WHERE users.id=".$idUser;
$rs = mysql_query($qr);
mysql_close();
//echo $qr;
echo '
	<script language="JavaScript">
		window.location.href = "http://'.$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"].'?cmd=listusers"
	</script>';
?>