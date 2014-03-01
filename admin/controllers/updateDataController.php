<?php
$id=$_GET['id'];
$idSchool=$_GET['id_school'];
$year=$_POST['year'];
$date_update=$_POST['date_update'];
$kol_class=$_POST['kol_class'];
$kol_vip=$_POST['kol_vip'];
$kol_stud=$_POST['kol_stud'];
$kol_prepod=$_POST['kol_prepod'];
$otnosh=$_POST['otnosh'];
switch ($otnosh)
{
    case 1:$otnosh_text='Очень плохое';$icon="default#darkorangePoint"; break;
    case 2:$otnosh_text='Плохое';$icon="default#darkorangePoint";  break;
    case 3:$otnosh_text='Нормальное';$icon="default#greenPoint";break;
    case 4:$otnosh_text='Хорошое';$icon="default#greenPoint";break;
    case 5:$otnosh_text='Очень хорошое';$icon="default#greenPoint"; break;
}
$db = mysql_connect($db_server,$db_user,$db_pass) ;
mysql_select_db($db_name, $db);
$rs = mysql_query("SET NAMES utf8");
$qr = "UPDATE schools SET schools.icon='".$icon."' WHERE schools.id=".$idSchool." ";
$rs = mysql_query($qr);
mysql_close();

$db = mysql_connect($db_server,$db_user,$db_pass) ;
mysql_select_db($db_name, $db);
$rs = mysql_query("SET NAMES utf8");
$qr = "UPDATE data SET data.year='".$year."', data.date_update='".$date_update."', data.vipusk_klass='".$kol_class."',
		data.kol_vip='".$kol_vip."', data.kol_stud='".$kol_stud."', data.kol_prepod='".$kol_prepod."',
		data.otnosh_univer='".$otnosh_text."'
			WHERE data.id=".$id;

$rs = mysql_query($qr) or die("Invalid query: " . mysql_error());
mysql_close();

echo '
<script language="JavaScript">
  window.location.href = "http://'.$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"].'?cmd=editdata&id='.$idData.'&id_school='.$idSchool.'"
</script>';

?>