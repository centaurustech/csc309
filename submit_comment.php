<?php
session_start();
include "sql.php";
$comment = htmlspecialchars($_POST["body"]);
mysql_query("INSERT INTO comments(comment, userid, pid) VALUES ('".$comment."', '".$_SESSION['current_user_id']."', '".$_GET['pid']."')");
?>