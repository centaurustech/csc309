<?php
    /*connect to database */
    $user_name = "root";
    $pass_word = "csc309";
    $database = "users";
    $server = "104.236.231.174:3306";

    $db_handle = mysql_connect($server, $user_name, $pass_word);
    $db_found = mysql_select_db($database, $db_handle);


    if($_POST['id'])
    {
        $id=mysql_escape_String($_POST['id']);
        // Vote update  
        mysql_query("update projects set dislikes=dislikes+1 where pID='$id'");
    }
?>