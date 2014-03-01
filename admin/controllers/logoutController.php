<?php
$_SESSION['login']='';
$_SESSION['access']='';
$_SESSION['user']='';
$_SESSION['rayon']='';
$RAYON='';
session_unset();
session_destroy();
header('Location: /admin/');
?>