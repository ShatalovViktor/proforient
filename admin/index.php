<?php
include("settings.php");
include("_include/ckeditor/ckeditor.php");
include("_include/ckfinder/ckfinder.php");

session_start();
$cm='';
$cm=$_GET['cmd'];
$id=0;
$id=$_GET['id'];


global $RAYON;
$RAYON=explode(",", $_SESSION['rayon']);

if($cm=='logout'){
    include_once("controllers/logoutController.php");
}
if($cm=='login'){
    include_once("controllers/accessController.php");

}
if((!isset($_SESSION['login']))&&($cm!='loginform'))
	{

	echo '
	<script language="JavaScript">
		window.location.href = "http://'.$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"].'?cmd=loginform"
	</script>';
	}

if($cm=='update'){
    include_once("controllers/updateSchoolController.php");

}
/********************************************************************
*************обработчик редактирования данных по школам**************
********************************************************************/
if($cm=='updatedatacmd'){
    include_once("controllers/updateDataController.php");
}




/*****************************************************
********Обработчик добавления пользователя************
*****************************************************/
if($cm=='addusercmd'){
    include_once("controllers/addUserController.php");
}


/****************************************************
Обработчик изменения данных о пользователе
****************************************************/
if($cm=='updateuser'){
    include_once("controllers/updateUserController.php");
}


/***************удаление пользователя****************************/
if($cm=='deluser')
{

}
/********************конец удаления пользователя*************************************/


/**************************  конец обработчик редактирования профиля пользователя **********************************************/

if($cm=='shfolderitem')
{
	$db = mysql_connect($db_server,$db_user,$db_pass) ;
	mysql_select_db($db_name, $db);
	$rs = mysql_query("SET NAMES utf8");
	$qr = "SELECT * FROM tree WHERE tree.number=".$id;
	$rs = mysql_query($qr);
	if($rs){
		$row = mysql_fetch_assoc($rs);
		$grp=$row['group'];
		$pr=$row['parent'];
	}
	$qr = "UPDATE tree SET tree.show=1-tree.show WHERE tree.number=".$id;
	$rs = mysql_query($qr) or die("Invalid query: " . mysql_error());
	mysql_close();
	if($grp==0)header('Location: /admin/?cmd=editfolders');
	if($grp>0)header('Location: /admin/?cmd=editgroup&id='.$pr);
}

/***************удаление фотографии****************************/
if($cm=='delphotoitem')
{	$photoid=$_GET['pid'];
	$db = mysql_connect($db_server,$db_user,$db_pass) ;
	mysql_select_db($db_name, $db);
	$rs = mysql_query("SET NAMES utf8");
	$qr = "SELECT * FROM photos WHERE photos.id=".$photoid;
	$rs = mysql_query($qr);
	if($rs){
		$row = mysql_fetch_assoc($rs);
		$comment=$row['comment'];
		$text_id=$row['text_id'];
	}
	$qr = "DELETE FROM photos WHERE photos.id=".$photoid;
	$rs = mysql_query($qr) or die("Invalid query: " . mysql_error());
	mysql_close();
	//echo $qr;
	header('Location: /admin/?cmd=editgroup&id='.$id);

}
/********************конец удаления фото*************************************/

/*********************************************
**********обработчик удаления школы***********
*********************************************/
if($cm=='delfolderitem')
{
	$db = mysql_connect($db_server,$db_user,$db_pass) ;
	mysql_select_db($db_name, $db);
	$rs = mysql_query("SET NAMES utf8");
	$qr = "SELECT * FROM schools WHERE schools.id=".$id;
	$rs = mysql_query($qr);
	if($rs){
		$row = mysql_fetch_assoc($rs);
		$rayon_text=$row['rayon'];
	}
	switch ($rayon_text)
	{
	case 'Амур-Нижнеднепровский':$rayon=1;break;
	case 'Бабушкинский':$rayon=2;break;
	case 'Жовтневый':$rayon=3;break;
	case 'Индустриальный':$rayon=4;break;
	case 'Кировский':$rayon=5;break;
	case 'Красногвардейский':$rayon=6;break;
	case 'Ленинский':$rayon=7;break;
	case 'Самарский':$rayon=8;break;
	case 'Днепропетровский':$rayon=9;break;
	}
	$qr = "DELETE FROM schools WHERE schools.id=".$id;
	$rs = mysql_query($qr) or die("Invalid query: " . mysql_error());
	mysql_close();
	echo '
	<script language="JavaScript">
		window.location.href = "http://'.$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"].'?cmd=editfolders&rayon='.$rayon.'"
	</script>';
}
/*********************************************
**********обработчик удаления школы***********
*********************************************/
if($cm=='deldataitem')
{
	$db = mysql_connect($db_server,$db_user,$db_pass) ;
	mysql_select_db($db_name, $db);
	$rs = mysql_query("SET NAMES utf8");
	$qr = "SELECT * FROM data WHERE data.id=".$id;
	$rs = mysql_query($qr);
	if($rs){
		$row = mysql_fetch_assoc($rs);
		$idSchool=$row['id_school'];
	}
	$qr = "DELETE FROM data WHERE data.id=".$id;
	$rs = mysql_query($qr) or die("Invalid query: " . mysql_error());
	mysql_close();
	echo '
	<script language="JavaScript">
		window.location.href = "http://'.$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"].'?cmd=editdata&id_school='.$idSchool.'"
	</script>';
}


/************************************************
**********Обработчик добавления школ*************
************************************************/

if($cm=='addfcmd')
{
	$number=$_POST['name'];
	$name_dir=$_POST['name_director'];
	$family_dir=$_POST['family_director'];
	$otch_dir=$_POST['otch_director'];
	$telephone=$_POST['telephone'];
	$email=$_POST['email'];
	$site=$_POST['site'];
	$address=$_POST['address'];
	$rayon=$_POST['rayon'];
	if ((isset($_POST['kutator']))&&($_POST['kurator'])!='')
				$kurator=$_POST['kurator'];
	else $kurator=$_SESSION['user'];
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

	
	$db = mysql_connect($db_server,$db_user,$db_pass) ;
	mysql_select_db($db_name, $db);
	$rs = mysql_query("SET NAMES utf8");
	$qr = "INSERT INTO schools (schools.number, schools.name_director, schools.family_director, schools.otch_director, schools.telephone,
						schools.email, schools.site, schools.address, schools.lat, schools.lon, schools.rayon, schools.kurator, schools.icon)
				VALUES ('".$number."' ,'".$name_dir."', '".$family_dir."', '".$otch_dir."', '".$telephone."', '".$email."',
						'".$site."', '".$address."','".$lat."', '".$lon."', '".$rayon_text."', ".$kurator.", 'default#redPoint')";
	$rs = mysql_query($qr) or die("Invalid query: " . mysql_error());
	mysql_close();
	//header('Location: /admin/?cmd=editfolders');
	echo '
	<script language="JavaScript">
		window.location.href = "http://'.$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"].'?cmd=editfolders&rayon='.$rayon.'"
	</script>';

}
/************************************************
****Обработчик добавления данных по школам*******
************************************************/
if($cm=='adddatacmd')
{
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
	$qr = "INSERT INTO data (data.id_school, data.year, data.date_update, data.vipusk_klass, data.kol_vip,
						data.kol_stud, data.kol_prepod, data.otnosh_univer)
				VALUES ('".$idSchool."' ,'".$year."', '".$date_update."', '".$kol_class."', '".$kol_vip."', '".$kol_stud."',
						'".$kol_prepod."', '".$otnosh_text."')";
	$rs = mysql_query($qr);
	mysql_close();
		echo '
	<script language="JavaScript">
		window.location.href = "http://'.$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"].'?cmd=editdata&id_school='.$idSchool.'"
	</script>';


}

/************************************************
****Обработчик добавления данных об абитуриентах*******
************************************************/
if($cm=='addabiturientcmd')
{
	$idData=$_GET['id_data'];
	$family=$_POST['family'];
	$name=$_POST['name'];
	$otch=$_POST['otch'];
	$telephone=$_POST['telephone'];
	$email=$_POST['email'];
	$specialnost=$_POST['specialnost'];
	$db = mysql_connect($db_server,$db_user,$db_pass) ;
	mysql_select_db($db_name, $db);
	$rs = mysql_query("SET NAMES utf8");
	$qr = "INSERT INTO abiturients (abiturients.family, abiturients.name, abiturients.otch, abiturients.id_data, abiturients.telephone,
						abiturients.email, abiturients.specialnost)
				VALUES ('".$family."' ,'".$name."', '".$otch."', '".$idData."', '".$telephone."', '".$email."',
						'".$specialnost."')";
	$rs = mysql_query($qr);
	mysql_close();

		echo '
	<script language="JavaScript">
		window.location.href = "http://'.$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"].'?cmd=editabiturients&id_data='.$idData.'"
	</script>';


}
/* Обработчик редактирование данных об абитуриенте*/
if($cm=='updateabiturientcmd'){
$id=$_GET['id'];
$idData=$_GET['id_data'];
$family=$_POST['family'];
$name=$_POST['name'];
$otch=$_POST['otch'];
$telephone=$_POST['telephone'];
$email=$_POST['email'];
$spec=$_POST['specialnost'];

$db = mysql_connect($db_server,$db_user,$db_pass) ;
mysql_select_db($db_name, $db);
$rs = mysql_query("SET NAMES utf8");
$qr = "UPDATE abiturients SET abiturients.family='".$family."', abiturients.name='".$name."', abiturients.otch='".$otch."',
		abiturients.telephone='".$telephone."', abiturients.email='".$email."', abiturients.specialnost='".$spec."',
		abiturients.id_data='".$idData."'
			WHERE abiturients.id=".$id;

$rs = mysql_query($qr) or die("Invalid query: " . mysql_error());
mysql_close();

echo '
<script language="JavaScript">
  window.location.href = "http://'.$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"].'?cmd=editabiturients&id_data='.$idData.'"
</script>';
}
/* Удаление данных об абитуриенте */
if($cm=='delabiturientitem')
{
	$db = mysql_connect($db_server,$db_user,$db_pass) ;
	mysql_select_db($db_name, $db);
	$rs = mysql_query("SET NAMES utf8");
	$qr = "SELECT * FROM abiturients WHERE abiturients.id=".$id;
	$rs = mysql_query($qr);
	if($rs){
		$row = mysql_fetch_assoc($rs);
		$idData=$row['id_data'];
	}
	$qr = "DELETE FROM abiturients WHERE abiturients.id=".$id;
	$rs = mysql_query($qr);
	mysql_close();
	echo '
	<script language="JavaScript">
		window.location.href = "http://'.$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"].'?cmd=editabiturients&id_data='.$idData.'"
	</script>';
}






$db = mysql_connect($db_server,$db_user,$db_pass) ;
mysql_select_db($db_name, $db);
$rs = mysql_query("SET NAMES utf8");
$qr = "SELECT * FROM tree WHERE (tree.group=0 AND tree.parent=0 AND tree.show=1)";
$rs = mysql_query($qr);



$menu='';
if($rs){
while($row = mysql_fetch_assoc($rs))
{
$menu.='&nbsp; &nbsp;<li><a  href="'.$base_path.'/admin/?cmd=editgroup&id='.$row['number'].'" <b>'.$row['title'].'</b></a></li><a style="float:right;"href="'.$base_path.'/admin/?cmd=delfolderitem&id='.$row['number'].'"><img class="del_folder" src="images/del_folder.png" title="Удалить раздел" alt="Удалить раздел"/></a>';
}
mysql_free_result($rs);
}

mysql_close();



echo '
<html>
<head>
<title>Панель администратора сайта</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="css/style2.css"/>
<link rel="stylesheet" type="text/css" href="style.css"/>
<script type="text/javascript" src="js/jquery-1.5.2.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){

		$(".apamayt").click(function(){
			$("#pamyat").slideToggle(50);
			 return false;
		});

	});
</script>

<script src="js/main.js" type="text/javascript" type="text/javascript"></script>




<script src="http://api-maps.yandex.ru/2.0/?load=package.full&lang=ru-RU" type="text/javascript"></script>
 <!--<script src="http://api-maps.yandex.ru/1.1/index.xml?key=AGybdlIBAAAADzcrAQQA5gedE7XoT9UWKazFFgQVQWF485cAAAAAAAAAAAD3euohBHdP7SVNBMlxPK205sLnrg=="	type="text/javascript"></script>-->
<script type="text/javascript">

	var myMap, myPlacemark, coords;

	ymaps.ready(init);

        function init () {';

		if ($cm=='editfolderitem')
{
$id=$_GET['id'];
$db = mysql_connect($db_server,$db_user,$db_pass) ;
mysql_select_db($db_name, $db);
$rs = mysql_query("SET NAMES utf8");
$qr = "SELECT * FROM schools WHERE schools.id=".$id;
$rs = mysql_query($qr);
if($rs){
	$row = mysql_fetch_assoc($rs);
	$coord=$row['lat'];
	$coord.=','.$row['lon'];
	$zoom=17;
	}
}

	else {
	$coord='48.4646,35.0454';
	$zoom=10;
		}
echo '
		//Определяем начальные параметры карты
            myMap = new ymaps.Map("YMapsID", {
                    center: ['.$coord.'],
                    zoom: '.$zoom.',
					behaviors: ["default", "scrollZoom"]
                });

			//Определяем элемент управления поиск по карте
			var SearchControl = new ymaps.control.SearchControl({noPlacemark:true});




			//Добавляем элементы управления на карту
			 myMap.controls
				.add(SearchControl)
                .add("zoomControl")
                .add("typeSelector")
                .add("mapTools");

			coords = [48.4646,35.0454];

			//Определяем метку и добавляем ее на карту


			myPlacemark = new ymaps.Placemark(['.$coord.'],{}, {preset: "twirl#redIcon", draggable: true});

			myMap.geoObjects.add(myPlacemark);

			//Отслеживаем событие перемещения метки
			myPlacemark.events.add("dragend", function (e) {
			coords = this.geometry.getCoordinates();
			savecoordinats();
			getAddress();
			}, myPlacemark);

			//Отслеживаем событие щелчка по карте
			myMap.events.add("click", function (e) {
            coords = e.get("coordPosition");
			savecoordinats();
			getAddress();
			});

	//Отслеживаем событие выбора результата поиска
	SearchControl.events.add("resultselect", function (e) {
		coords = SearchControl.getResultsArray()[0].geometry.getCoordinates();
		savecoordinats();
		getAddress();
	});



    }

	//функция получения адреса по координатам
	function getAddress(){
	var new_coords_ajax = [coords[1].toFixed(7), coords[0].toFixed(7)];
			  $.ajax({

            url: "http://"+window.location.hostname+"/admin/ajax.php",
            data : "message=" + new_coords_ajax,
            type : "POST",
            success: function (data, textStatus) {
             jQuery("#address").val(data);
            },
			error: function(){
				alert ("Ошибка отправки ajax");
			}


        });
	}


	//Функция для передачи полученных значений в форму
	function savecoordinats (){
	var new_coords = [coords[0].toFixed(6), coords[1].toFixed(6)];
	myPlacemark.getOverlay().getData().geometry.setCoordinates(new_coords);
	document.getElementById("latlongmet").value = new_coords;

	var center = myMap.getCenter();
	var new_center = [center[0].toFixed(4), center[1].toFixed(4)];

	}

    </script>


<link rel="stylesheet" type="text/css" href="admin_style.css" media="screen" />
<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
<script src="_include/ckeditor/ckeditor.js" type="text/javascript"></script>
</head>
<body>
';

if($cm=='loginform')
{
echo
'

<div id="chois_form">
<div id="pamyat" style="display: none; ">
		<div id="pamyat2">
			Напишите письмо на
			<br/>
			E-mail:
			<b>buteyc@mail.ru</b>
			<br/>
			с подробным описанием проблемы
			<br/>
			или свяжитесь с нами
			<br/>
			по телефону
			<b>8 (050) 22 76 956</b>
		</div>
	</div>
       <form action="?cmd=login" class="loginform" method="post">
                <div class="error">
                                   </div>
                <div class="loginhead">
                    Вход для пользователей
                </div>
                <div class="loginbody">
                <div class="login_content">
                     <label>Логин:</label>
                     <input value="admin" gtbfieldid="1" name="name" style="margin-left: 8px;" type="text"> <br>
                     <label>Пароль:</label>
                     <input name="pass" type="password"> <br>
					 <span>
						<a href="#" class="apamayt">Забыли пароль?</a>
					</span>
                     <input name="button" value="Вход" type="submit">
                </div>
        </div>
</form>
';
}

if($cm=='editfolders')
{
    include_once("views/editFoldersView.php");
}
/****************************************
*********Список пользователей************
****************************************/

if($cm=='listusers')
{

echo '
<table width="100%" cedllspacing="0" cellpadding="8px" border="0">
<tbody>
<tr>
<td align="right" colspan="2" style="background-color:#3E5A2A; color:#ffffff;">';
if ($_SESSION['access']=='1')
	{
		echo '<a href="/admin/?cmd=listusers" style="color:white;">Список пользователей</a>&nbsp;&nbsp;&nbsp;';

	}

echo'
<a href="'.$base_path.'/admin/?cmd=logout" style="color:white;">Выход</a>&nbsp;</td>
</tr>
<tr>
<td colspan="2" style="background-color:#3E5A2A; color:#ffffff;">'.$menu_razdel.'</td>
</tr>
<tr>
<td width="256px" valign="top" style="border-right:solid 1px #ffffff; class="left_menu">

<div class="left_menu_head">Основные разделы сайта</div>
<div class="menu">
<ul class="left_menu">
<li><a href="?cmd=editfolders&rayon=1">Амур-Нижнеднепровский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=2">Бабушкинский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=3">Жовтневый </a></li><br/>
<li><a href="?cmd=editfolders&rayon=4">Индустриальный </a></li><br/>
<li><a href="?cmd=editfolders&rayon=5">Кировский</a></li><br/>
<li><a href="?cmd=editfolders&rayon=6">Красногвардейский</a></li><br/>
<li><a href="?cmd=editfolders&rayon=7">Ленинский</a></li><br/>
<li><a href="?cmd=editfolders&rayon=8"> Самарский</a></li><br/>
<li><a href="?cmd=editfolders&rayon=9"> Днепропетровский</a></li><br/>
</ul>
</div>
<br/>
<br/>
<div class="left_menu_head">Создать внутри текущего блока</div>
<div class="menu">
<ul style="list-style-image:url(images/menu_add_razdel.png);"><li><a href="?cmd=adduser">Добавить пользователя</a></li></ul>
</div>
<td valign="top">
'.$c_path.'
<br>
';

$db = mysql_connect($db_server,$db_user,$db_pass) ;
	mysql_select_db($db_name, $db);
$rs = mysql_query("SET NAMES utf8");
$qr = "SELECT * FROM users ";
$rs = mysql_query($qr)  or die(mysql_errno().mysql_error()) ;


if($rs){
echo '<table cellspacing="0px" cellpadding="8px" border="0" width="100%">';
echo '<tbody>';
$bg='d8e4d0';
while($row = mysql_fetch_assoc($rs))
{
echo '<tr>';
echo '<td><div style="padding:6px;background-color:#C4E951;">
	  <a href="index.php?cmd=edituser&id_user='.$row['id'].'">
	  <b>'.$row['login'].'</b></a></div>
	  http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'?id_user='.$row['id'].'</td>';
echo '<td width="44px"><a href="index.php?cmd=edituser&id_user='.$row['id'].'"><img src="images/conf.jpg"></a></td>
		<td width="44px"><a href="/admin/?cmd=deluser&id_user='.$row['id'].'"><img src="/admin/images/remove.jpg"></a></td>';
echo '</tr>';
}
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
}
/**************************************
***Форма редактирования пользователя***
**************************************/
if($cm=='edituser')
{
    include_once("views/updateUserView.php");
}


/****************************************
Форма добавления пользователя
****************************************/
if($cm=='adduser')
{
$db = mysql_connect($db_server,$db_user,$db_pass) ;
mysql_select_db($db_name, $db);
$rs = mysql_query("SET NAMES utf8");
$idUser=(int)$_SESSION['user'];
$qr = "SELECT * FROM users WHERE id=$idUser LIMIT 0,1";
$rs = mysql_query($qr);
if($rs)
{
$row = mysql_fetch_assoc($rs);
echo '
<table width="100%" cedllspacing="0" cellpadding="8px" border="0">
<tbody>
<tr>
<td align="right" colspan="2" style="background-color:#3E5A2A; color:#ffffff;">';
if ($_SESSION['access']=='1')
	{
		echo '<a href="/admin/?cmd=listusers" style="color:white;">Список пользователей</a>&nbsp;&nbsp;&nbsp;';

	}

echo'
<a href="?cmd=logout" style="color:white;">Выход</a>&nbsp;</td>
</tr>
<tr>
<td colspan="2" style="background-color:#3E5A2A; color:#ffffff;">'.$menu_razdel.'</td>
</tr>
<tr>
<td width="256px" valign="top" style="border-right:solid 1px #ffffff; class="left_menu" rowspan="2">
<div class="left_menu_head">Основные разделы сайта</div>
<div class="menu">
<ul class="left_menu">
<li><a href="?cmd=editfolders&rayon=1">Амур-Нижнеднепровский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=2">Бабушкинский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=3">Жовтневый </a></li><br/>
<li><a href="?cmd=editfolders&rayon=4">Индустриальный </a></li><br/>
<li><a href="?cmd=editfolders&rayon=5">Кировский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=6">Красногвардейский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=7">Ленинский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=8">Самарский </a></li><br/>
</ul>
</div>
<td valign="top">
<div style="padding:6px; background-color:#b0cb9e; width:98%;" ><a href="/admin/?cmd=profile">/ Редактирование профиля /</a></div>
<br>
';

echo '
<form action="/admin/?cmd=addusercmd" method="POST">
<b>Логин пользователя:</b><br>
<input name="login" type="text" value="" class="input_text" required><br>
<b>Пароль пользователя:</b><br>
<input name="passwd" id="passwd" type="text" value="" class="input_text" required><br>
<a href="javascript: showPass();">Придумать хороший пароль</a>
<br>
<b>Имя пользователя:</b><br>
<input name="name" type="text" value="" class="input_text" required><br>
<b>Фамилия пользователя:</b><br>
<input name="family" type="text" value="" class="input_text" required><br>
<b>e-mail пользователя:</b><br>
<input name="email" type="text" value="" class="input_text" required><br>
<b>Телефон пользователя:</b><br>
<input name="tel" type="text" value="" class="input_text" required><br>
<b>Уровень доступа пользователя:</b><br>
<select name="access" size="1" id="access" class="input_text" required onchange="loadRayon()">
	<option selected="selected" value="">Выберите вариант из списка</option>
	<option value="1">Администратор</option>
	<option value="2">Модератор</option>
	<option value="3">Ответственный за школу</option>
</select><br />
<div id="show_rayon" style="display:none">
<b>За какой район отвечает пользователь:</b><br />
<select name="rayon" size="1" id="rayon" class="input_text" onchange="loadSchools()">
	<option selected="selected" value="0">Выберите район школы</option>
	<option value="1">Амур-Нижнеднепровский</option>
	<option value="2">Бабушкинский</option>
	<option value="3">Жовтневый</option>
	<option value="4">Индустриальный</option>
	<option value="5">Кировский</option>
	<option value="6">Красногвардейский</option>
	<option value="7">Ленинский</option>
	<option value="8">Самарский</option>
	<option value="9">Днепропетровский</option>
</select><br />
</div>
<div id="show_schools"></div>
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
}




/****************************************
Форма редактирования профиля пользователя
****************************************/
if($cm=='profile')
{
$db = mysql_connect($db_server,$db_user,$db_pass) ;
mysql_select_db($db_name, $db);
$rs = mysql_query("SET NAMES utf8");
$idUser=(int)$_SESSION['user'];
$qr = "SELECT * FROM users WHERE id=$idUser LIMIT 0,1";
$rs = mysql_query($qr);
if($rs)
{
$row = mysql_fetch_assoc($rs);
echo '
<table width="100%" cedllspacing="0" cellpadding="8px" border="0">
<tbody>
<tr>
<td align="right" colspan="2" style="background-color:#3E5A2A; color:#ffffff;">';
if ($_SESSION['access']=='1')
	{
		echo '<a href="/admin/?cmd=listusers" style="color:white;">Список пользователей</a>&nbsp;&nbsp;&nbsp;';

	}

echo'
<a href="?cmd=logout" style="color:white;">Выход</a>&nbsp;</td>
</tr>
<tr>
<td colspan="2" style="background-color:#3E5A2A; color:#ffffff;">'.$menu_razdel.'</td>
</tr>
<tr>
<td width="256px" valign="top" style="border-right:solid 1px #ffffff; class="left_menu" rowspan="2">
<div class="left_menu_head">Основные разделы сайта</div>
<div class="menu">
<ul class="left_menu">
<li><a href="?cmd=editfolders&rayon=1">Амур-Нижнеднепровский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=2">Бабушкинский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=3">Жовтневый </a></li><br/>
<li><a href="?cmd=editfolders&rayon=4">Индустриальный </a></li><br/>
<li><a href="?cmd=editfolders&rayon=5">Кировский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=6">Красногвардейский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=7">Ленинский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=8">Самарский </a></li><br/>
</ul>
</div>
<td valign="top">
<div style="padding:6px; background-color:#b0cb9e; width:98%;" ><a href="/admin/?cmd=profile">/ Редактирование профиля /</a></div>
<br>
';
if($_GET['done']=='true')echo('<font color=green><b>Данные обновлены успешно!</b></font><br><br>');
echo '
<form action="/admin/?cmd=uprofile" method="POST">
<b>Ваш логин:</b><br>
<input name="uid" type="text" value="'.$row['uid'].'" class="input_text"><br>
<b>Ваш e-mail:</b><br>
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
}
/****************************************
****************************************добавление данных школы*/
if ($cm=='adddata')
{
$idSchool= $_GET['id_school'];
echo '
<table width="100%" cedllspacing="0" cellpadding="8px" border="0">
<tbody>
<tr>
<td align="right" colspan="2" style="background-color:#3E5A2A; color:#ffffff;">';
if ($_SESSION['access']=='1')
	{
		echo '<a href="/admin/?cmd=listusers" style="color:white;">Список пользователей</a>&nbsp;&nbsp;&nbsp;';

	}
echo'
<a href="?cmd=logout" style="color:white;">Выход</a>&nbsp;</td>
</tr>
<tr>
<td colspan="2" style="background-color:#3E5A2A; color:#ffffff;">'.$menu_razdel.'</td>
</tr>
<tr>
<td width="256px" valign="top" style="border-right:solid 1px #ffffff; class="left_menu">

<div class="left_menu_head">Основные разделы сайта</div>
<div class="menu">
<ul class="left_menu">
<li><a href="?cmd=editfolders&rayon=1">Амур-Нижнеднепровский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=2">Бабушкинский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=3">Жовтневый </a></li><br/>
<li><a href="?cmd=editfolders&rayon=4">Индустриальный </a></li><br/>
<li><a href="?cmd=editfolders&rayon=5">Кировский</a></li><br/>
<li><a href="?cmd=editfolders&rayon=6">Красногвардейский</a></li><br/>
<li><a href="?cmd=editfolders&rayon=7">Ленинский</a></li><br/>
<li><a href="?cmd=editfolders&rayon=8"> Самарский</a></li><br/>
<li><a href="?cmd=editfolders&rayon=9"> Днепропетровский</a></li><br/>
</ul>
</div>
<br/>
<br/>
<div class="left_menu_head">Создать внутри текущего блока</div>
<div class="menu">
<ul style="list-style-image:url(images/menu_add_razdel.png);"><li><a href="?cmd=adddata&id_school='.$idSchool.'">Добавить данные</a></li></ul>
</div>
<td valign="top">
'.$c_path.'
<br>
';
$date_update=date("d.m.Y H:i:s");
echo '
<form action="../admin/?cmd=adddatacmd&id_school='.$idSchool.'" method="POST">
<div style="padding:5px; border-bottom:solid 1px #dddddd;">
<h3>Добавление новых данных по школе:</h3>
</div>
<div style="padding:10px; border-bottom:solid 1px #dddddd;">
<b>За какую дату данные</b><br />
<input name="year"  type="date" class="input_text" type="text" required><br />
<input name="date_update" class="input_text" type="hidden" value="'.$date_update.'"><br />
<b>Количество выпускных классов:</b><br />
<input name="kol_class" type="number" min="0" class="input_text" type="text"><br />
<b>Количество выпускников:</b><br />
<input name="kol_vip" type="number" min="0" class="input_text" type="text"><br />
<b>Количество студентов поступивших из этой школы:</b><br />
<input name="kol_stud" type="number" min="0" class="input_text" type="text"><br />
<b>Количество преподователей закончившие эту школу:</b><br />
<input name="kol_prepod" type="number" min="0" class="input_text" type="text"><br />
<b>Отношоние школы к университету:</b><br />
<select name="otnosh" size="1" class="input_text" required>
	<option selected="selected" value="">Выберите вариант из списка</option>
	<option value="1">Очень плохое</option>
	<option value="2">Плохое</option>
	<option value="3">Нормальное</option>
	<option value="4">Хорошое</option>
	<option value="5">Очень хорошое</option>
</select><br />
</div>';
echo '
<div style="padding:10px;">
<input class="input_button" type="submit" value="Сохранить"><br>
</div>
</form>

</td>
</tr>
</tbody>
</table>';


}
/****************************************
****************************************конец добавления данных школы*/


/* редактирование данных по школе */
if ($cm=='editdataitem')
{
$idSchool= $_GET['id_school'];
$idData=$_GET['id'];

$db = mysql_connect($db_server,$db_user,$db_pass) ;
mysql_select_db($db_name, $db);
$rs = mysql_query("SET NAMES utf8");
$qr = "SELECT * FROM data WHERE data.id=".$idData;
$rs = mysql_query($qr);

if($rs){
$row = mysql_fetch_assoc($rs);
$year=$row['year'];
$kol_class=$row['vipusk_klass'];
$kol_vip=$row['kol_vip'];
$kol_stud=$row['kol_stud'];
$kol_prepod=$row['kol_prepod'];
$otnosh_text=$row['otnosh_univer'];
switch ($otnosh_text)
	{
	case 'Очень плохое':$otnosh=1;break;
	case 'Плохое':$otnosh=2;break;
	case 'Нормальное':$otnosh=3;break;
	case 'Хорошое':$otnosh=4;break;
	case 'Очень хорошое':$otnosh=5;break;
	}
mysql_close();
}
echo '
<table width="100%" cedllspacing="0" cellpadding="8px" border="0">
<tbody>
<tr>
<td align="right" colspan="2" style="background-color:#3E5A2A; color:#ffffff;">';
if ($_SESSION['access']=='1')
	{
		echo '<a href="/admin/?cmd=listusers" style="color:white;">Список пользователей</a>&nbsp;&nbsp;&nbsp;';

	}
echo'
<a href="?cmd=logout" style="color:white;">Выход</a>&nbsp;</td>
</tr>
<tr>
<td colspan="2" style="background-color:#3E5A2A; color:#ffffff;">'.$menu_razdel.'</td>
</tr>
<tr>
<td width="256px" valign="top" style="border-right:solid 1px #ffffff; class="left_menu">

<div class="left_menu_head">Основные разделы сайта</div>
<div class="menu">
<ul class="left_menu">
<li><a href="?cmd=editfolders&rayon=1">Амур-Нижнеднепровский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=2">Бабушкинский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=3">Жовтневый </a></li><br/>
<li><a href="?cmd=editfolders&rayon=4">Индустриальный </a></li><br/>
<li><a href="?cmd=editfolders&rayon=5">Кировский</a></li><br/>
<li><a href="?cmd=editfolders&rayon=6">Красногвардейский</a></li><br/>
<li><a href="?cmd=editfolders&rayon=7">Ленинский</a></li><br/>
<li><a href="?cmd=editfolders&rayon=8"> Самарский</a></li><br/>
<li><a href="?cmd=editfolders&rayon=9"> Днепропетровский</a></li><br/>
</ul>
</div>
<br/>
<br/>
<div class="left_menu_head">Создать внутри текущего блока</div>
<div class="menu">
<ul style="list-style-image:url(images/menu_add_razdel.png);"><li><a href="?cmd=adddata&id_school='.$idSchool.'">Добавить данные</a></li></ul>
</div>
<td valign="top">
'.$c_path.'
<br>
';
$date_update=date("d.m.Y H:i:s");
echo '
<form action="../admin/?cmd=updatedatacmd&id='.$idData.'&id_school='.$idSchool.'" method="POST">
<div style="padding:5px; border-bottom:solid 1px #dddddd;">
<h3>Добавление новых данных по школе:</h3>
</div>
<div style="padding:10px; border-bottom:solid 1px #dddddd;">
<b>За какую дату данные</b><br />
<input name="year" placeholder="дд.мм.гггг" class="input_text" type="text" value="'.$year.'"><br />
<input name="date_update" class="input_text" type="hidden" value="'.$date_update.'"><br />
<b>Количество выпускных классов:</b><br />
<input name="kol_class" class="input_text" type="text" value="'.$kol_class.'"><br />
<b>Количество выпускников:</b><br />
<input name="kol_vip" class="input_text" type="text" value="'.$kol_vip.'"><br />
<b>Количество студентов поступивших из этой школы:</b><br />
<input name="kol_stud" class="input_text" type="text" value="'.$kol_stud.'"><br />
<b>Количество преподователей закончившие эту школу:</b><br />
<input name="kol_prepod" class="input_text" type="text" value="'.$kol_prepod.'"><br />
<b>Отношоние школы к университету:</b><br />';?>
<select name="otnosh"  size="1" class="input_text" required>
<option <?php if ($otnosh==1) { ?>selected="selected"<?php } ?>value="1">Очень плохое</option>
<option <?php if ($otnosh==2) { ?>selected="selected"<?php } ?>value="2">Плохое</option>
<option <?php if ($otnosh==3) { ?>selected="selected"<?php } ?>value="3">Нормальное</option>
<option <?php if ($otnosh==4) { ?>selected="selected"<?php } ?>value="4">Хорошое</option>
<option <?php if ($otnosh==5) { ?>selected="selected"<?php } ?>value="5">Очень хорошое</option>

</select>
<?php
echo '</div>';
/*
<div style="padding:10px; border-bottom:solid 1px #dddddd;">
<b>SEO:</b><br>
<b>Title:</b><br>
<input name="title" class="input_text" type="text"><br>
<b>Keywoards:</b><br>
<input name="keywoards" class="input_text" type="text"><br>
<b>Description:</b><br>
<input name="description" class="input_text" type="text"><br>
</div>
*/
echo '
<div style="padding:10px;">
<input class="input_button" type="submit" value="Сохранить"><br>
</div>
</form>

</td>
</tr>
</tbody>
</table>';


}

/* раздел редактированния данных абитуриентов*/
if($cm=='editabiturients')
{
$idData= $_GET['id_data'];
echo '
<table width="100%" cedllspacing="0" cellpadding="8px" border="0">
<tbody>
<tr>
<td align="right" colspan="2" style="background-color:#3E5A2A; color:#ffffff;">';
if ($_SESSION['access']=='1')
	{
		echo '<a href="/admin/?cmd=listusers" style="color:white;">Список пользователей</a>&nbsp;&nbsp;&nbsp;';

	}
echo'
<a href="?cmd=logout" style="color:white;">Выход</a>&nbsp;</td>
</tr>
<tr>
<td colspan="2" style="background-color:#3E5A2A; color:#ffffff;">'.$menu_razdel.'</td>
</tr>
<tr>
<td width="256px" valign="top" style="border-right:solid 1px #ffffff; class="left_menu">

<div class="left_menu_head">Основные разделы сайта</div>
<div class="menu">
<ul class="left_menu">
<li><a href="?cmd=editfolders&rayon=1">Амур-Нижнеднепровский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=2">Бабушкинский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=3">Жовтневый </a></li><br/>
<li><a href="?cmd=editfolders&rayon=4">Индустриальный </a></li><br/>
<li><a href="?cmd=editfolders&rayon=5">Кировский</a></li><br/>
<li><a href="?cmd=editfolders&rayon=6">Красногвардейский</a></li><br/>
<li><a href="?cmd=editfolders&rayon=7">Ленинский</a></li><br/>
<li><a href="?cmd=editfolders&rayon=8"> Самарский</a></li><br/>
<li><a href="?cmd=editfolders&rayon=9"> Днепропетровский</a></li><br/>
</ul>
</div>
<br/>
<br/>
<div class="left_menu_head">Создать внутри текущего блока</div>
<div class="menu">
<ul style="list-style-image:url(images/menu_add_razdel.png);"><li><a href="?cmd=addabiturient&id_data='.$idData.'">Добавить абитуриента</a></li></ul>
</div>
<td valign="top">
'.$c_path.'
<br>
';

$db = mysql_connect($db_server,$db_user,$db_pass) ;
mysql_select_db($db_name, $db);
$rs = mysql_query("SET NAMES utf8");
$qr = "SELECT * FROM abiturients WHERE abiturients.id_data=".$idData;
$rs = mysql_query($qr)  or die(mysql_errno().mysql_error()) ;
echo 'Редактирование данных об абитуриентах';

if($rs){

echo '<table cellspacing="0px" cellpadding="8px" border="0" width="100%">';
echo '<tbody>';
$bg='d8e4d0';
while($row = mysql_fetch_assoc($rs))
{
$fio=$row['family'].' ';
$fio.=$row['name'].' ';
$fio.=$row['otch'];
echo '<tr>';
echo '<td><div style="padding:6px;background-color:#C4E951;">

	  <a href="index.php?cmd=editabiturientitem&id='.$row['id'].'&id_data='.$row['id_data'].'">
	  <b>'.$fio.'</b></a></div>
	 </td>';
echo '<td width="44px"><a href="index.php?cmd=editabiturientitem&id='.$row['id'].'&id_data='.$row['id_data'].'"><img src="images/conf.jpg"></a></td>
		<td width="44px"><a href="/admin/?cmd=delabiturientitem&id='.$row['id'].'"><img src="/admin/images/remove.jpg"></a></td>';

echo '</tr>';
}
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
/*
$db = mysql_connect($db_server,$db_user,$db_pass) ;
mysql_select_db($db_name, $db);
$rs = mysql_query("SET NAMES utf8");
$qr = "SELECT * FROM data WHERE data.id_school=".$idSchool;
$rs = mysql_query($qr);

if($rs){
$row = mysql_fetch_assoc($rs);
print_r ($row);
mysql_free_result($rs);
}
*/


}
/* добавление данных об абитуриентах */
if ($cm=='addabiturient')
{
$idData= $_GET['id_data'];
echo '
<table width="100%" cedllspacing="0" cellpadding="8px" border="0">
<tbody>
<tr>
<td align="right" colspan="2" style="background-color:#3E5A2A; color:#ffffff;">';
if ($_SESSION['access']=='1')
	{
		echo '<a href="/admin/?cmd=listusers" style="color:white;">Список пользователей</a>&nbsp;&nbsp;&nbsp;';

	}
echo'
<a href="?cmd=logout" style="color:white;">Выход</a>&nbsp;</td>
</tr>
<tr>
<td colspan="2" style="background-color:#3E5A2A; color:#ffffff;">'.$menu_razdel.'</td>
</tr>
<tr>
<td width="256px" valign="top" style="border-right:solid 1px #ffffff; class="left_menu">

<div class="left_menu_head">Основные разделы сайта</div>
<div class="menu">
<ul class="left_menu">
<li><a href="?cmd=editfolders&rayon=1">Амур-Нижнеднепровский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=2">Бабушкинский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=3">Жовтневый </a></li><br/>
<li><a href="?cmd=editfolders&rayon=4">Индустриальный </a></li><br/>
<li><a href="?cmd=editfolders&rayon=5">Кировский</a></li><br/>
<li><a href="?cmd=editfolders&rayon=6">Красногвардейский</a></li><br/>
<li><a href="?cmd=editfolders&rayon=7">Ленинский</a></li><br/>
<li><a href="?cmd=editfolders&rayon=8"> Самарский</a></li><br/>
<li><a href="?cmd=editfolders&rayon=9"> Днепропетровский</a></li><br/>
</ul>
</div>
<br/>
<br/>
<div class="left_menu_head">Создать внутри текущего блока</div>
<div class="menu">
<ul style="list-style-image:url(images/menu_add_razdel.png);"><li><a href="?cmd=addabiturient&id_data='.$idData.'">Добавить абитуриента</a></li></ul>
</div>
<td valign="top">
'.$c_path.'
<br>
';
$date_update=date("d.m.Y H:i:s");
echo '
<form action="../admin/?cmd=addabiturientcmd&id_data='.$idData.'" method="POST">
<div style="padding:5px; border-bottom:solid 1px #dddddd;">
<h3>Добавление нового абитуриента:</h3>
</div>
<div style="padding:10px; border-bottom:solid 1px #dddddd;">
<b>Фамилия абитуриента</b><br />
<input name="family"  class="input_text" type="text" required><br />
<b>Имя абитуриента:</b><br />
<input name="name" class="input_text" type="text" required><br />
<b>Отчество абитуриента:</b><br />
<input name="otch" class="input_text" type="text" required><br />
<b>Телефон абитуриента:</b><br />
<input name="telephone" class="input_text" type="text" ><br />
<b>E-mail абитуриента:</b><br />
<input name="email" class="input_text" type="email"><br />
<b>На какую специальность хочет поступать:</b><br />
<input name="specialnost" class="input_text" type="text"><br />
</div>';
/*
<div style="padding:10px; border-bottom:solid 1px #dddddd;">
<b>SEO:</b><br>
<b>Title:</b><br>
<input name="title" class="input_text" type="text"><br>
<b>Keywoards:</b><br>
<input name="keywoards" class="input_text" type="text"><br>
<b>Description:</b><br>
<input name="description" class="input_text" type="text"><br>
</div>
*/
echo '
<div style="padding:10px;">
<input class="input_button" type="submit" value="Сохранить"><br>
</div>
</form>

</td>
</tr>
</tbody>
</table>';


}
/****************************************
****************************************конец добавления данных об абитуриентах*/
/* редактирование данных об абитуриенте */
if ($cm=='editabiturientitem')
{
$idAbitur= $_GET['id'];
$idData=$_GET['id_data'];

$db = mysql_connect($db_server,$db_user,$db_pass) ;
mysql_select_db($db_name, $db);
$rs = mysql_query("SET NAMES utf8");
$qr = "SELECT * FROM abiturients WHERE abiturients.id=".$idAbitur;
$rs = mysql_query($qr);

if($rs){
$row = mysql_fetch_assoc($rs);
$family=$row['family'];
$name=$row['name'];
$otch=$row['otch'];
$telephone=$row['telephone'];
$email=$row['email'];
$spec=$row['specialnost'];
mysql_close();
}
echo '
<table width="100%" cedllspacing="0" cellpadding="8px" border="0">
<tbody>
<tr>
<td align="right" colspan="2" style="background-color:#3E5A2A; color:#ffffff;">';
if ($_SESSION['access']=='1')
	{
		echo '<a href="/admin/?cmd=listusers" style="color:white;">Список пользователей</a>&nbsp;&nbsp;&nbsp;';

	}
echo'
<a href="?cmd=logout" style="color:white;">Выход</a>&nbsp;</td>
</tr>
<tr>
<td colspan="2" style="background-color:#3E5A2A; color:#ffffff;">'.$menu_razdel.'</td>
</tr>
<tr>
<td width="256px" valign="top" style="border-right:solid 1px #ffffff; class="left_menu">

<div class="left_menu_head">Основные разделы сайта</div>
<div class="menu">
<ul class="left_menu">
<li><a href="?cmd=editfolders&rayon=1">Амур-Нижнеднепровский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=2">Бабушкинский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=3">Жовтневый </a></li><br/>
<li><a href="?cmd=editfolders&rayon=4">Индустриальный </a></li><br/>
<li><a href="?cmd=editfolders&rayon=5">Кировский</a></li><br/>
<li><a href="?cmd=editfolders&rayon=6">Красногвардейский</a></li><br/>
<li><a href="?cmd=editfolders&rayon=7">Ленинский</a></li><br/>
<li><a href="?cmd=editfolders&rayon=8"> Самарский</a></li><br/>
<li><a href="?cmd=editfolders&rayon=9"> Днепропетровский</a></li><br/>
</ul>
</div>
<br/>
<br/>
<div class="left_menu_head">Создать внутри текущего блока</div>
<div class="menu">
<ul style="list-style-image:url(images/menu_add_razdel.png);"><li><a href="?cmd=adddata&id_school='.$idSchool.'">Добавить данные</a></li></ul>
</div>
<td valign="top">
'.$c_path.'
<br>
';
$date_update=date("d.m.Y H:i:s");
echo '
<form action="../admin/?cmd=updateabiturientcmd&id='.$idAbitur.'&id_data='.$idData.'" method="POST">
<div style="padding:5px; border-bottom:solid 1px #dddddd;">
<h3>Редактирование данных об абитуриенте:</h3>
</div>
<div style="padding:10px; border-bottom:solid 1px #dddddd;">
<b>Фамилия абитуриента</b><br />
<input name="family"  class="input_text" type="text" value="'.$family.'" required><br />
<b>Имя абитуриента:</b><br />
<input name="name" class="input_text" type="text" value="'.$name.'" required><br />
<b>Отчество абитуриента:</b><br />
<input name="otch" class="input_text" type="text" value="'.$otch.'" required><br />
<b>Телефон абитуриента:</b><br />
<input name="telephone" class="input_text" type="text" value="'.$telephone.'" ><br />
<b>E-mail абитуриента:</b><br />
<input name="email" class="input_text" type="email" value="'.$email.'"><br />
<b>На какую специальность хоячет поступать:</b><br />
<input name="specialnost" class="input_text" type="text" value="'.$spec.'" ><br />
</div>';
/*
<div style="padding:10px; border-bottom:solid 1px #dddddd;">
<b>SEO:</b><br>
<b>Title:</b><br>
<input name="title" class="input_text" type="text"><br>
<b>Keywoards:</b><br>
<input name="keywoards" class="input_text" type="text"><br>
<b>Description:</b><br>
<input name="description" class="input_text" type="text"><br>
</div>
*/
echo '
<div style="padding:10px;">
<input class="input_button" type="submit" value="Сохранить"><br>
</div>
</form>

</td>
</tr>
</tbody>
</table>';


}

/* раздел редактированния данных по школам*/
if($cm=='editdata')
{
$idSchool= $_GET['id_school'];
echo '
<table width="100%" cedllspacing="0" cellpadding="8px" border="0">
<tbody>
<tr>
<td align="right" colspan="2" style="background-color:#3E5A2A; color:#ffffff;">';
if ($_SESSION['access']=='1')
	{
		echo '<a href="/admin/?cmd=listusers" style="color:white;">Список пользователей</a>&nbsp;&nbsp;&nbsp;';

	}
echo'
<a href="?cmd=logout" style="color:white;">Выход</a>&nbsp;</td>
</tr>
<tr>
<td colspan="2" style="background-color:#3E5A2A; color:#ffffff;">'.$menu_razdel.'</td>
</tr>
<tr>
<td width="256px" valign="top" style="border-right:solid 1px #ffffff; class="left_menu">

<div class="left_menu_head">Основные разделы сайта</div>
<div class="menu">
<ul class="left_menu">
<li><a href="?cmd=editfolders&rayon=1">Амур-Нижнеднепровский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=2">Бабушкинский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=3">Жовтневый </a></li><br/>
<li><a href="?cmd=editfolders&rayon=4">Индустриальный </a></li><br/>
<li><a href="?cmd=editfolders&rayon=5">Кировский</a></li><br/>
<li><a href="?cmd=editfolders&rayon=6">Красногвардейский</a></li><br/>
<li><a href="?cmd=editfolders&rayon=7">Ленинский</a></li><br/>
<li><a href="?cmd=editfolders&rayon=8"> Самарский</a></li><br/>
<li><a href="?cmd=editfolders&rayon=9"> Днепропетровский</a></li><br/>
</ul>
</div>
<br/>
<br/>
<div class="left_menu_head">Создать внутри текущего блока</div>
<div class="menu">
<ul style="list-style-image:url(images/menu_add_razdel.png);"><li><a href="?cmd=adddata&id_school='.$idSchool.'">Добавить данные</a></li></ul>
</div>
<td valign="top">
'.$c_path.'
<br>
';

$db = mysql_connect($db_server,$db_user,$db_pass) ;
mysql_select_db($db_name, $db);
$rs = mysql_query("SET NAMES utf8");
$qr = "SELECT * FROM data WHERE data.id_school=".$idSchool;
$rs = mysql_query($qr)  or die(mysql_errno().mysql_error()) ;
echo 'Редактирование данных по школе';

if($rs){
echo '<table cellspacing="0px" cellpadding="8px" border="0" width="100%">';
echo '<tbody>';
$bg='d8e4d0';
while($row = mysql_fetch_assoc($rs))
{
echo '<tr>';
echo '<td><div style="padding:6px;background-color:#C4E951;">

	  <a href="index.php?cmd=editabiturients&id_data='.$row['id'].'">
	  <b>'.$row['year'].'</b></a></div>
	 </td>';
echo '<td width="44px"><a href="index.php?cmd=editdataitem&id='.$row['id'].'&id_school='.$row['id_school'].'"><img src="images/conf.jpg"></a></td>
		<td width="44px"><a href="/admin/?cmd=deldataitem&id='.$row['id'].'"><img src="/admin/images/remove.jpg"></a></td>';

echo '</tr>';
}
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
/*
$db = mysql_connect($db_server,$db_user,$db_pass) ;
mysql_select_db($db_name, $db);
$rs = mysql_query("SET NAMES utf8");
$qr = "SELECT * FROM data WHERE data.id_school=".$idSchool;
$rs = mysql_query($qr);

if($rs){
$row = mysql_fetch_assoc($rs);
print_r ($row);
mysql_free_result($rs);
}
*/


}

//необходимо
/**************************************************Добавление раздела***********************************************************/
if($cm=='addfolder')
{
if ($_SESSION['access']=='1')
	{
		$db = mysql_connect($db_server,$db_user,$db_pass) ;
		mysql_select_db($db_name, $db);
		$rs = mysql_query("SET NAMES utf8");
		$qr = "SELECT * FROM users ";
		$rs = mysql_query($qr)  or die(mysql_errno().mysql_error()) ;
		if($rs)
			{
				$inp_kurator='<b>Куратор школы:</b><br /><select name="kurator" size="1" class="input_text">';
				$inp_kurator.='<option selected="selected" value="">Выберите куратора школы</option>';
				while($row = mysql_fetch_assoc($rs))
					{
						$inp_kurator.='<option value="'.$row["id"].'">'.$row["family"].'&nbsp'.$row["name"].'</option>';
					}
				$inp_kurator.='</select><br />';
			}
	}
	else $inp_kurator='<br /><input name="kurator" class="input_text" type="hidden" value"'.$_SESSION["user"].'" ><br />';


echo '
<table width="100%" cedllspacing="0" cellpadding="8px" border="0">
<tbody>
<tr>
<td align="right" colspan="2" style="background-color:#3E5A2A; color:#ffffff;">';
if ($_SESSION['access']=='1')
	{
		echo '<a href="/admin/?cmd=listusers" style="color:white;">Список пользователей</a>&nbsp;&nbsp;&nbsp;';

	}
echo '
<a href="?cmd=logout" style="color:white;">Выход</a>&nbsp;</td>
</tr>
<tr>
<td colspan="2" style="background-color:#3E5A2A; color:#ffffff;">'.$menu_razdel.'</td>
</tr>
<tr>
<td width="256px" valign="top" style="border-right:solid 1px #ffffff; class="left_menu">

<div class="left_menu_head">Основные разделы сайта</div>
<div class="menu">
<ul class="left_menu">
<li><a href="?cmd=editfolders&rayon=1">Амур-Нижнеднепровский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=2">Бабушкинский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=3">Жовтневый </a></li><br/>
<li><a href="?cmd=editfolders&rayon=4">Индустриальный </a></li><br/>
<li><a href="?cmd=editfolders&rayon=5">Кировский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=6">Красногвардейский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=7">Ленинский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=8">Самарский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=9">Днепропетровск </a></li><br/>
</ul>
</div>

<td>
'.$c_path.'
<br>

<form action="../admin/?cmd=addfcmd" method="POST">
<div style="padding:5px; border-bottom:solid 1px #dddddd;">
<h3>Новая школа:</h3>
</div>
<div style="padding:10px; border-bottom:solid 1px #dddddd;">
<b>Название и номер школы:</b><br />
<input name="name" class="input_text" type="text" required><br />
<b>Фамилия директора:</b><br />
<input name="family_director" class="input_text" type="text" required><br />
<b>Имя директора:</b><br />
<input name="name_director" class="input_text" type="text" required><br />
<b>Отчество директора:</b><br />
<input name="otch_director" class="input_text" type="text" ><br />
<b>Телефон школы:</b><br />
<input name="telephone" class="input_text" type="tel"  required><br />
<b>Электронный адрес (email) школы:</b><br />
<input name="email" class="input_text" type="email" ><br />
<b>Сайт школы:</b><br />
<input name="site" class="input_text" type="text"><br />
<b>В каком районе школа:</b><br />
<select name="rayon" size="1" class="input_text" required>
	<option selected="selected" value="">Выберите район школы</option>
	<option value="1">Амур-Нижнеднепровский</option>
	<option value="2">Бабушкинский</option>
	<option value="3">Жовтневый</option>
	<option value="4">Индустриальный</option>
	<option value="5">Кировский</option>
	<option value="6">Красногвардейский</option>
	<option value="7">Ленинский</option>
	<option value="8">Самарский</option>
	<option value="9">Днепропетровский</option>
</select><br />

';
echo $inp_kurator;
echo'
<div id="YMapsID" style="height:400px; width:600px;"></div>
<b>Адрес школы:</b><br />
<input name="address" id="address" class="large_text" type="text" value="" required><br />
<div id="coord_form">
<b>Координаты школы:</b> <br />
<input id="latlongmet" type="hidden" class="input-medium" name="coord" required/><br/>
</div>';
echo'</div>';
/*
<div style="padding:10px; border-bottom:solid 1px #dddddd;">
<b>SEO:</b><br>
<b>Title:</b><br>
<input name="title" class="input_text" type="text"><br>
<b>Keywoards:</b><br>
<input name="keywoards" class="input_text" type="text"><br>
<b>Description:</b><br>
<input name="description" class="input_text" type="text"><br>
</div>*/
echo '
<div style="padding:10px;">
<input class="input_button" type="submit" value="Сохранить"><br>
</div>
</form>

</td>
</tr>
</tbody>
</table>

';
}
/****************************************конец добавления раздела**************************************************************/


/******************************************Редактирование раздела********************************************/


if($cm=='editfolderitem')
{
$id=$_GET['id'];


$db = mysql_connect($db_server,$db_user,$db_pass) ;
mysql_select_db($db_name, $db);
$rs = mysql_query("SET NAMES utf8");
$qr = "SELECT * FROM schools WHERE schools.id=".$id;
$rs = mysql_query($qr);

if($rs){
$row = mysql_fetch_assoc($rs);
$number=$row['number'];
$name_dir=$row['name_director'];
$family_dir=$row['family_director'];
$otch_dir=$row['otch_director'];
$telephone=$row['telephone'];
$email=$row['email'];
$site=$row['site'];
$address=$row['address'];
$rayon_text=$row['rayon'];
$kurator=$row['kurator'];
$coord=$row['lat'];
$coord.=','.$row['lon'];

mysql_close();
}
if ($_SESSION['access']=='1')
	{
		$db = mysql_connect($db_server,$db_user,$db_pass) ;
		mysql_select_db($db_name, $db);
		$rs = mysql_query("SET NAMES utf8");
		$qr = "SELECT * FROM users";
		$rs = mysql_query($qr)  or die(mysql_errno().mysql_error()) ;
		if($rs)
			{
				$inp_kurator='<br><b>Куратор школы:</b><br /><select name="kurator" size="1" class="input_text">';
				while($row2 = mysql_fetch_assoc($rs))
					{
						$id_user=(int)$row2['id'];
						if ($kurator == $id_user) $sel='selected';
							else $sel='';
						echo '<br/ >';
						$inp_kurator.='<option '.$sel.' value="'.$row2["id"].'">'.$row2["id"].':'.$row2["family"].'&nbsp'.$row2["name"].'</option>';
					}
				$inp_kurator.='</select><br />';
			}
	}
	else $inp_kurator='<br /><input name="kurator" class="input_text" type="hidden" value="'.$_SESSION["user"].'" ><br />';
	mysql_close();
switch ($rayon_text)
	{
	case 'Амур-Нижнеднепровский':$rayon=1;break;
	case 'Бабушкинский':$rayon=2;break;
	case 'Жовтневый':$rayon=3;break;
	case 'Индустриальный':$rayon=4;break;
	case 'Кировский':$rayon=5;break;
	case 'Красногвардейский':$rayon=6;break;
	case 'Ленинский':$rayon=7;break;
	case 'Самарский':$rayon=8;break;
	case 'Днепропетровский':$rayon=9;break;
	}
$tt='Редактирование школы';
echo '
<table width="100%" cedllspacing="0" cellpadding="8px" border="0">
<tbody>
<tr>
<td align="right" colspan="2" style="background-color:#3E5A2A; color:#ffffff;">';
if ($_SESSION['access']=='1')
	{
		echo '<a href="/admin/?cmd=listusers" style="color:white;">Список пользователей</a>&nbsp;&nbsp;&nbsp;';

	}

echo'
<a href="?cmd=logout" style="color:white;">Выход</a>&nbsp;</td>
</tr>
<tr>
<td colspan="2" style="background-color:#3E5A2A; color:#ffffff;">'.$menu_razdel.'</td>
</tr>
<tr>
<td width="256px" valign="top" style="border-right:solid 1px #ffffff; class="left_menu">

<div class="left_menu_head">Основные разделы сайта</div>
<div class="menu">
<ul class="left_menu">
<li><a href="?cmd=editfolders&rayon=1">Амур-Нижнеднепровский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=2">Бабушкинский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=3">Жовтневый </a></li><br/>
<li><a href="?cmd=editfolders&rayon=4">Индустриальный </a></li><br/>
<li><a href="?cmd=editfolders&rayon=5">Кировский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=6">Красногвардейский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=7">Ленинский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=8">Самарский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=9">Днепропетровский </a></li><br/>
</ul>
</div>
<br/>
<br/>
<div class="left_menu_head">Создать внутри текущего блока</div>
<div class="menu">
<ul style="list-style-image:url(images/menu_add_razdel.png);">
<li><a href="http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'?cmd=adddata&id='.$id.'">Добавить данные по школе</a><br/></li>
</ul>
</td>
<td>
'.$c_path.'
<br>

<form action="?cmd=update&id='.$id.'" method="POST" enctype="multipart/form-data">
<div style="padding:5px; border-bottom:solid 1px #dddddd;">
<h3>'.$tt.':</h3>
</div>
<b>Название и номер школы:</b><br />
<input name="name" class="input_text" type="text" value="'.$number.'" required><br />
<b>Фамилия директора:</b><br />
<input name="family_director" class="input_text" type="text" value="'.$family_dir.'" required><br />
<b>Имя директора:</b><br />
<input name="name_director" class="input_text" type="text" value="'.$name_dir.'" required><br />
<b>Отчество директора:</b><br />
<input name="otch_director" class="input_text" type="text" value="'.$otch_dir.'"><br />
<b>Телефон школы:</b><br />
<input name="telephone" class="input_text" type="text" value="'.$telephone.'" required><br />
<b>Электронный адрес (email) школы:</b><br />
<input name="email" class="input_text" type="email" value="'.$email.'"><br />
<b>Сайт школы:</b><br />
<input name="site" class="input_text" type="text" value="'.$site.'"><br />

<b>Район:</b><br />
<select name="rayon" size="1" class="input_text" required>';
?>
<option <?php if ($rayon==1) { ?>selected="selected"<?php } ?>value="1">Амур-Нижнеднепровский</option>
<option <?php if ($rayon==2) { ?>selected="selected"<?php } ?>value="2">Бабушкинский</option>
<option <?php if ($rayon==3) { ?>selected="selected"<?php } ?>value="3">Жовтневый</option>
<option <?php if ($rayon==4) { ?>selected="selected"<?php } ?>value="4">Индустриальный</option>
<option <?php if ($rayon==5) { ?>selected="selected"<?php } ?>value="5">Кировский</option>
<option <?php if ($rayon==6) { ?>selected="selected"<?php } ?>value="6">Красногвардейский</option>
<option <?php if ($rayon==7) { ?>selected="selected"<?php } ?>value="7">Ленинский</option>
<option <?php if ($rayon==8) { ?>selected="selected"<?php } ?>value="8">Самарский</option>
<option <?php if ($rayon==8) { ?>selected="selected"<?php } ?>value="9">Днепропетровский</option>

</select>


<?php
echo $inp_kurator;
echo '
<br>

<div id="YMapsID" style="height:400px; width:600px;"></div>
<b>Адрес школы:</b><br />
<input id="address" name="address" class="large_text" type="text" value="'.$address.'" required><br />
<div id="coord_form">
<b>Координаты школы:</b> <br />
<input id="latlongmet" class="input-medium" type="hidden" name="coord" value="'.$coord.'" required/><br/>
</div>
<input class="input_button" type="submit" value="Сохранить"><br>

</form>
</td>
</tr>
</tbody>
</table>
';

mysql_close();

}

/******************************************Конец редактирование раздела******************************************************/

if($cm=='')
{
/************************************Главная страница админки***********************************/
echo '
<table width="100%" cedllspacing="0" cellpadding="8px" border="0">
<tbody>
<tr>
<td align="right" colspan="2" style="background-color:#3E5A2A; color:#ffffff;">';
if ($_SESSION['access']=='1')
	{
		echo '<a href="/admin/?cmd=listusers" style="color:white;">Список пользователей</a>&nbsp;&nbsp;&nbsp;';

	}

echo'
<a href="?cmd=logout" style="color:white;">Выход</a>&nbsp;</td>
</tr>
<tr>

<td colspan="2" style="background-color:#3E5A2A; color:#ffffff;">'.$menu_razdel.'</td>
</tr>
<tr>
<td width="256px" valign="top" style="border-right:solid 1px #ffffff; class="left_menu">

<div class="left_menu_head">Основные текстовые разделы сайта</div>
<div class="menu">
<ul class="left_menu">
<li><a href="?cmd=editfolders&rayon=1">Амур-Нижнеднепровский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=2">Бабушкинский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=3">Жовтневый </a></li><br/>
<li><a href="?cmd=editfolders&rayon=4">Индустриальный </a></li><br/>
<li><a href="?cmd=editfolders&rayon=5">Кировский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=6">Красногвардейский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=7">Ленинский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=8">Самарский </a></li><br/>
<li><a href="?cmd=editfolders&rayon=9">Днепропетровский </a></li><br/>
</ul>
</div>
<!--<td style="background-color:#3E5A2A; color:#ffffff;">'.$menu.'</td>-->
<div>
<!--</tr>
<tr>-->
<td>
'.$c_path.'
<br>

	<div align="center" style="margin:0 auto">
    <h3>Добро пожаловать в административную часть сайта. <br />
		Разработчик данного ресурса Шаталов Виктор
    </h3>
	</div>




</td>
</tr>
</tbody>
</table>
';
}

echo '
<div class="footer"></div>
</body>
</html>
';
?>