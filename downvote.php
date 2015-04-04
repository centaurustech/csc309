<?php
    /*connect to database */
    include("sql.php");
    
    if($_POST['id'])
    {
        $id=mysql_escape_String($_POST['id']);
        // Vote update  
        mysql_query("update projects set dislikes=dislikes+1 where pID='$id'");
    }
?>