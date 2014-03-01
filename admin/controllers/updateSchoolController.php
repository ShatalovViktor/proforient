<?php
$id=$_GET['id'];
$number=$_POST['name'];
$name_dir=$_POST['name_director'];
$family_dir=$_POST['family_director'];
$otch_dir=$_POST['otch_director'];
$telephone=$_POST['telephone'];
$email=$_POST['email'];
$site=$_POST['site'];
$address=$_POST['address'];
$rayon=(int)$_POST['rayon'];
$coord=$_POST['coord'];
$pieces = explode(",", $coord);
$lat=$pieces[0];
$lon=$pieces[1];
switch ($rayon)
{
    case 1:$rayon_text='Амур-Нижнеднепровский';break;
    case 2:$rayon_text='Бабушкинский';break;
    case 3:$rayon_text='Жовтневый';break;
    case 4:$rayon_text='Индустриальный';break;
    case 5:$rayon_text='Кировский';break;
    case 6:$rayon_text='Красногвардейский';break;
    case 7:$rayon_text='Ленинский';break;
    case 8:$rayon_text='Самарский';break;
    case 9:$rayon_text='Днепропетровский';break;
}

$kur=explode(":", $_POST[kurator]);
$kurator=$kur[0];
$db = mysql_connect($db_server,$db_user,$db_pass) ;
mysql_select_db($db_name, $db);
$rs = mysql_query("SET NAMES utf8");
$qr = "UPDATE schools SET schools.number='".$number."', schools.name_director='".$name_dir."', schools.family_director='".$family_dir."',
		schools.otch_director='".$otch_dir."', schools.telephone='".$telephone."', schools.email='".$email."',  schools.site='".$site."',
		schools.address='".$address."', schools.lat='".$lat."', schools.lon='".$lon."', schools.rayon='".$rayon_text."', schools.kurator='".$kurator."'
			WHERE schools.id=".$id;
//echo $qr;
$rs = mysql_query($qr) or die("Invalid query: " . mysql_error());
mysql_close();

echo '
<script language="JavaScript">
  window.location.href = "http://'.$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"].'?cmd=editfolders&rayon='.$rayon.'"
</script>';
?>