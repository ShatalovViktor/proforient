<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');

include("/home/borstroi/public_html/admin/_include/ckeditor/ckeditor.php");
include("/home/borstroi/public_html/admin/_include/ckfinder/ckfinder.php");


$cm='';
$cm=$_GET['cmd'];
$id=0;
$id=$_GET['id'];

if(($_COOKIE['fsb157357']=='')&&($cm!='loginform')) {
header('Location: /admin/?cmd=loginform');
}


if($cm=='logout'){
setcookie( 'fsb157357' , '' , time()-3600 , '/admin/' , '' , 0 ); 
unset( $_COOKIE['fsb157357'] ); 
header('Location: /admin/');
}


if($cm=='login'){
$uid=$_POST['name'];
$passwd=$_POST['pass'];

$db = mysql_connect('localhost','borstroi_user1','159357') ;
mysql_select_db('borstroi_db', $db);

if($passwd!='')
{
$rs = mysql_query("SET NAMES utf8");
$qr = "SELECT passwd FROM users WHERE (uid='".$uid."' AND passwd='".md5($passwd)."')";

$rs = mysql_query($qr);

$rp='';

while($row = mysql_fetch_assoc($rs))
{
$rp=md5($row['passwd']);
setcookie('fsb157357',$rp,time() + (3600),'/admin/');
}
//die($rp);
if($rp=='')header('Location: /admin/?cmd=loginform');

mysql_close();

}

if($rp!='')header('Location: /admin/');

}


function create_path($n)
{

$db = mysql_connect('localhost','borstroi_user1','159357') ;
mysql_select_db('borstroi_db', $db);
$rs = mysql_query("SET NAMES utf8");
$qr = "SELECT * FROM tree WHERE tree.number=".$n;
$rs = mysql_query($qr);
if($rs){
$row = mysql_fetch_assoc($rs);
$z=create_path($row['parent']);
return $z.='<a href="/admin/?cmd=editgroup&id='.$row['number'].'">'.$row['title'].'</a> / ';
}
mysql_close();

}

if($cm=='addpcmd'){

$cp=0;

if ($_FILES['photo'])
{
    $tnp  = $_FILES['photo']['tmp_name'];
    
    require "resizer.php";
    $nn=date("YmdHis");
    $tmp=img_resize( $tnp , 600 , "/home/borstroi/public_html/images/" , $nn.'.jpg');
    $tmp=img_resize( $tnp , 150 , "/home/borstroi/public_html/images/" , 'th-'.$nn.'.jpg');
    $tmp=img_resize( $tnp , 100 , "/home/borstroi/public_html/images/" , '!th-'.$nn.'.jpg');
    if($tnp!='')$cp=1;
}


$nm=$_POST['name'];
$dsc=$_POST['desc'];
$ttl=$_POST['title'];
$kw=$_POST['keywoards'];
$dscr=$_POST['description'];
$grp=$_POST['grp'];
$photo=$nn;

$db = mysql_connect('localhost','borstroi_user1','159357') ;
mysql_select_db('borstroi_db', $db);
$rs = mysql_query("SET NAMES utf8");
$img1="";
$img2="";
if($cp==1)
{
$img1="tree.image";
$img2="'".$nn."'";
}
$qr = "INSERT INTO tree (tree.group, tree.parent, tree.title, tree.desc, ".$img1.", tree.p_title, tree.p_keys, tree.p_desc, tree.show) VALUES (".$grp.", ".$id.", '".$nm."', '".$dsc."', ".$img2.", '".$ttl."', '".$kw."', '".$dscr."', 1)";

$rs = mysql_query($qr);
mysql_close();
header('Location: /admin/?cmd=editgroup&id='.$id);

}


if($cm=='update'){

$cp=0;

if ($_FILES['photo'])
{
    $tnp  = $_FILES['photo']['tmp_name'];
    
    require "resizer.php";
    $nn=date("YmdHis");
    $tmp=img_resize( $tnp , 600 , "/home/borstroi/public_html/images/" , $nn.'.jpg');
    $tmp=img_resize( $tnp , 150 , "/home/borstroi/public_html/images/" , 'th-'.$nn.'.jpg');
    $tmp=img_resize( $tnp , 100 , "/home/borstroi/public_html/images/" , '!th-'.$nn.'.jpg');
    if($tnp!='')$cp=1;
}


$nm=$_POST['name'];
$dsc=$_POST['desc'];
$ttl=$_POST['title'];
$kw=$_POST['keywoards'];
$dscr=$_POST['description'];
$grp=$_POST['grp'];
$photo=$nn;

$db = mysql_connect('localhost','borstroi_user1','159357') ;
mysql_select_db('borstroi_db', $db);
$img1="";
$img2="";
$img="";
if($cp==1)
{
$img1="tree.image";
$img2="'".$nn."'";
$img=$img1." = ".$img2.",";
}
$rs = mysql_query("SET NAMES utf8");
$qr = "UPDATE tree SET tree.group=".$grp.", tree.title='".$nm."', tree.desc='".$dsc."', ".$img." tree.p_title='".$ttl."', tree.p_keys='".$kw."', tree.p_desc='".$dscr."' WHERE tree.number=".$id;

$rs = mysql_query($qr);

$qr = "SELECT * FROM tree WHERE tree.number=".$id;
$rs = mysql_query($qr);
if($rs){
$row = mysql_fetch_assoc($rs);
$parent=$row['parent'];
}
mysql_close();

if($grp==0)header('Location: /admin/?cmd=editfolders');
if($grp>0)header('Location: /admin/?cmd=editgroup&id='.$parent);

}


if($cm=='uprofile'){

$uid=$_POST['uid'];
$passwd=$_POST['passwd'];
$passwd1=$_POST['passwd1'];
$email==$_POST['email'];
$c_name==$_POST['c_name'];

$db = mysql_connect('localhost','borstroi_user1','159357') ;
mysql_select_db('borstroi_db', $db);
$att1='';
if(($passwd==$passwd1)&&($passwd!=''))
{
$att1=",passwd='".md5($passwd)."'";
}
$rs = mysql_query("SET NAMES utf8");
$qr = "UPDATE users SET uid='".$uid."'".$att1.",email='".$email."',c_name='".$c_name."' WHERE id=1";

$rs = mysql_query($qr);

mysql_close();

if($grp==0)header('Location: /admin/?cmd=profile&done=true');

}



if($cm=='shfolderitem')
{
$db = mysql_connect('localhost','borstroi_user1','159357') ;
mysql_select_db('borstroi_db', $db);
$rs = mysql_query("SET NAMES utf8");

$qr = "SELECT * FROM tree WHERE tree.number=".$id;
$rs = mysql_query($qr);


if($rs){
$row = mysql_fetch_assoc($rs);
$grp=$row['group'];
$pr=$row['parent'];
}

$qr = "UPDATE tree SET tree.show=1-tree.show WHERE tree.number=".$id;
$rs = mysql_query($qr);
mysql_close();
if($grp==0)header('Location: /admin/?cmd=editfolders');
if($grp>0)header('Location: /admin/?cmd=editgroup&id='.$pr);
}


if($cm=='delfolderitem')
{
$db = mysql_connect('localhost','borstroi_user1','159357') ;
mysql_select_db('borstroi_db', $db);
$rs = mysql_query("SET NAMES utf8");

$qr = "SELECT * FROM tree WHERE tree.number=".$id;
$rs = mysql_query($qr);


if($rs){
$row = mysql_fetch_assoc($rs);
$grp=$row['group'];
$pr=$row['parent'];
}

$qr = "DELETE FROM tree WHERE tree.number=".$id;
$rs = mysql_query($qr);
mysql_close();
if($grp==0)header('Location: /admin/?cmd=editfolders');
if($grp>0)header('Location: /admin/?cmd=editgroup&id='.$pr);
}


if(($cm=='addlinkcmd')||($cm=='addinfocmd')||($cm=='addgallerycmd')||($cm=='addsubfoldercmd')||($cm=='addnewscmd'))
{


if($cm=='addinfocmd')
{

$cp=0;

if ($_FILES['photo'])
{
    $tnp  = $_FILES['photo']['tmp_name'];
    
    require "resizer.php";
    $nn=date("YmdHis");
    $tmp=img_resize( $tnp , 600 , "/home/borstroi/public_html/images/" , $nn.'.jpg');
    $tmp=img_resize( $tnp , 150 , "/home/borstroi/public_html/images/" , 'th-'.$nn.'.jpg');
    $tmp=img_resize( $tnp , 100 , "/home/borstroi/public_html/images/" , '!th-'.$nn.'.jpg');
    if($tnp!='')$cp=1;
}

$img1="";
$img2="";
if($cp==1)
{
$img1=" ,tree.image";
$img2="',".$nn."'";
}

}


$nm=$_POST['name'];
$dsc=$_POST['desc'];
$ttl=$_POST['title'];
$kw=$_POST['keywoards'];
$dscr=$_POST['description'];
$grp=$_POST['grp'];

$db = mysql_connect('localhost','borstroi_user1','159357') ;
mysql_select_db('borstroi_db', $db);
$rs = mysql_query("SET NAMES utf8");
$qr = "INSERT INTO tree (tree.group, tree.parent, tree.title, tree.desc, tree.p_title, tree.p_keys, tree.p_desc, tree.show".$img1.") VALUES (".$grp.", ".$id.", '".$nm."', '".$dsc."', '".$ttl."', '".$kw."', '".$dscr."', 1".$img2.")";
$rs = mysql_query($qr);
mysql_close();
header('Location: /admin/?cmd=editgroup&id='.$id);
}


if($cm=='addnewsformcmd')
{

$cp=0;

if ($_FILES['photo'])
{
    $tnp  = $_FILES['photo']['tmp_name'];
    
    require "resizer.php";
    $nn=date("YmdHis");
    $tmp=img_resize( $tnp , 600 , "/home/borstroi/public_html/images/" , $nn.'.jpg');
    $tmp=img_resize( $tnp , 150 , "/home/borstroi/public_html/images/" , 'th-'.$nn.'.jpg');
    $tmp=img_resize( $tnp , 100 , "/home/borstroi/public_html/images/" , '!th-'.$nn.'.jpg');
    if($tnp!='')$cp=1;
}

$img1="";
$img2="";
if($cp==1)
{
$img1=" ,tree.image";
$img2="',".$nn."'";
}




$nm=$_POST['name'];
$dsc=$_POST['desc'];
$subdsc=$_POST['subdesc'];
$ttl=$_POST['title'];
$kw=$_POST['keywoards'];
$dscr=$_POST['description'];
$grp=$_POST['grp'];

$db = mysql_connect('localhost','borstroi_user1','159357') ;
mysql_select_db('borstroi_db', $db);
$rs = mysql_query("SET NAMES utf8");
$qr = "INSERT INTO tree (tree.group, tree.parent, tree.title, tree.subdesc, tree.desc, tree.p_title, tree.p_keys, tree.p_desc, tree.show".$img1.") VALUES (".$grp.", ".$id.", '".$nm."', '".$subdsc."', '".$dsc."', '".$ttl."', '".$kw."', '".$dscr."', 10".$img2.")";
$rs = mysql_query($qr);
mysql_close();
header('Location: /admin/?cmd=editgroup&id='.$id);
}

if($cm=='addfcmd')
{
$nm=$_POST['name'];
$dsc=$_POST['desc'];
$ttl=$_POST['title'];
$kw=$_POST['keywoards'];
$dscr=$_POST['description'];

$db = mysql_connect('localhost','borstroi_user1','159357') ;
mysql_select_db('borstroi_db', $db);
$rs = mysql_query("SET NAMES utf8");
$qr = "INSERT INTO tree (tree.group, tree.parent, tree.title, tree.desc, tree.p_title, tree.p_keys, tree.p_desc, tree.show) VALUES (0, 0, '".$nm."', '".$dsc."', '".$ttl."', '".$kw."', '".$dscr."', 1)";
$rs = mysql_query($qr);
mysql_close();
header('Location: /admin/?cmd=editfolders');
}

$db = mysql_connect('localhost','borstroi_user1','159357') ;
mysql_select_db('borstroi_db', $db);
$rs = mysql_query("SET NAMES utf8");
$qr = "SELECT * FROM tree WHERE (tree.group=0 AND tree.parent=0 AND tree.show=1)";
$rs = mysql_query($qr);



if($rs){
while($row = mysql_fetch_assoc($rs))
{
$menu.='&nbsp; &nbsp;<a href="/admin/?cmd=editgroup&id='.$row['number'].'" style="color:#ffffff;text-decoration:none;"><b>'.$row['title'].'</b></a>';
}
mysql_free_result($rs);
}

mysql_close();



echo '
<html>
<head>
<title>Admin</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">

</head>
<body>
';

$c_tpath=create_path($id);
if($c_tpath=='')$c_tpath=' /';


/*
$theDomain = $_SERVER['HTTP_HOST'];
echo $theDomain;
*/

if($cm=='loginform')
{
echo '
<link href="/css/admin.css" media="screen" rel="stylesheet" type="text/css">

<div id="chois_form">
       <form action="/admin/?cmd=login" class="loginform" method="post">
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
                     <input name="button" value="Вход" type="submit">
                </div>
        </div>
</form>
';
}

if($cm=='editfolders')
{
echo '
<table width="100%" cedllspacing="0" cellpadding="8px" border="0">
<tbody>
<tr>
<td align="right" colspan="2" style="background-color:#3E5A2A; color:#ffffff;"><a href="/admin/?cmd=profile" style="color:white;">Профиль</a>&nbsp;&nbsp;&nbsp;<a href="/admin/?cmd=logout" style="color:white;">Виход</a>&nbsp;</td>
</tr>
<tr>
<td colspan="2" style="background-color:#3E5A2A; color:#ffffff;"></td>
</tr>
<tr>
<td width="150px" valign="top" style="border-right:solid 1px #ffffff; background-color:#3E5A2A; color:#ffffff;" class="left_menu"><a href="/admin/?cmd=addfolder">добавить раздел</a></td>
<td valign="top">
'.$c_path.'
<br>
';

$db = mysql_connect('localhost','borstroi_user1','159357') ;
mysql_select_db('borstroi_db', $db);
$rs = mysql_query("SET NAMES utf8");
$qr = "SELECT * FROM tree WHERE (tree.group=0 AND tree.parent=0)";
$rs = mysql_query($qr);


if($rs){
echo '<table cellspacing="0px" cellpadding="8px" border="0" width="100%">';
echo '<tbody>';
$bg='d8e4d0';
while($row = mysql_fetch_assoc($rs))
{
echo '<tr>';
if($row['show']==1)$onoff='n';
if($row['show']==0)$onoff='ff';

echo '<td><div style="padding:6px;background-color:#'.$bg.';"><a href="/admin/?cmd=editgroup&id='.$row['number'].'"><b>'.$row['title'].'</b></a></div>http://bsi.dp.ua/page-'.$row['number'].'.html</td>';
echo '<td width="44px"><a href="/admin/?cmd=editfolderitem&id='.$row['number'].'"><img src="/admin/images/conf.jpg"></a></td>';
echo '<td width="44px"><a href="/admin/?cmd=shfolderitem&id='.$row['number'].'"><img src="/admin/images/display_o'.$onoff.'.jpg"></a></td>';
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


if($cm=='profile')
{
$db = mysql_connect('localhost','borstroi_user1','159357') ;
mysql_select_db('borstroi_db', $db);
$rs = mysql_query("SET NAMES utf8");
$qr = "SELECT * FROM users LIMIT 0,1";
$rs = mysql_query($qr);
if($rs)
{
$row = mysql_fetch_assoc($rs);
echo '
<table width="100%" cedllspacing="0" cellpadding="8px" border="0">
<tbody>
<tr>
<td align="right" colspan="2" style="background-color:#3E5A2A; color:#ffffff;"><a href="/admin/?cmd=profile" style="color:white;">Профиль</a>&nbsp;&nbsp;&nbsp;<a href="/admin/?cmd=logout" style="color:white;">Виход</a>&nbsp;</td>
</tr>
<tr>
<td colspan="2" style="background-color:#3E5A2A; color:#ffffff;"></td>
</tr>
<tr>
<td valign="top">
<!-- <div style="padding:6px; background-color:#b0cb9e; width:98%;" ><a href="/admin/?cmd=profile">/ Редактирование профиля /</a></div> -->
<br>
';
if($_GET['done']=='true')echo('<font color=green><b>Данные обновлены успешно!</b></font><br><br>');
echo '
<form action="/admin/?cmd=uprofile" method="POST">
<b>Ваш логин:</b><br>
<input name="uid" type="text" value="'.$row['uid'].'" class="input_text"><br>
<b>Ваш мыйл:</b><br>
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

if($cm=='editgroup')
{
echo '
<table width="100%" cedllspacing="0" cellpadding="8px" border="0">
<tbody>
<tr>
<td align="right" colspan="2" style="background-color:#3E5A2A; color:#ffffff;"><a href="/admin/?cmd=profile" style="color:white;">Профиль</a>&nbsp;&nbsp;&nbsp;<a href="/admin/?cmd=logout" style="color:white;">Виход</a>&nbsp;</td>
</tr>
<tr>
<td colspan="2" style="background-color:#3E5A2A; color:#ffffff;"></td>
</tr>
<tr>
<td width="150px" valign="top" style="border-right:solid 1px #ffffff; background-color:#3E5A2A; color:#ffffff;" class="left_menu" rowspan="2">
';

$db = mysql_connect('localhost','borstroi_user1','159357') ;
mysql_select_db('borstroi_db', $db);
$rs = mysql_query("SET NAMES utf8");
$qr = "SELECT * FROM tree WHERE tree.number=".$id;
$rs = mysql_query($qr);

if($rs){
$row = mysql_fetch_assoc($rs);
$grp=$row['group'];
mysql_free_result($rs);
}

mysql_close();

if($id!=4)
{

if($grp!=4)
{
if(($id<6)||($id==15)||($cmd=='editgroup'))
{

if($id==15)
{
echo '
<a href="/admin/?cmd=addsubfolder&id='.$id.'">добавить раздел</a><br><br>
';
}
else
{
echo '
<a href="/admin/?cmd=addsubfolder&id='.$id.'">добавить подраздел</a><br><br>
';
}
}
echo '
<a href="/admin/?cmd=addlink&id='.$id.'">добавить ссылку</a><br><br>
';
if(($id<6)||($id==15)||($cmd=='editgroup'))
{
echo '
<a href="/admin/?cmd=addinfo&id='.$id.'">добавить инфоблок</a><br><br>
<a href="/admin/?cmd=addgallery&id='.$id.'">добавить фотогалерею</a>
';
}
}
else
{
echo '
<a href="/admin/?cmd=addphoto&id='.$id.'">добавить фото</a>
';
}
}
else
{
echo '
<a href="/admin/?cmd=addnewsform&id='.$id.'">добавить новость</a><br><br>
';
}
echo '
</td>
<td valign="top">
';

echo $c_path;

$db = mysql_connect('localhost','borstroi_user1','159357') ;
mysql_select_db('borstroi_db', $db);
$rs = mysql_query("SET NAMES utf8");
$qr = "SELECT * FROM tree WHERE (tree.group>0 AND tree.parent=".$id.") ORDER BY tree.group ASC, tree.number DESC";
$rs = mysql_query($qr);


if($rs){
echo '<table cellspacing="0px" cellpadding="8px" border="0" width="100%">';
echo '<tbody>';
if($grp==4)
{
echo '<tr>';
echo '<td>';

echo '<div class="thumbnails">';
}
while($row = mysql_fetch_assoc($rs))
{

if($grp!=4)
{
$bg='d8e4d0';
if($row['group']==1)$bg='eeeeee';
if($row['group']==2)$bg='d8e4d0';
if($row['group']==3)$bg='ccaa77';
if($row['group']==4)$bg='77aadd';
if($row['group']==10)$bg='aaaadd';
echo '<tr>';
if(($row['group']==1)||($row['group']==10)||($row['group']==4))echo '<td><div style="background-color:#'.$bg.';width:100%;padding:6px;"><a href="/admin/?cmd=editgroup&id='.$row['number'].'"><b>'.$row['title'].'</b></a></div>http://bsi.dp.ua/page-'.$row['number'].'.html</td>'; else echo '<td><div style="background-color:#'.$bg.';width:100%;padding:6px;"><b>'.$row['title'].'</b></div>http://bsi.dp.ua/page-'.$row['number'].'.html</td>'; 
if($row['show']==1)$onoff='n';
if($row['show']==0)$onoff='ff';
echo '<td width="44px"><a href="/admin/?cmd=editfolderitem&id='.$row['number'].'"><img src="/admin/images/conf.jpg"></a></td>';
echo '<td width="44px"><a href="/admin/?cmd=shfolderitem&id='.$row['number'].'"><img src="/admin/images/display_o'.$onoff.'.jpg"></a></td>';
echo '<td width="44px"><a href="/admin/?cmd=delfolderitem&id='.$row['number'].'"><img src="/admin/images/remove.jpg"></a></td>';
echo '</tr>';
}
else
{
echo '
    <ins class="thumbnail">
        <div class="r">
            <img src="/images/th-'.$row['image'].'.jpg"><br>
            <div style="padding-top:5px;">
            '.$row['title'].'&nbsp;&nbsp;&nbsp;<a href="/admin/?cmd=editfolderitem&id='.$row['number'].'"><img src="/admin/images/edit_icon.gif"></a>&nbsp;&nbsp;&nbsp;<a href="/admin/?cmd=delfolderitem&id='.$row['number'].'"><img src="/admin/images/erase_icon.gif"></a>
            </div>
        </div>
    </ins>
';
}

}
mysql_free_result($rs);
if($grp==4)
{
echo '</div>';
echo '</td>';
echo '</tr>';

}

echo '</tbody>';
echo '</table>';
}

mysql_close();

echo '
</td>
</tr>
<tr>
<td>
';


$db = mysql_connect('localhost','borstroi_user1','159357') ;
mysql_select_db('borstroi_db', $db);
$rs = mysql_query("SET NAMES utf8");
$qr = "SELECT * FROM tree WHERE tree.number=".$id;
$rs = mysql_query($qr);

if($rs){
$row = mysql_fetch_assoc($rs);
$nm=$row['title'];
$dsc=$row['desc'];
$subdsc=$row['desc'];
$ttl=$row['p_title'];
$kw=$row['p_keys'];
$dscr=$row['p_desc'];
$grp=$row['group'];
}

if($id!=4)
{

$tt='';
$tt1=0;
if($grp==0)$tt='Редактирование раздела';
if($grp==1)$tt='Редактирование подраздела';
if($grp==2)$tt='Редактирование ссылки';
if($grp==3)$tt='Редактирование инфоблока';
if($grp==4)$tt='Редактирование галереи';
if($grp==5)$tt='Редактирование фото';
if($grp==10)$tt='Редактирование новости';
echo '
<table width="100%" cedllspacing="0" cellpadding="8px" border="0">
<tbody>
<tr>
<td>
<br>

<form action="/admin/?cmd=update&id='.$id.'" method="POST" enctype="multipart/form-data">
<div style="padding:5px; border-bottom:solid 1px #dddddd;">
<h3>'.$tt.':</h3>
</div>
<div style="padding:10px; border-bottom:solid 1px #dddddd;">
<b>Название:</b><br>
<input name="name" class="input_text" type="text" value="'.$nm.'"><br>
';
if(($grp==5)||($grp==10))
{
echo '
<b>Фото:</b><br>
<input name="photo" class="input_text" type="file" onchange="document.getElementById(\'img1\').src=this.value;"><br>
<img id="img1" src="/images/th-'.$row['image'].'.jpg" width="150px"><br>
';
}
if($grp==10)
{
echo '
<b>Предварительное описание:</b><br>
';
$CKEditor = new CKEditor();

$CKEditor->returnOutput = true;

$CKEditor->basePath = '/admin/_include/ckeditor/';

$CKEditor->config['width'] = "100%";
$CKEditor->config['height'] = 200;

$CKEditor->textareaAttributes = array("cols" => 80, "rows" => 10);

$initialValue = $subdsc;


CKFinder::SetupCKEditor( $CKEditor, '/admin/_include/ckfinder/' ) ;

$code = $CKEditor->editor("subdesc", $initialValue);

echo $code;

}

echo '
<b>Описание:</b><br>
';
// Include the CKEditor class.


$CKEditor = new CKEditor();

$CKEditor->returnOutput = true;

$CKEditor->basePath = '/admin/_include/ckeditor/';

$CKEditor->config['width'] = "100%";
$CKEditor->config['height'] = 400;

$CKEditor->textareaAttributes = array("cols" => 80, "rows" => 10);

// The initial value to be displayed in the editor.
$initialValue = $dsc;

CKFinder::SetupCKEditor( $CKEditor, '/admin/_include/ckfinder/' ) ;

// Create the first instance.
$code = $CKEditor->editor("desc", $initialValue);

echo $code;


echo '
</div>
<div style="padding:10px; border-bottom:solid 1px #dddddd;">
<b>SEO:</b><br>
<b>Title:</b><br>
<input name="title" class="input_text" type="text" value="'.$ttl.'"><br>
<b>Keywoards:</b><br>
<input name="keywoards" class="input_text" type="text" value="'.$kw.'"><br>
<b>Description:</b><br>
<input name="description" class="input_text" type="text" value="'.$dscr.'"><br>
</div>
<div style="padding:10px;">
<input name="grp" type="hidden" value="'.$grp.'"><br>

<input class="input_button" type="submit" value="Сохранить"><br>
</div>
</form>

</td>
</tr>
</tbody>
</table>
';

mysql_close();
echo '
</td>
</tr>
</tbody>
</table>
';

}


}

if($cm=='addfolder')
{
echo '
<table width="100%" cedllspacing="0" cellpadding="8px" border="0">
<tbody>
<tr>
<td align="right" colspan="2" style="background-color:#3E5A2A; color:#ffffff;"><a href="/admin/?cmd=profile" style="color:white;">Профиль</a>&nbsp;&nbsp;&nbsp;<a href="/admin/?cmd=logout" style="color:white;">Виход</a>&nbsp;</td>
</tr>
<tr>
<td colspan="2" style="background-color:#3E5A2A; color:#ffffff;"></td>
</tr>
<tr>
<td width="150px" valign="top" style="border-right:solid 1px #ffffff; background-color:#3E5A2A; color:#ffffff;" class="left_menu"><a href="/admin/?cmd=addfolder">добавить раздел</a></td>
<td>
'.$c_path.'
<br>

<form action="/admin/?cmd=addfcmd" method="POST">
<div style="padding:5px; border-bottom:solid 1px #dddddd;">
<h3>Новый раздел:</h3>
</div>
<div style="padding:10px; border-bottom:solid 1px #dddddd;">
<b>Название:</b><br>
<input name="name" class="input_text" type="text"><br>
<b>Описание:</b><br>
';

// Include the CKEditor class.


$CKEditor = new CKEditor();

$CKEditor->returnOutput = true;

$CKEditor->basePath = '/admin/_include/ckeditor/';

$CKEditor->config['width'] = "100%";
$CKEditor->config['height'] = 400;


$CKEditor->textareaAttributes = array("cols" => 80, "rows" => 10);

// The initial value to be displayed in the editor.
$initialValue = '';

CKFinder::SetupCKEditor( $CKEditor, '/admin/_include/ckfinder/' ) ;

// Create the first instance.
$code = $CKEditor->editor("desc", $initialValue);

echo $code;

echo '
</div>
<div style="padding:10px; border-bottom:solid 1px #dddddd;">
<b>SEO:</b><br>
<b>Title:</b><br>
<input name="title" class="input_text" type="text"><br>
<b>Keywoards:</b><br>
<input name="keywoards" class="input_text" type="text"><br>
<b>Description:</b><br>
<input name="description" class="input_text" type="text"><br>
</div>
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


if($cm=='addphoto')
{
echo '
<table width="100%" cedllspacing="0" cellpadding="8px" border="0">
<tbody>
<tr>
<td align="right" colspan="2" style="background-color:#3E5A2A; color:#ffffff;"><a href="/admin/?cmd=profile" style="color:white;">Профиль</a>&nbsp;&nbsp;&nbsp;<a href="/admin/?cmd=logout" style="color:white;">Выход</a>&nbsp;</td>
</tr>
<tr>
<td colspan="2" style="background-color:#3E5A2A; color:#ffffff;"></td>
</tr>
<tr>
<td width="150px" valign="top" style="border-right:solid 1px #ffffff; background-color:#3E5A2A; color:#ffffff;" class="left_menu"><a href="/admin/?cmd=addphoto&id='.$id.'">добавить фото</a></td>
<td>
'.$c_path.'
<br>

<form action="/admin/?cmd=addpcmd&id='.$id.'" method="POST" enctype="multipart/form-data">
<div style="padding:5px; border-bottom:solid 1px #dddddd;">
<h3>Новое фото:</h3>
</div>
<div style="padding:10px; border-bottom:solid 1px #dddddd;">
<b>Название:</b><br>
<input name="name" class="input_text" type="text"><br>
<b>Фото:</b><br>
<input name="photo" class="input_text" type="file" onchange="document.getElementById(\'img1\').src=this.value;"><br>
<img id="img1" src="" width="150px"><br>
<b>Описание:</b><br>';

// Include the CKEditor class.


$CKEditor = new CKEditor();

$CKEditor->returnOutput = true;

$CKEditor->basePath = '/admin/_include/ckeditor/';

$CKEditor->config['width'] = "100%";
$CKEditor->config['height'] = 400;


$CKEditor->textareaAttributes = array("cols" => 80, "rows" => 10);

// The initial value to be displayed in the editor.
$initialValue = '';

CKFinder::SetupCKEditor( $CKEditor, '/admin/_include/ckfinder/' ) ;

// Create the first instance.
$code = $CKEditor->editor("desc", $initialValue);

echo $code;

echo '
</div>
<div style="padding:10px;">
<input name="grp" type="hidden" value="5">
<input class="input_button" type="submit" value="Сохранить"><br>
</div>
</form>

</td>
</tr>
</tbody>
</table>
';
}

if(($cm=='addlink')||($cm=='addinfo')||($cm=='addgallery')||($cm=='addsubfolder')||($cm=='addnewsform'))
{
$tt='';
$tt1=0;
if($cm=='addsubfolder')$tt='Новый подраздел';
if($cm=='addlink')$tt='Новая ссылка';
if($cm=='addinfo')$tt='Новый инфоблок';
if($cm=='addgallery')$tt='Новая галерея';
if($cm=='addnewsform')$tt='Добавление новости';
if($cm=='addsubfolder')$tt1=1;
if($cm=='addlink')$tt1=2;
if($cm=='addinfo')$tt1=3;
if($cm=='addgallery')$tt1=4;
if($cm=='addnewsform')$tt1=10;
echo '
<table width="100%" cedllspacing="0" cellpadding="8px" border="0">
<tbody>
<tr>
<td align="right" colspan="2" style="background-color:#3E5A2A; color:#ffffff;"><a href="/admin/?cmd=profile" style="color:white;">Профиль</a>&nbsp;&nbsp;&nbsp;<a href="/admin/?cmd=logout" style="color:white;">Выход</a>&nbsp;</td>
</tr>
<tr>
<td colspan="2" style="background-color:#3E5A2A; color:#ffffff;"></td>
</tr>
<tr>
<td width="150px" valign="top" style="border-right:solid 1px #ffffff; background-color:#3E5A2A; color:#ffffff;" class="left_menu">
';
if($cm!='addnewsform')
{
echo '
<a href="/admin/?cmd=addsubfolder&id='.$id.'">добавить подраздел</a><br><br>
<a href="/admin/?cmd=addlink&id='.$id.'">добавить ссылку</a><br><br>
<a href="/admin/?cmd=addinfo&id='.$id.'">добавить инфоблок</a><br><br>
<a href="/admin/?cmd=addgallery&id='.$id.'">добавить фотогалерею</a>
';
}
if($cm=='addnewsform')
{
echo '
<a href="/admin/?cmd=addnewsform&id='.$id.'">добавить новость</a>
';
}
echo '
</td>
<td>
'.$c_path.'
<br>

<form action="/admin/?cmd='.$cm.'cmd&id='.$id.'" method="POST">
<div style="padding:5px; border-bottom:solid 1px #dddddd;">
<h3>'.$tt.':</h3>
</div>
<div style="padding:10px; border-bottom:solid 1px #dddddd;">
<b>Название:</b><br>
<input name="name" class="input_text" type="text"><br>
';

if(($tt1==3)||($tt1==10))
{
echo '
<b>Фото:</b><br>
<input name="photo" class="input_text" type="file" onchange="document.getElementById(\'img1\').src=this.value;"><br>
<img id="img1" src="" width="150px"><br>
';
}

if($tt1==10)

{
echo '
<b>Предварительное описание:</b><br>
';


// Include the CKEditor class.


$CKEditor = new CKEditor();

$CKEditor->returnOutput = true;

$CKEditor->basePath = '/admin/_include/ckeditor/';

$CKEditor->config['width'] = "100%";
$CKEditor->config['height'] = 150;


$CKEditor->textareaAttributes = array("cols" => 80, "rows" => 10);

// The initial value to be displayed in the editor.
$initialValue = '';

CKFinder::SetupCKEditor( $CKEditor, '/admin/_include/ckfinder/' ) ;

// Create the first instance.
$code = $CKEditor->editor("subdesc", $initialValue);

echo $code;
}

echo '
<b>Описание:</b><br>
';


// Include the CKEditor class.


$CKEditor = new CKEditor();

$CKEditor->returnOutput = true;

$CKEditor->basePath = '/admin/_include/ckeditor/';

$CKEditor->config['width'] = "100%";
$CKEditor->config['height'] = 400;


$CKEditor->textareaAttributes = array("cols" => 80, "rows" => 10);

// The initial value to be displayed in the editor.
$initialValue = '';

CKFinder::SetupCKEditor( $CKEditor, '/admin/_include/ckfinder/' ) ;

// Create the first instance.
$code = $CKEditor->editor("desc", $initialValue);

echo $code;

echo '
</div>
<div style="padding:10px; border-bottom:solid 1px #dddddd;">
<b>SEO:</b><br>
<b>Title:</b><br>
<input name="title" class="input_text" type="text"><br>
<b>Keywoards:</b><br>
<input name="keywoards" class="input_text" type="text"><br>
<b>Description:</b><br>
<input name="description" class="input_text" type="text"><br>
</div>
<div style="padding:10px;">
<input name="grp" type="hidden" value="'.$tt1.'"><br>

<input class="input_button" type="submit" value="Сохранить"><br>
</div>
</form>

</td>
</tr>
</tbody>
</table>
';
}


if($cm=='editfolderitem')
{



$db = mysql_connect('localhost','borstroi_user1','159357') ;
mysql_select_db('borstroi_db', $db);
$rs = mysql_query("SET NAMES utf8");
$qr = "SELECT * FROM tree WHERE tree.number=".$id;
$rs = mysql_query($qr);

if($rs){
$row = mysql_fetch_assoc($rs);
$nm=$row['title'];
$dsc=$row['desc'];
$ttl=$row['p_title'];
$kw=$row['p_keys'];
$dscr=$row['p_desc'];
$grp=$row['group'];
}

$tt='';
$tt1=0;
if($grp==0)$tt='Редактирование раздела';
if($grp==1)$tt='Редактирование подраздела';
if($grp==2)$tt='Редактирование ссылки';
if($grp==3)$tt='Редактирование инфоблока';
if($grp==4)$tt='Редактирование галереи';
if($grp==5)$tt='Редактирование фото';
echo '
<table width="100%" cedllspacing="0" cellpadding="8px" border="0">
<tbody>
<tr>
<td align="right" colspan="2" style="background-color:#3E5A2A; color:#ffffff;"><a href="/admin/?cmd=profile" style="color:white;">Профиль</a>&nbsp;&nbsp;&nbsp;<a href="/admin/?cmd=logout" style="color:white;">Выыход</a>&nbsp;</td>
</tr>
<tr>
<td colspan="2" style="background-color:#3E5A2A; color:#ffffff;"></td>
</tr>
<tr>
<td width="150px" valign="top" style="border-right:solid 1px #ffffff; background-color:#3E5A2A; color:#ffffff;" class="left_menu">
<a href="/admin/?cmd=addsubfolder&id='.$id.'">добавить подраздел</a><br><br>
<a href="/admin/?cmd=addlink&id='.$id.'">добавить ссылку</a><br><br>
<a href="/admin/?cmd=addinfo&id='.$id.'">добавить инфоблок</a><br><br>
<a href="/admin/?cmd=addgallery&id='.$id.'">добавить фотогалерею</a>
</td>
<td>
'.$c_path.'
<br>

<form action="/admin/?cmd=update&id='.$id.'" method="POST" enctype="multipart/form-data">
<div style="padding:5px; border-bottom:solid 1px #dddddd;">
<h3>'.$tt.':</h3>
</div>
<div style="padding:10px; border-bottom:solid 1px #dddddd;">
<b>Название:</b><br>
<input name="name" class="input_text" type="text" value="'.$nm.'"><br>
';
if($grp==5)
{
echo '
<b>Фото:</b><br>
<input name="photo" class="input_text" type="file" onchange="document.getElementById(\'img1\').src=this.value;"><br>
<img id="img1" src="/images/th-'.$row['image'].'.jpg" width="150px"><br>
';
}
echo '
<b>Описание:</b><br>
';
// Include the CKEditor class.


$CKEditor = new CKEditor();

$CKEditor->returnOutput = true;

$CKEditor->basePath = '/admin/_include/ckeditor/';

$CKEditor->config['width'] = "100%";
$CKEditor->config['height'] = 400;


$CKEditor->textareaAttributes = array("cols" => 80, "rows" => 10);

// The initial value to be displayed in the editor.
$initialValue = $dsc;

CKFinder::SetupCKEditor( $CKEditor, '/admin/_include/ckfinder/' ) ;

// Create the first instance.
$code = $CKEditor->editor("desc", $initialValue);

echo $code;


echo '
</div>
<div style="padding:10px; border-bottom:solid 1px #dddddd;">
<b>SEO:</b><br>
<b>Title:</b><br>
<input name="title" class="input_text" type="text" value="'.$ttl.'"><br>
<b>Keywoards:</b><br>
<input name="keywoards" class="input_text" type="text" value="'.$kw.'"><br>
<b>Description:</b><br>
<input name="description" class="input_text" type="text" value="'.$dscr.'"><br>
</div>
<div style="padding:10px;">
<input name="grp" type="hidden" value="'.$grp.'"><br>

<input class="input_button" type="submit" value="Сохранить"><br>
</div>
</form>

</td>
</tr>
</tbody>
</table>
';

mysql_close();

}



if($cm=='')
{
echo '
<table width="100%" cedllspacing="0" cellpadding="8px" border="0">
<tbody>
<tr>
<td align="right" colspan="2" style="background-color:#3E5A2A; color:#ffffff;"><a href="/admin/?cmd=profile" style="color:white;">Профиль</a>&nbsp;&nbsp;&nbsp;<a href="/admin/?cmd=logout" style="color:white;">Виход</a>&nbsp;</td>
</tr>
<tr>
<td style="background-color:#3E5A2A; color:#ffffff;"></td>
</tr>
<tr>
<td>
'.$c_path.'
<br>

    <h1>Краткое описание административной панели.</h1>

    <p class="title">Выход</p>
    <p class="text">

        Это кнопка расположенная в правом верхнем углу с тривиальным названием, - "Выход".
        И предназначена для выхода из под пользователя с привилегиями.
    </p>

    <p class="title">Профиль</p>
    <p class="text">
        Это кнопка расположенная в правом верхнем углу с тривиальным названием, - "Профиль".
        В данном разделе вы можете делать корректировки (изменения) своего текущего профиля.
        Содержит поля:
        <ul>
            <li>
                Ваш E-Mail
            </li>

            <li>
                Название сайта
            </li>
            <li>
                Ваш Телефон
            </li>
            <li>
                Смена пароля
            </li>
        </ul>

        Каждое из полей имеет интуитивно понятный интерфейс, так же к каждому полу прикреплен помощник который сообщит вам если вы не верно заполните какое либо из выше указанных полей.
    </p>

    
    <p class="text">
        Обратите внимание на панель слева от вас, с название - "Подменю".
        На данной панели присутствует ссылка с броским название - "Создать раздел".<br />
        - Зачем она? <br />
        Она предназначена для создания нового раздела. <br />

        - Что такое этот ваш раздел? <br />
        Раздел это ваши странички на сайте. Например если вы создадите раздел, с таинственным и пугающим названием,- "Главная".
        То не объяснимым образом у вас на сайте появится страничка с названием "Главная". <br />
        - Почему "Главная", я хочу назвать "Маруся" <br />
        Мы щастливы вам сообщить что вы можете придумать для своего раздела любое название, которое вы посчитаете нужным!<br />
        И так мы надеемся что у вас все получилось и вы создали один, а может и пару разделов и если вы успели заметить то справа от
        левой панели появились какие то зеленые полосочки и на этих полосочках буковки и какие то красивые иконки. <br />
        - Что это? <br />

        И так, буковки - это названия наших подменю, а полосочки это лишь декоративный элемент. Иконки в виде стрелочек на полосочках
        предназначены для расположения подразделов(которые наглым образом являются страничками на нашем сайте) в том порядке который вам
        больше нравится. <br />
        - А молоточек и ключик? А еще эта корзина?  <br />
        Не спешите все по порядку, и так, молоточек и ключик, если вы на них нажмете у вас появится шанс изменить название раздела,
        если вы этого хотите, конечно : ). Корзинка с названием, не побоюсь этого слова, - "Удалить". При нажатии на коею у вас появится
        диалоговое окно с просьбой подтвердить искренность и непоколебимость ваших намерений.. И так нажатие на эту иконку приведет к
        удалению раздела. Внимание удаленный раздел восстановлению не подлежит и студия hexlife не несет ответственности за ваши, опрометчивые
        действия!
    </p>

    <p class="title">Оформить раздел, или что с ним делать.</p>
    <p class="text">
        И так мы создали новый раздел, и у нас, рядом с "Редактировать разделы", появилась кнопочка с именем вновь созданного раздела.
        Нажмите на нее, нуже не бойтесь... Жмите!<br />

        И так, когда мы нажали на нее, что мы видем? <br />
        Пустую страничку и зеленое подменю с лева. <br />
        В котором присутствуют такие пункты:
        <ul>
           <li>Создать подраздел</li>
           <li>Создать титулку</li>
        </ul>

        - Зачем они нужны? <br />
        Они нужны для полной демократии, то есть для вашего выбора, после того как вы создали страничку перед вами стоит выбор:<br />
        - А что я хочу от своей странички?<br />
        Если вы выберете пункт "Создать титулку" то ваша страничка приобретет вид статической, то есть когда на нее кто то зайдет он уведет
        то что вы напишете на вашей титульной страничке. <br />
        - Хорошо, а что будит если я нажму "Создать подраздел"? <br />
        В общем ничего и не будет, когда пользователь зайдет на эту страничку он увидит список тех подразделов которые вы создадите.
        Для примера это лента новостей. То есть когда вы попадаете на страничку новости вы ведете список новостей отсортированных по дате,
        или каким либо другим признакам. То, есть по суди ваша страничка обретет вид большого раздела с небольшими подраздельчиками.
        Если вы хотите превратить страничку в статическую в любой момент можете нажать "Создать титулку" и ваша страничка приобретет вид
        статической. <br />

        Внимание! К сожалению в данной версии административной панели не предусмотрен возврат от к статической страничке к каталогу с
        подразделами по этому, прежде чем сделать раздел статическим хорошо подумайте.
    </p>

    <p class="title">Заключение</p>
    <p class="text">
        Студия web дизайна hexlife признательна вам за выбор именно нашей продукции.
        <ul>
            <comment>Разработчики:</comment>
            <li>hexan - Дизайн и оформление.           </li>

            <li>flayna - Тестирование проекта.         </li>
            <li>kialtiB - Разработка программного кода. </li>
        </ul>
    </p>

</td>
</tr>
</tbody>
</table>
';
}

echo '
</body>
</html>
';
?>