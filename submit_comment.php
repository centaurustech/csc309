<?php
session_start();
include "sql.php";
mysql_query("INSERT INTO comments(comment, userid, pid) VALUES ('".$_POST["body"]."', '".$_SESSION['current_user_id']."', '".$_GET['pid']."')");
?>