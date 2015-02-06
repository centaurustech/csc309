<?php
	session_start();
    if ($_SESSION['login'] != "1"){
        header ("Location: login.php");
    }
    //if ($_SERVER['REQUEST_METHOD'] == 'POST') {}
?>
<?php include("assets/templates/header.php"); ?>
<style>
  .about {background-image: url("/assets/images/clouds.jpg");}
</style>
	<section class="about section" >
		<div class="container">
	        <br>
	        <br>
	        <h2 class="title text-center">I want to start a  
	        	<select class="select-style">
	        	<option>Art</option>
	        	<option>Technology</option>
	        	<option>Music</option>
	        	<option>Photography</option>
	        	<option>Food</option>
	        	<option>Film and Video</option>
	        	<option>Design</option>
	        	<option>Games</option>
	        	</select> project.
	        </h2>
	        
	    </div>
    </section>
<?php include("assets/templates/footer.html"); ?>