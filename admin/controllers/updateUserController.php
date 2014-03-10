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
$rs = mysql_query("SET NAMES utf8");
$qr = "UPDATE users SET login='$login' $password,name='$name', family='$family', access=$access, rayon='$rayon',
email='$email', telephone='$tel' WHERE id=$idUser";
$rs = mysql_query($qr) or die("Invalid query: " . mysql_error());
$_SESSION['rayon']=$rayon;
if (($access==3) && (isset($_POST['schools'])))
{
    $qrDel = "DELETE FROM access WHERE id_user=$idUser";
    $rsDel = mysql_query($qrDel) or die("Invalid query: " . mysql_error());
    foreach ($_POST['schools'] as $key=>$idSchools){
        $qrAccess='INSERT INTO access (access.id_user, access.id_school)
                                values ('.$idUser.','.$idSchools.')';
        $rsAccess = mysql_query($qrAccess);
    }
}

echo '
<script language="JavaScript">
    window.location.href = "http://'.$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"].'?cmd=listusers"
</script>';
?>