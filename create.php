<?php
	session_start();
    if ($_SESSION['login'] != "1"){
        header ("Location: login.php");
    }
    //if ($_SERVER['REQUEST_METHOD'] == 'POST') {}
?>
<?php include("assets/templates/header.php"); ?>
	<style>
  		.about {background-image: url("/assets/images/clouds.jpg");
  				background-size: cover;
  				background-repeat: no-repeat;}
	</style>
	<section class="about section promo">
		<div class="container">
	        <br>
            <br>
	        <br>
	        <h1 class="title text-center"> <font color="white">Create a</font> <span class="highlight">Project</span></h1>
	        <h2 class="title text-center"> 
		        <form action="create2.php" method="post" class="intro text-center">
		        	<font color="white">
		        	I want to start a <select name="type" class="select-style">
			        	<option>Art</option>
			        	<option>Technology</option>
			        	<option>Music</option>
			        	<option>Photography</option>
			        	<option>Food</option>
			        	<option>Film and Video</option>
			        	<option>Design</option>
			        	<option>Games</option>
		        	</select> project.   </font>
		        	<br>
		        	<br>
	                <input type="title" name="title" placeholder="Project Title" class="tb1"><br>
	                <br>
	                <input type="submit" value="Create!" class="btn btn-cta-primary">
	                <br>
	            </form>
            </h2>
	    </div>
    </section>
<?php include("assets/templates/footer.html"); ?>