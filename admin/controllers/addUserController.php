<?php
$login=$_POST['login'];
$passwd=md5($_POST['passwd']);
$name=$_POST['name'];
$family=$_POST['family'];
$email=$_POST['email'];
$tel=$_POST['tel'];
$access=$_POST['access'];
if (!isset($_POST['rayon'])) $rayon='1';
else $rayon=$_POST['rayon'];

$db = mysql_connect($db_server,$db_user,$db_pass) ;
mysql_select_db($db_name, $db);
$rs = mysql_query("SET NAMES utf8");
$qr = 'SELECT id,login FROM users WHERE login="'.$login.'"';
$rs = mysql_query($qr);
if($rs)
{
    $row = mysql_num_rows($rs);
    if ($row==0)
    {
        $qrInsert = 'INSERT INTO users (users.login, users.password, users.name, users.family, users.access, users.rayon, users.email, users.telephone)
                        values ("'.$login.'", "'.$passwd.'", "'.$name.'", "'.$family.'", '.$access.', '.$rayon.', "'.$email.'", "'.$tel.'")';

        $rsInsert = mysql_query($qrInsert);
        if (isset($_POST['schools']))
        {
            $qrLogin = 'SELECT id,login FROM users WHERE login="'.$login.'"';
            $rsLogin = mysql_query($qrLogin);
            if($rsLogin)
            {
                $rowLogin = mysql_fetch_assoc($rsLogin);
                $idUser = $rowLogin['id'];
                foreach ($_POST['schools'] as $key=>$idSchools){
                    $qrAccess='INSERT INTO access (access.id_user, access.id_school)
                                values ('.$idUser.','.$idSchools.')';
                    $rsAccess = mysql_query($qrAccess);

                }
            }

        }
        mysql_free_result($rsInsert);
        mysql_free_result($rsAccess);
        mysql_free_result($rsLogin);
        mysql_free_result($rs);
        mysql_close();
        echo '
        <script language="JavaScript">
          window.location.href = "http://'.$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"].'?cmd=listusers"

        </script>';
    }
    else{
        echo '

        <script language="JavaScript">
             alert("Логин: '.$login.' уже существует");
             window.location.href = "http://'.$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"].'?cmd=listusers"

        </script>';
    }
}
?>