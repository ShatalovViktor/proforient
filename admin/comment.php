<?
include('admin/settings.php');




$content_id = $_GET['id'];  // это ключевой идентификатор от конкретной статьи(комменты то разные в каждой статье, помним?)



$db = mysql_connect($db_server,$db_user,$db_pass) or die("Could not connect: ".mysql_error());
mysql_select_db($db_name, $db) or die("Could not select: ".mysql_error());
mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER SET 'utf8'");
/*----удаление всех комментариев ---*/

/*if($_GET['op'] === 'clear-all'){
  $qr="DELETE FROM les_comments WHERE les_comments.content_id=".$id_comment;
  mysql_query($qr);
  header("Location: ?cmd=editgroup&id=".$content_id);
}*/

/*----------------------------------**/
/*удаление комментарии*/
if($_GET['op'] === 'clear-one'){
  $id_comment=$_GET['id_comment'];
  //echo $id_comment;
  $qr="DELETE FROM les_comments WHERE les_comments.id=".$id_comment;
  mysql_query($qr);
  header("Location: ?cmd=editgroup&id=".$content_id);
}
$time = time();
  
// выводим комменты
$msg = array();
$result = mysql_query("SELECT * FROM les_comments WHERE content_id='$content_id'order by id DESC");
while($row = mysql_fetch_assoc($result)){
  $msg[] = $row;
}
mysql_close();

$count = count($msg);

$parent = 0;
$j = 0;
if($count){
  $comments = "<div class='comments-all'><span style='float:left'>Всего комментариев: {$count}</span><span class='add-comment'>Написать комментарий</span></div>".$form;
 
 // $msg = crazysort($msg);
  
  while($j<$count){
    $margin = $msg[$j]['level'] * 20;
    $date = date("d.m.Y в H:i",$msg[$j]['time']);
	$id_com=$msg[$j]['id'];	    
    $comments .= "<div id='msg{$msg[$j]['id']}' style='margin-left: {$margin}px'><div class='comment-title'><span style='float:left'><b>{$msg[$j]['name']}</b> <small>({$date})</small></span><a style=\"float:right;\" href='?cmd=editgroup&id=".$content_id."&op=clear-one&id_comment=".$id_com."'>Удалить</a></div><div class='comment-message'>{$msg[$j]['comment']}</div></div>";
    $j++;
  }  
}else{
  $comments = "Комментариев пока еще нет";
}



// функция сортирует массив по деревьям
function crazysort(&$comments, $parentComment = 0, $level = 0, $count = null){
  if (is_array($comments) && count($comments)){
    $return = array();
    if (is_null($count)){
      $c = count($comments);
    }else{
      $c = $count;
    }
    for($i=0;$i<$c;$i++){
      if (!isset($comments[$i])) continue;
      $comment = $comments[$i];
      $parentId = $comment['parent_id'];
      if ($parentId == $parentComment){
        $comment['level'] = $level;
        $commentId = $comment['id'];
        $return[] = $comment;
        unset($comments[$i]);
        while ($nextReturn = crazysort($comments, $commentId, $level+1, $c)){
          $return = array_merge($return, $nextReturn);
        }
      }
    }
    return $return;
  }
  return false;
}
?>

<div style='margin:0 auto; width:780px'>
<?
echo $comments;
//echo "<center><a href='?cmd=editgroup&id=".$content_id."&op=clear-all'>очистить все комменты</a></center>";
?>
</div>
<script>
$(function () {
  $('.add-comment').click(function(){
    var editor = $('.editor');
    if (editor.is(":hidden")){
      editor.slideDown();
    }else{
      editor.slideUp();
    }
    return false;
  });
  
  $('.comment-ans').click(function(){
    var $editor = $('.editor');
    $editor.hide();
    var mid = $(this).attr("id");
    var clone = $editor.clone();
    $editor.remove();
    setTimeout(function(){
      $(clone).css("margin", "5px 0 5px 20px");
      $(clone).insertAfter("div#msg"+mid).slideDown();
      $("input[name=parent]").val(mid);
    }, 200);
  });
    
});
</script>
</body>
</html>
