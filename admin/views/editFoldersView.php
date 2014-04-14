<?php
$rayon=$_GET['rayon'];
$idUser = $_SESSION['user'];
switch ($rayon) {
    case 1: $rayonText='Амур-Нижнеднепровский';break;
    case 2: $rayonText='Бабушкинский';break;
    case 3: $rayonText='Жовтневый';break;
    case 4: $rayonText='Индустриальный';break;
    case 5: $rayonText='Кировский';break;
    case 6: $rayonText='Красногвардейский';break;
    case 7: $rayonText='Ленинский';break;
    case 8: $rayonText='Самарский';break;
    case 9: $rayonText='Днепропетровский';break;
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
<ul style="list-style-image:url(images/menu_add_razdel.png);">';
if ($_SESSION['access']!='3')
{
    echo'
    <li><a href="?cmd=addfolder">Добавить школу</a></li>';
}
echo'
</ul>
</div>
<td valign="top">
'.$c_path.'
<br>
';

if ((in_array($_GET['rayon'], $RAYON))||($_SESSION['rayon']==0)||($_SESSION['access']=='1'))
{
    $db = mysql_connect($db_server,$db_user,$db_pass) ;
    mysql_select_db($db_name, $db);
    $rs = mysql_query("SET NAMES utf8");
    if ($_SESSION['access']=='3'){
        $qrAccess = "SELECT * FROM access WHERE (access.id_user=$idUser)";
        $rsAccess = mysql_query($qrAccess) or die(mysql_errno().mysql_error()) ;
        if($rsAccess){
            while($rowAccess = mysql_fetch_assoc($rsAccess))
            {
                $idSchools[]=$rowAccess['id_school'];
            }
        }

            $qr = 'SELECT * FROM schools WHERE (schools.id IN (' . implode(',', array_map('intval', $idSchools)) . '))';
       // echo $qr;


    }
    else{
        $qr = "SELECT * FROM schools WHERE (schools.rayon LIKE '".$rayonText."')";

    }
    $rs = mysql_query($qr)  or die(mysql_errno().mysql_error()) ;
    if($rs){
        echo '<table cellspacing="0px" cellpadding="8px" border="0" width="100%">';
        echo '<tbody>';
        while($row = mysql_fetch_assoc($rs))
        {
            $bg='#FF4141';
            $qr_data = "SELECT * FROM data WHERE (data.id_school=".$row['id'].")";
            $rs_data = mysql_query($qr_data)  or die(mysql_errno().mysql_error()) ;
            if($rs_data)
                while($row_data = mysql_fetch_assoc($rs_data))
                {

                    $tek_data1=date("d.m.Y H:i:s");
                    $tek_data=strtotime($tek_data1);
                    $date_update=strtotime($row_data['date_update']);
                    $date_update1=date("d.m.Y H:i:s", $date_update);
                    $raznica=$tek_data-$date_update;
                    $bg='#C4E951';
                    if ($raznica>=31556926) $bg='#FF4141';
                    if (($row_data['otnosh_univer']=='Плохое')||($row_data['otnosh_univer']=='Очень плохое'))$bg='#DDB742';
                }

            echo '<tr>';
            echo '<td><div style="padding:6px;background-color:'.$bg.';">
	  <a href="index.php?cmd=editdata&id_school='.$row['id'].'">
	  <b>'.$row['number'].'</b></a></div>
	 </td>';
            echo '<td width="44px"><a href="index.php?cmd=editfolderitem&id='.$row['id'].'"><img src="images/conf.jpg"></a></td>
	<td width="44px"><a href="/admin/?cmd=delfolderitem&id='.$row['id'].'"><img src="/admin/images/remove.jpg"></a></td>';
            echo '</tr>';

        }
        mysql_free_result($rs);
        echo '</tbody>';
        echo '</table>';

    }

    mysql_close();
}
else {?>
    <table cellspacing="0px" cellpadding="8px" border="0" width="100%">
   <tbody>
   <tr>
    <td>
    У Вас нет доступа для редактирования данного района
    </td>
    </tr>
    </tbody>
    </table>

<?}?>
</td>
</tr>
</tbody>
</table>
