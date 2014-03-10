<?php

if (isset($_POST["nameRayon"])):
    include("/../../settings.php");
    $nameRayon=htmlspecialchars($_POST["nameRayon"]);
    $db = mysql_connect($db_server,$db_user,$db_pass) ;
    mysql_select_db($db_name, $db);$rs = mysql_query("SET NAMES utf8");
    $qr = "SELECT id,number FROM schools WHERE rayon='".$nameRayon."'";
    $rs = mysql_query($qr);
    if ($rs)
    {
        ?>
        <b>За какие школы отвечает пользователь:</b><br />
        <select name="schools[]" size="6" id="schools" class="input_text large_input" multiple="multiple" required="required">
        <?
        while($row = mysql_fetch_assoc($rs))
        {?>
            <option value="<?php echo $row['id'];?>"><?php echo $row['number'];?></option>
       <?}?>
        </select>

<?
    }

endif;
?>