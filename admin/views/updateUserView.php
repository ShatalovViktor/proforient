<?php
$db = mysql_connect($db_server,$db_user,$db_pass) ;
mysql_select_db($db_name, $db);
$rs = mysql_query("SET NAMES utf8");
$idUser=(int)$_GET['id_user'];
$qr = "SELECT * FROM users WHERE id=$idUser LIMIT 0,1";
$rs = mysql_query($qr);
if($rs)
{
$row = mysql_fetch_assoc($rs);
switch ($row[rayon])
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
            <li><a href="?cmd=editfolders&rayon=9">Днепропетровский </a></li><br/>
        </ul>
    </div>
    <td valign="top">
        <div style="padding:6px; background-color:#b0cb9e; width:98%;" ><a href="/admin/?cmd=profile">/ Редактирование профиля /</a></div>
        <br>
        ';

        echo '
        <form action="/admin/?cmd=updateuser&id_user='.$idUser.'" method="POST">
            <b>Логин пользователя:</b><br>
            <input name="login" type="text" value="'.$row[login].'" class="input_text" required><br>
            <b>Пароль пользователя: (это шифр пароля)</b><br>
            <small>Для смены пароля просто удалите данный шифр и впишите пароль <br/>
                так же для смены пароля можно воспользоваться генератором паролей </small> <br/>
            <input name="passwd" id="passwd" type="text" value="'.$row[password].'" class="input_text" required><br>
            <a href="javascript: showPass();">Придумать хороший пароль</a>
            <br>
            <b>Имя пользователя:</b><br>
            <input name="name" type="text" value="'.$row[name].'" class="input_text" required><br>
            <b>Фамилия пользователя:</b><br>
            <input name="family" type="text" value="'.$row[family].'" class="input_text" required><br>
            <b>e-mail пользователя:</b><br>
            <input name="email" type="text" value="'.$row[email].'" class="input_text" required><br>
            <b>Телефон пользователя:</b><br>
            <input name="tel" type="text" value="'.$row[telephone].'" class="input_text" required><br>
            <b>Уровень доступа пользователя:</b><br>';
            ?>



            <select name="access" size="1" class="input_text" required>
                <option <?php if ($row[access]==1) { ?>selected="selected"<?php } ?>value="1">Администратор</option>
                <option <?php if ($row[access]==2) { ?>selected="selected"<?php } ?>value="2">Модератор</option>
                <option <?php if ($row[access]==3) { ?>selected="selected"<?php } ?>value="3">Ответственный за школу</option>
            </select>
            <br/>
            <b>За какой район отвечает пользователь (для администратора можно не указывать):</b><br />
            <select name="rayon" size="1" class="input_text" required>
                <option <?php if ($row[rayon]==0) { ?>selected="selected"<?php } ?>value="0">Все</option>
                <option <?php if ($row[rayon]==1) { ?>selected="selected"<?php } ?>value="1">Амур-Нижнеднепровский</option>
                <option <?php if ($row[rayon]==2) { ?>selected="selected"<?php } ?>value="2">Бабушкинский</option>
                <option <?php if ($row[rayon]==3) { ?>selected="selected"<?php } ?>value="3">Жовтневый</option>
                <option <?php if ($row[rayon]==4) { ?>selected="selected"<?php } ?>value="4">Индустриальный</option>
                <option <?php if ($row[rayon]==5) { ?>selected="selected"<?php } ?>value="5">Кировский</option>
                <option <?php if ($row[rayon]==6) { ?>selected="selected"<?php } ?>value="6">Красногвардейский</option>
                <option <?php if ($row[rayon]==7) { ?>selected="selected"<?php } ?>value="7">Ленинский</option>
                <option <?php if ($row[rayon]==8) { ?>selected="selected"<?php } ?>value="8">Самарский</option>
                <option <?php if ($row[rayon]==9) { ?>selected="selected"<?php } ?>value="9">Днепропетровский</option>


            </select>
    <br />
<?php
    if ($row[access]==3){
        $qrAccess = 'SELECT id_school FROM access WHERE id_user='.$idUser;
        $rsAccess = mysql_query($qrAccess);
        while($rowAccess = mysql_fetch_assoc($rsAccess))
        {
            $idUserSchool[] = $rowAccess['id_school'];//массив содержащий id школ к которым у пользователя есть доступ
        }
       // echo '<pre>'; print_r($idUserSchool); echo '</pre>';
        ?>
        <b>За какие школы отвечает пользователь:</b><br />
        <select name="schools[]" size="6" id="schools" class="input_text large_input" multiple="multiple" required="required">


<?
        $qrSchool = "SELECT id,number FROM schools WHERE rayon='".$rayon_text."'";
        $rsSchool = mysql_query($qrSchool);
        if ($rsSchool)
        while($rowSchool = mysql_fetch_assoc($rsSchool))
        {?>
        <option <?php
        if (in_array($rowSchool['id'],$idUserSchool)) echo 'selected';?>
            value="<?php echo $rowSchool['id'];?>">
            <?php echo $rowSchool['number'];?>
        </option>
    <?}?>
    <?}

echo'
<br />
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