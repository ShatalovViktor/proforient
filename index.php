<?php
include("admin/settings.php");

?>
тестмчсчсммсччсм
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Абитуриент инфо - только актуальная информация</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="css/style1.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="admin/js/jquery-1.5.2.min.js"></script>
	<script type="text/javascript" src="http://jqueryrotate.googlecode.com/svn/trunk/jQueryRotate.js"></script>

	
	


	<script src="http://api-maps.yandex.ru/2.0/?load=package.full&lang=ru-RU" type="text/javascript"></script>
<script src="http://api-maps.yandex.ru/1.1/index.xml?key=AEFDDlMBAAAAx6kWPgIACpXH1O7FTH8eQpFL9P-wQQQyZaMAAAAAAAAAAACXEV8zrYWDiOU1IuWWPSGUA-2tkg=="
        type="text/javascript"></script>
	<script type="text/javascript">
        // Создание обработчика для события window.onLoad
        window.onload = function () {
            var map = new YMaps.Map(document.getElementById("YMapsID"));
            map.setCenter(new YMaps.GeoPoint(35.046181,48.464717), 11);

            // Добавление элементов управления
            map.enableScrollZoom();
            map.addControl(new YMaps.ToolBar());
            map.addControl(new YMaps.TypeControl());
            map.addControl(new YMaps.Zoom());

// Группы объектов
            var groups = [
                createGroup("Амур-Нижнеднепровский", [

<?php
				$db = mysql_connect($db_server,$db_user,$db_pass) ;
				mysql_select_db($db_name, $db);
				$rs = mysql_query("SET NAMES utf8");
				$qr = "SELECT * FROM schools WHERE schools.rayon='Амур-Нижнеднепровский' ";
				$rs = mysql_query($qr)  or die(mysql_errno().mysql_error()) ;
				if($rs)
					while($row = mysql_fetch_assoc($rs))
					{
					$descr='<br /><b>Директор:</b>'.$row[family_director].' '.$row[name_director].' '.$row[otch_director].'<br /><b>Телефон:</b>'.$row[telephone].'<br /><b>E-mail:</b>'
					.$row[email].'<br /><b>Сайт школы:</b>'.$row[site].'<br /><b>Адрес школы:</b>'.$row[address].'<br/><a href=\"?school_id='.$row[id].'\"> Данные по школе </a>';



				?>
        	createPlacemark(new YMaps.GeoPoint(<?php echo "$row[lon] , $row[lat]";?>), "<?php echo addslashes($row['number']);?>",   "<?php echo addslashes($descr);?>" ,"<?php echo $row['icon'];?>"),
			<?php
			 }
			?>
                ], "default#cinemaIcon"),
                createGroup("Бабушкинский", [
<?php
				$db = mysql_connect($db_server,$db_user,$db_pass) ;
				mysql_select_db($db_name, $db);
				$rs = mysql_query("SET NAMES utf8");
				$qr = "SELECT * FROM schools WHERE schools.rayon='Бабушкинский' ";
				$rs = mysql_query($qr)  or die(mysql_errno().mysql_error()) ;
				if($rs)
					while($row = mysql_fetch_assoc($rs))
					{
					$descr='<br /><b>Директор:</b>'.$row[family_director].' '.$row[name_director].' '.$row[otch_director].'<br /><b>Телефон:</b>'.$row[telephone].'<br /><b>E-mail:</b>'
					.$row[email].'<br /><b>Сайт школы:</b>'.$row[site].'<br /><b>Адрес школы:</b>'.$row[address].'<br/><a href=\"?school_id='.$row[id].'\"> Данные по школе </a>';



				?>
        	createPlacemark(new YMaps.GeoPoint(<?php echo "$row[lon] , $row[lat]";?>), "<?php echo addslashes($row['number']);?>",   "<?php echo addslashes($descr);?>" ,"<?php echo $row['icon'];?>"),
			<?php
			 }
			?>
                ], "default#teatherIcon"),



                createGroup("Жовтневый", [
<?php
				$db = mysql_connect($db_server,$db_user,$db_pass) ;
				mysql_select_db($db_name, $db);
				$rs = mysql_query("SET NAMES utf8");
				$qr = "SELECT * FROM schools WHERE schools.rayon='Жовтневый' ";
				$rs = mysql_query($qr)  or die(mysql_errno().mysql_error()) ;
				if($rs)
					while($row = mysql_fetch_assoc($rs))
					{
					$descr='<br /><b>Директор:</b>'.$row[family_director].' '.$row[name_director].' '.$row[otch_director].'<br /><b>Телефон:</b>'.$row[telephone].'<br /><b>E-mail:</b>'
					.$row[email].'<br /><b>Сайт школы:</b>'.$row[site].'<br /><b>Адрес школы:</b>'.$row[address].'<br/><a href=\"?school_id='.$row[id].'\"> Данные по школе </a>';



				?>
        	createPlacemark(new YMaps.GeoPoint(<?php echo "$row[lon] , $row[lat]";?>), "<?php echo addslashes($row['number']);?>",   "<?php echo addslashes($descr);?>" ,"<?php echo $row['icon'];?>"),
			<?php
			 }
			?>
                ], "default#campingIcon"),
               /* createGroup("Индустриальный", [
				<?php
				$db = mysql_connect($db_server,$db_user,$db_pass) ;
				mysql_select_db($db_name, $db);
				$rs = mysql_query("SET NAMES utf8");
				$qr = "SELECT * FROM schools WHERE schools.rayon='Индустриальный' ";
				$rs = mysql_query($qr)  or die(mysql_errno().mysql_error()) ;
				if($rs)
					while($row = mysql_fetch_assoc($rs))
					{
					$descr='<br /><b>Директор:</b>'.$row[family_director].' '.$row[name_director].' '.$row[otch_director].'<br /><b>Телефон:</b>'.$row[telephone].'<br /><b>E-mail:</b>'
					.$row[email].'<br /><b>Сайт школы:</b>'.$row[site].'<br /><b>Адрес школы:</b>'.$row[address].'<br/><a href=\"?school_id='.$row[id].'\"> Данные по школе </a>';



				?>
        	createPlacemark(new YMaps.GeoPoint(<?php echo "$row[lon] , $row[lat]";?>), "<?php echo addslashes($row['number']);?>",   "<?php echo addslashes($descr);?>" ,"<?php echo $row['icon'];?>"),
			<?php
			 }
			?>
                ], "default#trainIcon"),
				createGroup("Кировский", [
				<?php
				$db = mysql_connect($db_server,$db_user,$db_pass) ;
				mysql_select_db($db_name, $db);
				$rs = mysql_query("SET NAMES utf8");
				$qr = "SELECT * FROM schools WHERE schools.rayon='Кировский' ";
				$rs = mysql_query($qr)  or die(mysql_errno().mysql_error()) ;
				if($rs)
					while($row = mysql_fetch_assoc($rs))
					{
					$descr='<br /><b>Директор:</b>'.$row[family_director].' '.$row[name_director].' '.$row[otch_director].'<br /><b>Телефон:</b>'.$row[telephone].'<br /><b>E-mail:</b>'
					.$row[email].'<br /><b>Сайт школы:</b>'.$row[site].'<br /><b>Адрес школы:</b>'.$row[address].'<br/><a href=\"?school_id='.$row[id].'\"> Данные по школе </a>';
				?>
        	createPlacemark(new YMaps.GeoPoint(<?php echo "$row[lon] , $row[lat]";?>), "<?php echo addslashes($row['number']);?>",   "<?php echo addslashes($descr);?>" ,"<?php echo $row['icon'];?>"),
			<?php
			 }
			?>
                ], "default#trainIcon"),*/
				createGroup("Красногвардейский", [
			<?php
				$db = mysql_connect($db_server,$db_user,$db_pass) ;
				mysql_select_db($db_name, $db);
				$rs = mysql_query("SET NAMES utf8");
				$qr = "SELECT * FROM schools WHERE schools.rayon='Красногвардейский' ";
				$rs = mysql_query($qr)  or die(mysql_errno().mysql_error()) ;
				if($rs)
					while($row = mysql_fetch_assoc($rs))
					{
					$descr='<br /><b>Директор:</b>'.$row[family_director].' '.$row[name_director].' '.$row[otch_director].'<br /><b>Телефон:</b>'.$row[telephone].'<br /><b>E-mail:</b>'
					.$row[email].'<br /><b>Сайт школы:</b>'.$row[site].'<br /><b>Адрес школы:</b>'.$row[address].'<br/><a href=\"?school_id='.$row[id].'\"> Данные по школе </a>';



				?>
        	createPlacemark(new YMaps.GeoPoint(<?php echo "$row[lon] , $row[lat]";?>), "<?php echo addslashes($row['number']);?>",   "<?php echo addslashes($descr);?>" ,"<?php echo $row['icon'];?>"),
			<?php
			 }
			?>
                ], "default#trainIcon"),
				createGroup("Ленинский", [
				<?php
				$db = mysql_connect($db_server,$db_user,$db_pass) ;
				mysql_select_db($db_name, $db);
				$rs = mysql_query("SET NAMES utf8");
				$qr = "SELECT * FROM schools WHERE schools.rayon='Ленинский' ";
				$rs = mysql_query($qr)  or die(mysql_errno().mysql_error()) ;
				if($rs)
					while($row = mysql_fetch_assoc($rs))
					{
					$descr='<br /><b>Директор:</b>'.$row[family_director].' '.$row[name_director].' '.$row[otch_director].'<br /><b>Телефон:</b>'.$row[telephone].'<br /><b>E-mail:</b>'
					.$row[email].'<br /><b>Сайт школы:</b>'.$row[site].'<br /><b>Адрес школы:</b>'.$row[address].'<br/><a href=\"?school_id='.$row[id].'\"> Данные по школе </a>';



				?>
        	createPlacemark(new YMaps.GeoPoint(<?php echo "$row[lon] , $row[lat]";?>), "<?php echo addslashes($row['number']);?>",   "<?php echo addslashes($descr);?>" ,"<?php echo $row['icon'];?>"),
			<?php
			 }
			?>

                ], "default#trainIcon"),
				createGroup("Самарский", [
          	<?php
				$db = mysql_connect($db_server,$db_user,$db_pass) ;
				mysql_select_db($db_name, $db);
				$rs = mysql_query("SET NAMES utf8");
				$qr = "SELECT * FROM schools WHERE schools.rayon='Самарский' ";
				$rs = mysql_query($qr)  or die(mysql_errno().mysql_error()) ;
				if($rs)
					while($row = mysql_fetch_assoc($rs))
					{
					$descr='<br /><b>Директор:</b>'.$row[family_director].' '.$row[name_director].' '.$row[otch_director].'<br /><b>Телефон:</b>'.$row[telephone].'<br /><b>E-mail:</b>'
					.$row[email].'<br /><b>Сайт школы:</b>'.$row[site].'<br /><b>Адрес школы:</b>'.$row[address].'<br/><a href=\"?school_id='.$row[id].'\"> Данные по школе </a>';



				?>
        	createPlacemark(new YMaps.GeoPoint(<?php echo "$row[lon] , $row[lat]";?>), "<?php echo addslashes($row['number']);?>",   "<?php echo addslashes($descr);?>" ,"<?php echo $row['icon'];?>"),
			<?php
			 }
			?>
                ], "default#trainIcon"),
				createGroup("Днепропетровский", [
          <?php
				$db = mysql_connect($db_server,$db_user,$db_pass) ;
				mysql_select_db($db_name, $db);
				$rs = mysql_query("SET NAMES utf8");
				$qr = "SELECT * FROM schools WHERE schools.rayon='Днепропетровский' ";
				$rs = mysql_query($qr)  or die(mysql_errno().mysql_error()) ;
				if($rs)
					while($row = mysql_fetch_assoc($rs))
					{
					$descr='<br /><b>Директор:</b>'.$row[family_director].' '.$row[name_director].' '.$row[otch_director].'<br /><b>Телефон:</b>'.$row[telephone].'<br /><b>E-mail:</b>'
					.$row[email].'<br /><b>Сайт школы:</b>'.$row[site].'<br /><b>Адрес школы:</b>'.$row[address].'<br/><a href=\"?school_id='.$row[id].'\"> Данные по школе </a>';



				?>
        	createPlacemark(new YMaps.GeoPoint(<?php echo "$row[lon] , $row[lat]";?>), "<?php echo addslashes($row['number']);?>",   "<?php echo addslashes($descr);?>" ,"<?php echo $row['icon'];?>"),
			<?php
			 }
			?>
                ], "default#trainIcon")
            ];

            // Создание списка групп
            for (var i = 0; i < groups.length; i++) {
                addMenuItem(groups[i], map, YMaps.jQuery("#menu"));
            }
        }

        // Добавление одного пункта в список
        function addMenuItem (group, map, menuContainer) {

            // Показать/скрыть группу на карте
            YMaps.jQuery("<a class=\"title\" href=\"#\">" + group.title + "</a>")
                .bind("click", function () {
                    var link = YMaps.jQuery(this);

                    // Если пункт меню "неактивный", то добавляем группу на карту,
                    // иначе - удаляем с карты
                    if (link.hasClass("active")) {
                        map.removeOverlay(group);
                    } else {
                        map.addOverlay(group);
                    }

                    // Меняем "активность" пункта меню
                    link.toggleClass("active");

                    return false;
                })

                // Добавление нового пункта меню в список
                .appendTo(
                    YMaps.jQuery("<li></li>").appendTo(menuContainer)
                )
        }

        // Создание группы
        function createGroup (title, objects, style) {
            var group = new YMaps.GeoObjectCollection(style);

            group.title = title;
            group.add(objects);

            return group;
        }

        // Создание метки
        function createPlacemark (point, name, description, st) {
            var placemark = new YMaps.Placemark(point, {style:st});
			placemark.setIconContent(name);
            placemark.name = name;
            placemark.description = description;

            return placemark
        }
    </script>

	
</head>
<body>
<div id="header">
  <div id="topmenu">
    <ul>
      <li><a href="/" id="topmenu1" accesskey="1">Главная</a></li>
      <li><a href="/admin/" id="topmenu2" accesskey="2">Админка</a></li>
    </ul>
  </div>
  <div id="logo">
    <h1>Абитуриент инфо</h1>
    <h2>Только самая актуальная информация</h2>
  </div>
</div>
<div >
   <ul id="menu">
 <!--[if IE]>
	<li class="first"><a href="?rayon=1">Амур-Нижнеднепровский</a></li>
    <li><a href="?rayon=2">Бабушкинский</a></li>
    <li><a class="title" href="#">Жовтневый</a></li>
    <li><a href="?rayon=4">Индустриальный</a></li>
    <li><a class="title" href="#">Кировский</a></li>
    <li><a href="?rayon=6">Красногвардейский</a></li>
    <li><a href="?rayon=7">Ленинский</a></li>
    <li><a href="?rayon=8">Самарский</a></li> 
	<li><a href="?rayon=9">Днепропетровский</a></li>
<![endif]-->
  </ul>
</div>
<div id="content">
  <div id="main">
    <div id="welcome">

	<?php
	if (isset($_GET['school_id']))
	{
		$idSchool=$_GET['school_id'];
		$qr_data = "SELECT * FROM data WHERE (data.id_school=".$idSchool.")";
		$rs_data = mysql_query($qr_data)  or die(mysql_errno().mysql_error()) ;
		$i=1;
		echo "
		<script type='text/javascript'>
		var wd=0;
		function slideDiv(nd,index){
		var kd=wd-nd;
		$('#data_item'+index).slideToggle('normal'); 
		if(kd<0) {jQuery('#strelka_'+index).rotate({animateTo:180}); wd=1;}
		else {jQuery('#strelka_'+index).rotate({animateTo:0}); wd=0;}
		
		}
		</script>
		";
		
		if($rs_data){
			
			while($row_data = mysql_fetch_assoc($rs_data))
			{
				$idData=$row_data['id'];
				echo '<div id="data'.$i.'" onclick="slideDiv(1,'.$i.')" style="cursor:pointer;width:100%;background-color:#C4E951;padding:10px;color:#FF453F;"><b>Данные на '.$row_data['year'].'</b>
				<a style="float:right;cursor:pointer;" ><img id="strelka_'.$i.'" src="images/kontent_strelchka.png"></a>
				
				</div>';
				echo '<div id="data_item'.$i.'" style="display:none;">';
				echo '<b>Количество выпускных классов:</b> '.$row_data["vipusk_klass"].'<br/>';
				echo '<b>Количество выпускников:</b> '.$row_data["kol_vip"].'<br/>';
				echo '<b>Количество студентов поступивших из этой школы:</b> '.$row_data["kol_stud"].'<br/>';
				echo '<b>Количество преподователей закончившие эту школу:</b> '.$row_data["kol_prepod"].'<br/>';
				echo '<b>Отношоние школы к университету:</b> '.$row_data["otnosh_univer"].'<br/>';
				$qr_abitur = "SELECT * FROM abiturients WHERE (abiturients.id_data=".$idData.")";
				$rs_abitur = mysql_query($qr_abitur)  or die(mysql_errno().mysql_error()) ;
				if($rs_abitur)
				{
					echo '<table style="width:800px;margin:0 auto;text-align:center;">';	
					echo '<tr>';
					echo '<th>Ф.И.О абитуриента</th>';
					echo '<th>Телефон абитуриента</th>';
					echo '<th>E-mail абитуриента</th>';
					echo '<th>Специальность на которую хочет поступить абитуриент</th>';
					echo '</tr>';
					while($row_abitur = mysql_fetch_assoc($rs_abitur))
					{
					echo '<tr><td>'.$row_abitur["family"].' '.$row_abitur["name"].' '.$row_abitur["otch"].'
					<td>'.$row_abitur["telephone"].'</td><td>'.$row_abitur["email"].'</td><td>'.$row_abitur["specialnost"].'</td></tr>';
					}
					echo '</table>';
				}
				else 'На вібранную дату данных по абитуриентам не найдено';
				echo '</div><br/>';
				$i++;
			}
			
		}
		else		echo '<span style="color:#f00">Нет данных по школе</span>';


		
	
	}
	else echo ' <div id="YMapsID" style="width:900px;height:400px"></div>';?>

    </div>
    
  </div>
  
</div>
<div id="footer">








  <p id="legal">Copyright &copy; 2013 <a target="_blank" href="http://vk.com/id7866623">Shatalov Viktor</a>

















</div></body></html>