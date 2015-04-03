<?php
    /*connect to database */
    include("sql.php");


    if($_POST['id'])
    {
        $id=mysql_escape_String($_POST['id']);
        // Vote update  
        mysql_query("update projects set likes=likes+1 where pID='$id'");
        // Getting latest vote results

    }
?>