<?php
	session_start();
    if ($_SESSION['login'] != "1"){
        header ("Location: login.php");
    }
?>
<?php include("assets/templates/header.php"); ?>
<?php include("assets/templates/footer.html"); ?>