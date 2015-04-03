<?php
$id = $_GET['id'];
 /*connect to database */
include("sql.php");
mysql_query("DELETE FROM projects WHERE pID='$id'");
mysql_query("DELETE FROM communities WHERE pID='$id'");

header ("Location: browse.php");
?>