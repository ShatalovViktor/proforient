<?php
$uid=$_POST['name'];
$passwd=$_POST['pass'];
$db = mysql_connect($db_server,$db_user,$db_pass) ;
mysql_select_db($db_name, $db);

if($passwd!='')
{
    $rs = mysql_query("SET NAMES utf8");
    $qr = "SELECT access, password, id, rayon FROM users WHERE (login='".$uid."' AND password='".md5($passwd)."')";

    $rs = mysql_query($qr);
    $rp='';
    while($row = mysql_fetch_assoc($rs))
    {
        $rp=md5($row['password']);
        $rp=$row['password'];

        $_SESSION['login']=$rp;
        $_SESSION['access']=$row['access'];
        $_SESSION['user']=$row['id'];
        $_SESSION['rayon']=$row['rayon'];
    }
    //die($rp);
    /*if($rp=='') 	echo '
                <script language="JavaScript">
                    window.location.href = "http://'.$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"].'?cmd=loginform"
                </script>';*/
    mysql_close();

}

if($rp!='')	echo '
                <script language="JavaScript">
                    window.location.href = "http://'.$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"].'"
                </script>';
?>